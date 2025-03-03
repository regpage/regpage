<?php
require_once 'db/modules/phoneedit.php';
/**
 * getCall() - получаем 1 звонок по id
 * getCalls() - получаем все звонк отсотрированные по дате добавления
 * getUsers() - список пользователей раздела Звонки
 */

class CallsDB extends DBQuery
{
  // получаем звонк по id
  static function getCall($id)
  {
    return parent::get('list', 'calls', '*', 'id', $id);
  }
  // получаем список звонков
  static function getCalls($conditionField = '', $conditionValue = '', $sortField = 'c.created_date', $sortType='DESC', $fltGender = '_all_', $fltAuthor = '_all_', $fltSearch = '', $fltOperator = '_all_', $limit = 50, $offset = 0)
  {
    $conditionField = db_real_escape_string($conditionField);
    $conditionValue = db_real_escape_string($conditionValue);
    $sortField = db_real_escape_string($sortField);
    $sortType = db_real_escape_string($sortType);
    $fltGender = db_real_escape_string($fltGender);
    $fltSearch = db_real_escape_string($fltSearch);
    $fltOperator = db_real_escape_string($fltOperator);
    $fltAuthor = db_real_escape_string($fltAuthor);
    $limit = db_real_escape_string($limit);
    $offset = db_real_escape_string($offset);
    $result = [];
    // формируем условие
    if (empty($conditionField)) {
      $condition = 1;
    } elseif ($conditionField === 'currents') {
      $condition = " ((c.status != 'Входящая' AND c.done = 0) OR (c.status = 'Уточнение' AND c.done = 1)) ";
    } elseif ($conditionField === 'finished') {
      $condition = " c.status != 'Уточнение' AND c.done = 1 ";
    } elseif ($conditionField === 'incomming') {
      $condition = " c.status = 'Входящая' AND c.done = 0 ";
    }
    if ($fltAuthor !== '_all_') {
      if ($condition !== 1) {
        $condition .= " AND c.author_key = '{$fltAuthor}' ";
      } else {
        $condition = " c.author_key = '{$fltAuthor}') ";
      }
    }
    if ($fltOperator !== '_all_' && $conditionField !== 'incomming') {
      if ($condition !== 1) {
        $condition .= " AND c.operator = '{$fltOperator}' ";
      } else {
        $condition = " c.operator = '{$fltOperator}' ";
      }
    }
    // фильтр пол
    if ($fltGender !== '_all_') {
      if ($condition !== 1) {
        $condition .= " AND (c.male = '{$fltGender}' OR c.male IS NULL) ";
      } else {
        $condition = " (c.male = '{$fltGender}'  OR c.male IS NULL) ";
      }
    }

    // поиск
    if (!empty($fltSearch)) {
      if ($condition !== 1) {
        $condition .= " AND (c.phone LIKE '%{$fltSearch}%' OR c.name LIKE '%{$fltSearch}%') ";
      } else {
        $condition = " c.phone LIKE '%{$fltSearch}%' OR c.name LIKE '%{$fltSearch}%' ";
      }
    }

    $res=db_query ("SELECT c.*, m.name operator_name
    FROM calls c
    LEFT JOIN member m ON m.key = c.operator
    WHERE {$condition} ORDER BY {$sortField} {$sortType} LIMIT {$limit} OFFSET {$offset}");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }

  // Часовые пояса для которых есть расписание для комбобоксов
  static function getUsers() {
    return parent::getKeyValue('calls_users');
  }
  // проверяем дубликаты номера телефона в базе
  static function getIDDoublePhoneNumber($phone)
  {
    if (!empty($phone)) {
      $doubleId = DBQuery::get('list', 'calls', '*', 'phone', $phone);
      foreach ($doubleId as $key => $value) {
        if ($value['status'] !== 'Повтор') {
          return $value['id'];
        }
      }
    }

    return '';
  }
  // проверяем дубликаты номера телефона в базе
  static function checkPhoneNumber($data, $checkData = [])
  {
    $result = ''; // && strlen(substr($data->phone, 1)) === 10
    if (isset($data->phone) && !empty($data->phone)
    && ((isset($data->id) && !empty($data->id) && isset($checkData['phone']) && $checkData['phone'] !== $data->phone)
    || (!isset($data->id) || empty($data->id)))) {
      $dubleId = DBQuery::get('list', 'calls', '*', 'phone', $data->phone);
      foreach ($dubleId as $key => $value) {
        $date = date_convert::yyyymmdd_to_ddmmyyyy(substr($value['created_date'], 0, 10));
        $operator = short_name::no_middle(Member::get_name($value['operator']));
        $blockComment = '';
        $blockOperator = '';
        // блок комментария
        if (!empty($value['comment'])) {
          $blockComment = "Комментарий: " . trim($value['comment']) . "\r\n";
        }
        // блок оператора
        if (!empty($value['operator'])) {
          $blockOperator = "Оператор: {$operator}\r\n";
        }
        // текст примечания
        $result .= "Была заявка {$date}\r\nФИО: {$value['name']}\r\nСтатус: {$value['status']}\r\n{$blockOperator}{$blockComment}";
      }
    }

    return $result;
  }
  // обновляем / добавляем звонок
  static function saveCall($data)
  {
    global $db;
    $isNew = false;
    $simChangedStatus = false;
    $checkingSecurity = false;
    if (isset($data->id)) {
      $checkData = self::getCall($data->id)[0];
      // проверяем на дубликат номер телефона
      //$extraComment = self::checkPhoneNumber($data, $checkData);

      // проверяем изменения для истории сравнить операторов и статусы
      if (isset($data->operator) && isset($data->status) && ($data->operator === $checkData['operator']) && ($data->status !== $checkData['status'])) {
        $nameUser = short_name::no_middle(Member::get_name(MEMBER_ID));
        $data->history = $checkData['history'] . date('d.m.Y H:i') . " Установлен статус {$data->status} ({$nameUser})<br>";
        $simChangedStatus = true;
      }
      // проверяем изменения для истории сравнить операторов
      if (isset($data->operator) && !empty($data->operator) && isset($data->status) && !empty($checkData['operator']) && $data->operator !== $checkData['operator'] && $data->status !== 'В работе') {
        $newOperatorName = short_name::no_middle(Member::get_name($data->operator));
        $nameAdmin = short_name::no_middle(Member::get_name(MEMBER_ID));
        if ($simChangedStatus === false) {
          $data->history = $checkData['history'] . date('d.m.Y H:i') . " Назначен новый оператор {$newOperatorName} (назначил {$nameAdmin})<br>";
        } else {
          $data->history = $data->history . date('d.m.Y H:i') . " Назначен новый оператор {$newOperatorName} (назначил {$nameAdmin})<br>";
        }
        // письмо новому оператору
        $date = date_convert::yyyymmdd_to_ddmmyyyy(explode(' ' ,$checkData['created_date'])[0]);
        //$date = date_convert::yyyymmdd_to_ddmmyyyy($date[0]); //  . ' ' . substr($date[1], 0, 5)
        $name = short_name::no_middle(Member::get_name(MEMBER_ID));
        $bodyEmail = "Пользователь {$name} назначил вас оператором по заявке от {$date}: <br> Имя: {$data->name} <br> Телефон: {$data->phone} <br> Перейти к заявке https://reg-page.ru/calls?tab=currents&id={$data->id}";
        Emailing::send_by_key($data->operator, 'Вы назначены оператором для звонка по проекту BFA', $bodyEmail);
      }
      // готовим запрос
      $setQuery = '';
      foreach ($data as $key => $value) {
        $key = db_real_escape_string($key);
        $value = db_real_escape_string($value);
        if ($key !== 'id') {
          if (empty($setQuery)) {
            if ($value === 'NULL') {
              $setQuery = "$key = {$value}";
            } else {
              $setQuery = "$key = '{$value}'";
            }
          } else {
            if ($value === 'NULL') {
              $setQuery .= ", $key = {$value}";
            } else {
              $setQuery .= ", $key = '{$value}'";
            }
          }
        }
      }

      $res=db_query("UPDATE calls SET {$setQuery} WHERE id='{$data->id}'");
    } else {
      $isNew = true;
      $keys = '';
      $values = '';
      $simDouble = false;
      // проверка безопастности подозрительный заказчик
      // добавить управление на сайт
      $checkingSecurity = self::checkingSecurity($data->locality);
      // добавляем комментарий
      if ($checkingSecurity) {
        $data->operator = '000004947';
        $data->status = 'Уточнение';
        if (empty($data->comment)) {
          $data->comment = $checkingSecurity;
        } else {
          $data->comment = trim($data->comment) . '\r\n' . $checkingSecurity;
        }
      }
      // проверяем на дубликат
      if ($data->status === 'Входящая') {
        // проверяем номер телефона
        if (is_numeric(self::getIDDoublePhoneNumber($data->phone))) {
          $simDouble = true;
          $extraComment = self::checkPhoneNumber($data);
          $data->status = 'Повтор';
          $data->operator = '000004947';
          if (empty($data->comment)) {
            $data->comment = $extraComment;
          } else {
            $data->comment = trim($data->comment) . '\r\n' . $extraComment;
          }
        }
      }

      $dateNewCall = date('d.m.Y H:i');
      $nameAuthorNewCall = short_name::no_middle(Member::get_name(MEMBER_ID));
      $data->history = "{$dateNewCall} Заявка создана ({$nameAuthorNewCall})<br>";
      // история, подозрительная заявка
      if ($checkingSecurity) {
        $data->history .= "{$dateNewCall} Установлен статус Уточнение (автоматически)<br>";
        $data->history .= "{$dateNewCall} Назначен новый оператор " . short_name::no_middle(Member::get_name('000004947')) . " (автоматически)<br>";
      }
      if ($simDouble) {
        $data->history .= "{$dateNewCall} Повтор (определено при сохранении)<br>";
      }
      // если заявка при создании назначена
      if (isset($data->operator) && $data->operator === MEMBER_ID && $data->status === 'В работе') {
        $data->history .=  date('d.m.Y H:i') . " Заявка взята в работу ({$nameAuthorNewCall})<br>";
      }
      foreach ($data as $key => $value) {
        $key = db_real_escape_string($key);
        $value = db_real_escape_string($value);

        if (empty($keys)) {
          $keys .= $key;
          if ($value === 'NULL') {
            $values .= "{$value}";
          } else {
            $values .= "'{$value}'";
          }

        } else {
          $keys .= ", {$key}";
          if ($value === 'NULL') {
            $values .= ", {$value}";
          } else {
            $values .= ", '{$value}'";
          }
        }
      }

      $res=db_query("INSERT INTO `calls` ({$keys}) VALUES ({$values})");
      $data->id = $db->insert_id;
      $checkData = self::getCall($data->id)[0];
      // доп правило если назначен оператор при создании и это не текущий админ
      if (isset($data->operator) && !empty($data->operator) && $data->operator !== MEMBER_ID && $data->status === 'В работе') {
        $checkData['operator'] = MEMBER_ID;
      }
    }

    // уведомление оператору о назначении
    if (isset($data->operator) && !empty($data->operator) && $checkData['operator'] !== $data->operator && MEMBER_ID !== $data->operator && $data->status === 'В работе') {
      $date = date_convert::yyyymmdd_to_ddmmyyyy(explode(' ' ,$checkData['created_date'])[0]); //  . ' ' . substr($date[1], 0, 5)
      $name = short_name::no_middle(Member::get_name(MEMBER_ID));
      $nameOperator = short_name::no_middle(Member::get_name($data->operator));
      $dateStart =  date('d.m.Y H:i');
      if (empty($checkData['operator'])) {
        $noticeText = "Заявка назначена в работу оператору";
      } else {
        $noticeText = "Назначен новый оператор";
      }
      $history = $checkData['history'] . "{$dateStart} {$noticeText} {$nameOperator} (назначил {$name})<br>";
      DBQuery::set('calls', 'history', $history, 'id', $data->id);
      $bodyEmail = "Пользователь {$name} назначил вас оператором по заявке от {$date}: <br> Имя: {$data->name} <br> Телефон: {$data->phone} <br> Перейти к заявке https://reg-page.ru/calls?tab=currents&id={$data->id}";
      Emailing::send_by_key($data->operator, 'Вы назначены оператором для звонка по проекту BFA', $bodyEmail);
    }
    // уведомление о повторе
    if ((isset($data->operator) && !empty($data->operator) && $data->operator === '000004947' && $data->status === 'Повтор' && $isNew) || (isset($data->operator) && !empty($data->operator) && $data->operator === '000004947' && $data->status === 'Повтор' && $checkData['status'] !== $data->status && !$isNew)) {
      $date = date_convert::yyyymmdd_to_ddmmyyyy(explode(' ' ,$checkData['created_date'])[0]);
      $name = short_name::no_middle(Member::get_name(MEMBER_ID));
      $nameOperator = short_name::no_middle(Member::get_name($data->operator));
      $dateStart =  date('d.m.Y H:i');
      $history = $checkData['history'] . "{$dateStart} Повторная заявка передана на проверку ({$nameOperator})<br>";
      DBQuery::set('calls', 'history', $history, 'id', $data->id);
      $bodyEmail = "Пользователь {$name} назначил вас оператором по заявке от {$date}: <br> Имя: {$data->name} <br> Телефон: {$data->phone} <br> Перейти к заявке https://reg-page.ru/calls?tab=currents&id={$data->id}";
      Emailing::send_by_key($data->operator, 'Вы назначены оператором для звонка по проекту BFA', $bodyEmail);
    }
    // уведомление о подозрении
    if ($checkingSecurity) {
      $textSecurityEmailing = "Заявка от " . date('d.m.Y H:i') . "<br>ФИО: {$data->name}<br>Город: {$data->locality}<br>Телефон: {$data->phone} <br> Перейти к заявке https://reg-page.ru/calls?tab=currents&id={$data->id}";
      # уведомление администратора
      $resultSecurityEmailing = mail(
        'zhichkinroman@gmail.com,and1ievsky@gmail.com', # To a.rudanok@gmail.com
        '=?utf-8?B?'.base64_encode('Проверить экспресс заказ').'?=', # Subject
        $textSecurityEmailing, # Text of the message
        join("\r\n", array( # другие заголовки
        'From: noreply@reg-page.ru',
        'Content-Type: text/html; charset=utf-8',
        'Reply-To: noreply@reg-page.ru',
        'X-Mailer: PHP/'.phpversion()
  		  ))
      );
    }

    return $res;
  }

  static function dltCall($id)
  {
    return parent::dlt('calls', 'id', $id);
  }

  static function cancelCall($id)
  {
    DBQuery::set('calls', 'done', 1, 'id', $id);
    $res = DBQuery::set('calls', 'end_date', date('Y-m-d H:i:s'), 'id', $id);
    return $res;
  }
  // ндексы для закладок
  // получаем список звонков
  static function getCountCalls($operator = '_none_')
  {
    $operator = db_real_escape_string($operator);
    $result = '';
    // формируем условие
    if ($operator === '_none_') {
      $condition = " `status` = 'Входящая' ";
    } else {
      $condition = " `operator` = '{$operator}' AND `done` = 0 ";
    }

    $res=db_query ("SELECT COUNT(`id`) result FROM calls WHERE {$condition}");
    while ($row = $res->fetch_assoc()) $result=$row['result'];
    if ($result === '0') {
      $result = '';
    }
    return $result;
  }

  static function getStatisticsCalls($operator, $dateBegin, $dateEnd)
  {
    if ($operator === '_all_') {
      $users = self::getUsers();
    } else {
      $users = [];
      $users[$operator] = short_name::no_middle(Member::get_name($operator));
    }

    $data = [];
    // личная статистика
    foreach ($users as $key => $value) {
      // возвращаемый массив
      $data[$key] = ['name' => $value, 'incomming' => 0, 'no_answer' => 0, 'error' => 0, 'refused' => 0, 'reply' => 0, 'specify' => 0, 'order' => 0];
      // входящие
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `author_key` = '{$key}' AND `created_date` >= '{$dateBegin}' AND `created_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['incomming']=$row['incomming'];
      // недозвон
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `operator` = '{$key}' AND `status` = 'Недозвон' AND `end_date` >= '{$dateBegin}' AND `end_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['no_answer']=$row['incomming'];
      // Ошибка
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `operator` = '{$key}' AND `status` = 'Ошибка' AND `end_date` >= '{$dateBegin}' AND `end_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['error']=$row['incomming'];
      // Отказ
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `operator` = '{$key}' AND `status` = 'Отказ' AND `end_date` >= '{$dateBegin}' AND `end_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['refused']=$row['incomming'];
      // Повтор
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `operator` = '{$key}' AND `status` = 'Повтор' AND `end_date` >= '{$dateBegin}' AND `end_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['reply']=$row['incomming'];
      // Уточнение
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `operator` = '{$key}' AND `status` = 'Уточнение' AND `end_date` >= '{$dateBegin}' AND `end_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['specify']=$row['incomming'];
      // Заказ
      $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `operator` = '{$key}' AND `status` = 'Заказ' AND `end_date` >= '{$dateBegin}' AND `end_date` <= '{$dateEnd}'");
      while ($row = $res->fetch_assoc()) $data[$key]['order']=$row['incomming'];
    }

    // общая статистика
    $data['period'] = ['name' => 'Всего обработано заявок', 'incomming' => 0, 'no_answer' => 'В предыдущем периоде', 'error' => 0, 'refused' => 0, 'reply' => 0, 'specify' => 0, 'order' => 0];
    // за выбранный период
    $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `created_date` >= '{$dateBegin}' AND `created_date` <= '{$dateEnd}'");
    while ($row = $res->fetch_assoc()) $data['period']['incomming']=$row['incomming'];
    // за предыдущий подобный период
    $diference = strtotime($dateEnd) - strtotime($dateBegin); // разница между двумя датами в секундах
    $days = round($diference / 86400); // секунды в сутках
    $dateEnd = $dateBegin;
    $dateBegin = date_format(date_sub(date_create($dateBegin), date_interval_create_from_date_string("{$days} days")), 'Y-m-d');
    $res=db_query ("SELECT count(*) AS incomming FROM `calls` WHERE `created_date` >= '{$dateBegin}' AND `created_date` <= '{$dateEnd}'");
    while ($row = $res->fetch_assoc()) $data['period']['error']=$row['incomming'];

    return $data;
  }

  # функция проверки города
  static function checkCities($city) {
    $city = trim($city);

    # передана пустая строка
    if (empty($city)) {
      return false;
    }

    # список городов для проверки
    $cities = parent::get('list', 'calls_blacklist', 'value');
    $city = mb_strtolower($city);

    # поиск совпадений
    foreach ($cities as $value) {
      # если название города из списка городов состоит из двух слов
      if (strpos(trim($value['value']), ' ') !== false) {
        $temp = explode(' ', trim($value['value']));
        if (isset($temp[1])) {
          if (stripos($city, $temp[0]) !== false && stripos($city, $temp[1]) !== false) {
            # найдено совпадение
            return true;
          }
        }
      } elseif (stripos($city, $value['value']) !== false) { # если название города из списка городов состоит из одного слова
        # найдено совпадение
        return true;
      }
    }
    # не обнаружено совпадений
    return false;
  }

  static function checkingSecurity($city='')
  {
    # проверка подозрительной активности
    if (!self::checkCities($city)) {
      return false;
    }

    # возвращаем комментарий
    return 'Экспресс заказ: Заказчик требует проверки.';
  }
}
