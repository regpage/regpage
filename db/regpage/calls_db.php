<?php
/**
 * getCall() - получаем 1 звонок по id
 * getCalls() - получаем все звонк отсотрированные по дате добавления
 * getUsers() - список пользователей раздела Зввонки
 */

class CallsDB extends DBQuery
{
  static function getCall($id)
  {
    return parent::get('list', 'calls', '*', 'id', $id);
  }

  static function getCalls($conditionField = '', $conditionValue = '', $sortField = 'c.created_date', $sortType='DESC', $fltGender = '_all_', $fltAuthor = '_all_', $fltSearch = '', $fltOperator = '_all_', $limit = 50, $offset = 0)
  {
    $conditionField = db_real_escape_string($conditionField);
    $conditionValue = db_real_escape_string($conditionValue);
    $sortField = db_real_escape_string($sortField);
    $sortType = db_real_escape_string($sortType);
    $result = [];
    //
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
        $condition .= " AND c.male = '{$fltGender}' ";
      } else {
        $condition = " c.male = '{$fltGender}' ";
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
  static function checkPhoneNumber($data, $checkData = [])
  {
    $result = '';
    if (isset($data->phone) && !empty($data->phone) && strlen(substr($data->phone, 1)) === 10
    && ((isset($data->id) && !empty($data->id) && isset($checkData['phone']) && $checkData['phone'] !== $data->phone)
    || (!isset($data->id) || empty($data->id)))) {
      $dubleId = DBQuery::get('list', 'calls', '*', 'phone', '%'.$data->phone.'%', 'LIKE');
      foreach ($dubleId as $key => $value) {
        $date = date_convert::yyyymmdd_to_ddmmyyyy(substr($value['created_date'], 0, 10));
        $operator = short_name::no_middle(Member::get_name($value['operator']));
        $result .= "Была заявка {$date}\r\nСтатус: {$value['status']}\r\nОператор: {$operator}\r\nКомментарий: {$value['comment']}";
      }
    }

    return $result;
  }
  // обновляем / добавляем звонок
  static function saveCall($data)
  {
    global $db;
    if (isset($data->id)) {
      $checkData = self::getCall($data->id)[0];
      $extraComment = self::checkPhoneNumber($data, $checkData);
      if (!empty($extraComment) && isset($data->comment)) {
        if (empty($data->comment)) {
          $data->comment = $extraComment;
        } else {
          $data->comment .= "\r\n" . $extraComment;
        }
      }
      // проверяем изменения для истории
      // сравнить операторов и статусы
      if (isset($data->operator) && isset($data->status) && ($data->operator === $checkData['operator']) && ($data->status !== $checkData['status'])) {
        $nameUser = short_name::no_middle(Member::get_name(MEMBER_ID));
        $data->history = $checkData['history'] . date('d-m-Y H:i') . " Установлен статус {$data->status} ({$nameUser})<br>";
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
      $keys = '';
      $values = '';
      $dateNewCall = date('d-m-Y H:i');
      $nameAuthorNewCall = short_name::no_middle(Member::get_name(MEMBER_ID));
      $data->history = "{$dateNewCall} Заявка создана ({$nameAuthorNewCall})<br>";
      // если заявка при создании назначена
      if (isset($data->operator) && $data->operator === MEMBER_ID && $data->status === 'В работе') {
        $data->history .=  date('d-m-Y H:i') ." Заявка взята в работу ({$nameAuthorNewCall})<br>";
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
      $date = explode(' ' ,$checkData['created_date']);
      $date = date_convert::yyyymmdd_to_ddmmyyyy($date[0]); //  . ' ' . substr($date[1], 0, 5)
      $name = short_name::no_middle(Member::get_name(MEMBER_ID));
      $nameOperator = short_name::no_middle(Member::get_name($data->operator));
      $dateStart =  date('d-m-Y H:i');
      $history = $checkData['history'] . "{$dateStart} Заявка взята в работу ({$nameOperator})<br>";
      DBQuery::set('calls', 'history', $history, 'id', $data->id);
      $bodyEmail = "Пользователь {$name} назначил вас оператором по заявке от {$date}: <br> Имя: {$data->name} <br> Телефон: {$data->phone} <br> Перейти к заявке https://reg-page.ru/calls?tab=currents&id={$data->id}";
      Emailing::send_by_key($data->operator, 'Вы назначены оператором для звонка по проекту BFA', $bodyEmail);
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
}
