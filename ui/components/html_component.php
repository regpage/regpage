<?php
/**
 *
 */

abstract class HtmlComponent
{
    protected string $id;
    protected array $classes = [];
    protected array $attributes = [];

    public function __construct(string $id)
    {
      $this->id = $id;
    }
    /**
     * Добавить класс
     */
    public function addClass(string $class): self
    {
      $this->classes[] = $class;
      return $this;
    }
    /**
     * Технический метод для генерации строки: class="value"
     */
    protected function renderClasses(): string
    {
      return $this->classes ? ' class="' . implode(' ', $this->classes) . '"' : '';
    }

    protected function renderId(): string
    {
      return $this->id ? "id='{$this->id}'" : '';
    }

    /**
     * Добавить произвольный атрибут
     */

     /**
      * Массовая установка data-атрибутов из массива
      * ['user-id' => 1, 'role' => 'admin'] -> data-user-id="1" data-role="admin"
      */
     public function setDataAttributes(array $data): self
     {
         foreach ($data as $key => $value) {
            $this->attributes["data-{$key}"] = $value;
         }
         return $this;
     }

     /**
      * Обычный метод для одиночных атрибутов (class, style и т.д.)
      */
     public function setAttribute(string $name, $value): self
     {
         $this->attributes[$name] = $value;
         return $this;
     }

     protected function buildAttributesString(array $source): string
     {
         $html = '';
         foreach ($source as $name => $value) {
             $html .= sprintf(' %s="%s"', htmlspecialchars($name), htmlspecialchars($value));
         }
         return $html;
     }

    // Каждый компонент обязан реализовать этот метод
    abstract public function render(): string;
}
