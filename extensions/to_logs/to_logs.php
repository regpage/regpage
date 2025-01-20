<?php
/******************************************************************************************************************* 
 * 	Модуль ведения журнала лога ToLogs	 
 * 	Публичные методы класса ToLog вызываются статически, например:
 *	ToLog::info(mixed 'Текст заголовка, Обслуживание сервера, код ошибки или ID текущего пользователя', mixed 'Текст для записи в лог или дамб массива/объекта')
 * 	Всего 5 методов:
 *	info($mixed1, $mixed2), debug($mixed1, $mixed2), warning($mixed1, $mixed2), errors($mixed1, $mixed2), fatal($mixed1, $mixed2).
 * 	Каждый метод создаёт новую запись в логе добавляя соответствующий статус warning, info и т.д. 
 * 	Название файла лога logFile_ТЕКУЩЕЕ_ВРЕМЯ_И_ДАТА.log
 * 	НЕ АКТУАЛЬНО Для работы модуля необходимо создать папку logs/ в корне сайта, разместить файл и подключить класс в проект.
 * ******************************************************************************************************************/
class ToLogs {
  // Добавляем строку в лог файл
  static function writer($title, $msg, $type='INFO') {
  	// проверяем тип переменных, преобразовываем при необходимости
  	if (is_array($msg) || is_object($msg) || is_bool($msg)) {
  		$msg = print_r($msg, true);
  	}
  	if (is_array($title) || is_object($title) || is_bool($title)) {
  		$title = print_r($title, true);
  	}
    // задаём имя файла
    $file = 'logFile_'.date("d-m-Y") . '.log';
    // формируем строку для добавления в журнал
    //Добавим разделитель, чтобы мы смогли отличить каждую запись и готовим текст
    $text = '==================================================='.PHP_EOL;    
    $text .=  date('d-m-Y H:i:s') . ' ' . $type . ' '; // Добавим текущую дату тип записи
    $text .= $title . PHP_EOL; // добавим заголовок, ID пользователя или код ошибки
    $text .= $msg.PHP_EOL.PHP_EOL; // текст или дамп массива
	// работаем с файлом
    $fOpen = fopen($file,'a'); //Открываем файл или создаём если его нет
    fwrite($fOpen, $text); //Записываем
    fclose($fOpen); //Закрываем файл
  }
  	# 'INFO'
	static function info($title, $msg='') {
		self::writer($title, $msg);
	}

	# 'DEBUG'
	static function debug($title, $msg='') {
		self::writer($title, $msg, 'DEBUG');
	}

	# 'WARNING'
	static function warning($title, $msg='') {
		self::writer($title, $msg, 'WARNING');
	}

	# 'ERRORS'
	static function errors($title, $msg='') {
		self::writer($title, $msg, 'ERRORS');
	}

	# 'FATAL'
	static function fatal($title, $msg='') {
		self::writer($title, $msg, 'FATAL');
	}
}

