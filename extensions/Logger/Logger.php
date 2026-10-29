<?php

declare(strict_types=1);

/** Простое дневное файловое логирование для PHP 7.4+. */
final class Logger
{
    private const SEPARATOR = '=========================';
    private const LEVELS = ['INFO', 'DEBUG', 'ERROR', 'FATAL'];

    /** @var string */
    private $directory;

    /**
     * @param string|null $directory Каталог журналов; по умолчанию logs рядом с этим файлом.
     */
    public function __construct(?string $directory = null)
    {
        $this->directory = $directory ?? __DIR__ . DIRECTORY_SEPARATOR . 'logs';
    }

    public function info(string $message, array $context = []): void
    {
        $this->log('INFO', $message, $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log('DEBUG', $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log('ERROR', $message, $context);
    }

    public function fatal(string $message, array $context = []): void
    {
        $this->log('FATAL', $message, $context);
    }

    /** Записывает одну запись журнала. FATAL сам по себе не перехватывает ошибки PHP. */
    public function log(string $level, string $message, array $context = []): void
    {
        $level = strtoupper($level);
        if (!in_array($level, self::LEVELS, true)) {
            throw new \InvalidArgumentException('Неизвестный уровень логирования: ' . $level);
        }

        $now = new \DateTimeImmutable('now');
        $message = str_replace(["\r", "\n"], ['\\r', '\\n'], $message);
        $entry = sprintf('[%s] [%s] %s', $now->format('Y-m-d H:i:s'), $level, $message);

        if ($context !== []) {
            try {
                $json = json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
            } catch (\JsonException $exception) {
                throw new \InvalidArgumentException('Не удалось сериализовать контекст лога: ' . $exception->getMessage(), 0, $exception);
            }
            $entry .= ' | context: ' . str_replace(["\r", "\n"], ['\\r', '\\n'], $json);
        }

        $entry .= PHP_EOL . self::SEPARATOR . PHP_EOL;
        $this->ensureDirectory();

        $file = $this->directory . DIRECTORY_SEPARATOR . $now->format('d.m.Y') . '.log';
        $this->appendToFile($file, $entry);
    }

    private function ensureDirectory(): void
    {
        if (is_dir($this->directory)) {
            return;
        }

        if (file_exists($this->directory)) {
            throw new \RuntimeException('Путь для логов существует, но не является каталогом: ' . $this->directory);
        }

        if (!@mkdir($this->directory, 0775, true) && !is_dir($this->directory)) {
            $error = error_get_last();
            $details = $error !== null ? ': ' . $error['message'] : '';
            throw new \RuntimeException('Не удалось создать каталог логов ' . $this->directory . $details);
        }
    }

    private function appendToFile(string $file, string $entry): void
    {
        $warning = null;
        set_error_handler(static function (int $severity, string $message) use (&$warning): bool {
            $warning = $message;
            return true;
        });

        try {
            $written = file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
        } finally {
            restore_error_handler();
        }

        if ($written === false || $written !== strlen($entry)) {
            $details = $warning !== null ? ': ' . $warning : '';
            throw new \RuntimeException('Не удалось полностью записать лог-файл ' . $file . $details);
        }
    }
}
