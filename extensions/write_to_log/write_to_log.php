<?php

 /*******************************************************************************************************************
	 * 	ОПИСАНИЕ

   *  write_to_log::debug($adminId, $msg);

	 * 	Модуль ведения журнала лога write_to_log для reg-page.ru
	 * 	Публичные методы класса write_to_log вызываются статически, например write_to_log::info('Текст для записи в лог')
	 * 	Всего 5 методов: info($text), debug($text), warning($text), errors($text), fatal($text).
	 * 	Каждый метод создаёт новую запись в логе соответствующую названию метода.
	 * 	Методы принимают один строчный аргумент. Если аргумент не строка, он не будет записан в лог.
	 * 	Название файла лога logFile_ТЕКУЩЕЕ_ВРЕМЯ_И_ДАТА.log
	 * 	Для работы модуля необходимо создать папку log/ в корне сайта, разместить файл и подключить класс в проект.
	 *  ******************************************************************************************************************/
class write_to_log {

  // ADD STRINT TO A LOG FILE
  static function writer($logMemberId, $info, $type='INFO') {
    $logMemberId ? $logAdminName = db_getAdminNameById($logMemberId) : $logAdminName = 'SERVER REG-PAGE.RU';
    $logMemberId ? $logAdminLocaity = db_getLocalityByKey(db_getAdminLocality($logMemberId)) : $logAdminLocaity = '-';
    $logMemberId ? $logAdminCountry = db_getAdminCountry($logMemberId) : $logAdminCountry = '-';
    $logMemberId ? $logAdminRole = db_getAdminRole($logMemberId) : $logAdminRole = 'SUPERVISOR';
    $logMemberId ? '' : $logMemberId = 'none';

    $file = 'logFile_'.date("d-m-Y").'.log'; //
    //Добавим разделитель, чтобы мы смогли отличить каждую запись
    $text = $type.' ==================================================='.PHP_EOL;
    $text .=  date('d-m-Y H:i:s') .PHP_EOL; //Добавим актуальную дату после текста или дампа массива
    $text .= 'Admin is '.$logAdminName.'. Key is '. $logMemberId.'. Role is '.$logAdminRole.'. '.$logAdminCountry.'. '. $logAdminLocaity.'. '.PHP_EOL;
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
	static function errors($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg, 'ERRORS');
	}

	# 'FATAL'
	static function fatal($logMemberId, $msg=false) {
		self::writer($logMemberId, $msg, 'FATAL');
	}
}

?>
