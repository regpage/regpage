<?php

	/*******************************************************************************************************************
	 * 	РАЗРАБОТКА
	 * 
	 * 	ОПИСАНИЕ
	 * 	Модуль ведения журнала лога write_to_log.
	 * 	Публичные методы класса write_to_log вызываются статически, например write_to_log::info('Текст для записи в лог')
	 * 	Всего 5 методов: info($text), debug($text), warning($text), errors($text), fatal($text).
	 * 	Каждый метод создаёт новую запись в логе соответствующую названию метода.
	 * 	Методы принимают один строчный аргумент. Если аргумент не строка, он не будет записан в лог.
	 * 	Название файла лога logFile_ТЕКУЩЕЕ_ВРЕМЯ_И_ДАТА.log
	 * 	Для работы модуля необходимо создать папку log/ в корне сайта, разместить файл и подключить класс в проект.
	 * ******************************************************************************************************************/

class write_to_log {

	static function writer($msg, $type='INFO') {
		if (!is_string($msg)){
			$msg = 'The message is not a string. '.date('d-m-Y H:i:s');
		}

		$logAdminName = 'SERVER';
		$logAdminRole = 'SUPERVISOR';

		$file = 'logs/logFile_'.date("d-m-Y").'.log'; // Добавим текущую дату в наименование файла
		//Добавим разделитель, чтобы мы смогли отличить каждую запись
		$text = $type.' ==================================================='.PHP_EOL;
		$text .=  date('d-m-Y H:i:s') .PHP_EOL; //Добавим актуальную дату после текста или дампа массива
		$text .= 'Admin is '.$logAdminName.'. Role is '.$logAdminRole.'.'.PHP_EOL;
		$text .= $msg.PHP_EOL.PHP_EOL;

		$fOpen = fopen($file,'a'); //Открываем файл или создаём если его нет
		fwrite($fOpen, $text); //Записываем
		fclose($fOpen); //Закрываем файл
	}

	# 'INFO'
	static function info($msg=false) {
		self::writer($msg);
	}

	# 'DEBUG'
	static function debug($msg=false) {
		self::writer($msg, 'DEBUG');
	}

	# 'WARNING'
	static function warning($msg=false) {
		self::writer($msg, 'WARNING');
	}

	# 'ERRORS'
	static function errors($msg=false) {
		self::writer($msg, 'ERRORS');
	}

	# 'FATAL'
	static function fatal($msg=false) {
		self::writer($msg, 'FATAL');
	}
}

?>
