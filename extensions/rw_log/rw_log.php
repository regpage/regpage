<?php

 /*******************************************************************************************************************
	 * 	ОПИСАНИЕ
	 * 	Модуль ведения журнала лога RWLog
	 * 	Публичные методы класса ToLog вызываются статически, например ToLog::info('Текст для записи в лог')
	 * 	Всего 5 методов: info($text), debug($text), warning($text), errors($text), fatal($text).
	 * 	Каждый метод создаёт новую запись в логе соответствующую названию метода.
	 * 	Методы принимают один строчный аргумент. Если аргумент не строка, он не будет записан в лог.
	 * 	Название файла лога logFile_ТЕКУЩЕЕ_ВРЕМЯ_И_ДАТА.log
	 * 	Для работы модуля необходимо создать папку logs/ в корне сайта, разместить файл и подключить класс в проект.
	 * ******************************************************************************************************************/
class RWLog {

  // ADD STRINT TO A LOG FILE
  static function writer($logMemberId, $info, $type='INFO') {
	$logAdminName = '';
	$logAdminRole = '';
		//global $globalPathes;
    $file = realpath('.').DIRECTORY_SEPARATOR.'logs'. DIRECTORY_SEPARATOR.'logFile_'.date("d-m-Y").'.log'; // __DIR__ OR realpath('.'). DIRECTORY_SEPARATOR;
    //Добавим разделитель, чтобы мы смогли отличить каждую запись
    $text = ' ==================================================='.PHP_EOL;
    $text .=  date('d-m-Y H:i:s') .PHP_EOL; //Добавим актуальную дату после текста или дампа массива
    $text .= 'Admin is '.$logAdminName.'. Key is '. $logMemberId.'. Role is '.$logAdminRole.'. '.PHP_EOL;
    $text .= $info.PHP_EOL.PHP_EOL;

    $fOpen = fopen($file,'a'); //Открываем файл или создаём если его нет
    fwrite($fOpen, $text); //Записываем
    fclose($fOpen); //Закрываем файл
  }
  # 'INFO'
	static function info($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg);
	}

	# 'DEBUG'
	static function debug($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg, 'DEBUG');
	}

	# 'WARNING'
	static function warning($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg, 'WARNING');
	}

	# 'ERRORS'
	static function error($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg, 'ERRORS');
	}

	# 'FATAL'
	static function fatal($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg, 'FATAL');
	}
}
