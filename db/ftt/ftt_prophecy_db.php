<?php
require_once 'db/classes/common/db_query.php';
require_once 'db/classes/trainee_data.php';
/**
 * запросы для раздела пророчество
 * ProphecyDB::getListByMember($memberKey)
 * ProphecyDB::getLine($id)
 * ProphecyDB::dltLine($id)
 * ProphecyDB::setLine($id)
 */
class ProphecyDB extends DBQuery
{
  // получаем строку таблицы Пророчество по id
  static function getLine($id)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'id', $id);
  }
  // получаем строки таблицы Пророчество по ключу пользователя
  static function getListByMember($traineeKey, $all)
  {
    $traineeKey = db_real_escape_string($traineeKey);
    $all = db_real_escape_string($all);
    $condition = '';
    if ($all === '0') {
      $condition = " AND (`date` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) OR `checked` != 1)";
    }
    $result = [];
    $res = db_query("SELECT * FROM `ftt_prophecy` WHERE `member_key` = '{$traineeKey}' {$condition}");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
    //return DBQuery::get('list', 'ftt_prophecy', '*', 'member_key', $memberKey;
  }
  // получаем строки таблицы Пророчество для списка служащих
  static function getListForServingones($traineeKey, $listTraneesByStaff, $currents, $sortField, $sortType)
  {
    $traineeKey = db_real_escape_string($traineeKey);
    $currents = db_real_escape_string($currents);
    $sortField = db_real_escape_string($sortField);
    $sortType = db_real_escape_string($sortType);
    $result = [];
    $condition = 1;

    if (!empty($traineeKey) && $traineeKey !== '_all_') { // если задан фильтр обучающийся
      $condition = "fp.member_key = '{$traineeKey}'";
    } elseif (count($listTraneesByStaff) > 0) { // если задан фильтр служащий
       foreach ($listTraneesByStaff as $key => $value) {
         if ($condition === 1) {
           $condition = " (fp.member_key = '{$key}' ";
         } else {
           $condition .= " OR fp.member_key = '{$key}' ";
         }
       }
       $condition .= ') ';
    } elseif (count($listTraneesByStaff) === 0 && $servingoneKey !== '_all_') { // если задан фильтр служащий для служащего без подчинённых обучающихся
      $condition = " fp.member_key = '' ";
    }

    if ($currents == 0) {
      if ($condition === 1) {
        $condition = ' fp.checked = 0 ';
      } else {
        $condition .= ' AND fp.checked = 0 ';
      }
    }
    $res = db_query("SELECT fp.*, m.name, ft.semester, ft.serving_one
      FROM ftt_prophecy fp
      LEFT JOIN member m ON m.key = fp.member_key
      LEFT JOIN ftt_trainee ft ON ft.member_key = fp.member_key
      WHERE {$condition} ORDER BY {$sortField} {$sortType}");
    while ($row = $res->fetch_assoc()) $result[] = $row;

    return $result;
  }
  // удаляем строку таблицы Пророчество по id
  static function dltLine($id)
  {
    return DBQuery::dlt('ftt_prophecy', 'id', $id);
  }

  // записываем новую / обновляем существующую строку
  static function setLine($data, $adminId = '')
  {
    global $db;
    $keysTextQuery = '';
    $valuesTextQuery = '';
    $new = empty($data->id);
    foreach ($data as $key => $value) {
      $data->$key = db_real_escape_string($value);
      if ($new) { // вставка новой строки
        if ($key === 'id' || $key === 'related_announcement_content') {
          continue;
        }
        if (empty($keysTextQuery)) {
          $keysTextQuery = "`" . db_real_escape_string($key) . "`";
          $valuesTextQuery = "'{$data->$key}'";
        } else {
          $keysTextQuery .= ",`" . db_real_escape_string($key) . "`";
          $valuesTextQuery .= ",'{$data->$key}'";
        }
      } else { //  обновление существующей строки
        if ($key !== 'id' && $key !== 'related_announcement_content') {
          if (empty($valuesTextQuery)) {
            $valuesTextQuery .=  "`" . db_real_escape_string($key) . "` = '{$data->$key}'";
          } else {
            $valuesTextQuery .=  ",`" . db_real_escape_string($key) . "` = '{$data->$key}'";
          }
        }
      }
    }

    if (empty($data->id)) {
      $resultQuery = db_query("INSERT INTO `ftt_prophecy` ({$keysTextQuery}) VALUES ({$valuesTextQuery})");
      $newId = $db->insert_id;
    } else {
      $resultQuery = db_query("UPDATE `ftt_prophecy` SET {$valuesTextQuery} WHERE `id` = '{$data->id}'");
    }

    if ($resultQuery === false) {
      return 'Ошибка: ' . $db->error;
    } elseif (empty($data->id) && empty($data->related_announcement_content)) {

    } elseif (empty($data->id) && !empty($data->related_announcement_content)) {
      self::setAnnouncement($newId, $data, $adminId);
    } else {
      self::setAnnouncement($data->id, $data, $adminId);
    }
    return $resultQuery;
  }

  static function setAnnouncement($newId, $data, $adminId)
  {
    // Создать бланк
// Сохранить бланк
// На отсутствие объявления указывает 2 факта
// если (ID объявления === 0 И ткст объявления пуст)
// тогда создание объявления игнорируется
    // новый бланк / существующий бланк
    // установить есть объявление или нет, было или нет.
    // добавить объявление или нет
    // Новый бланк, без объявлеия / с объявлением
    // Существующий бланк, без объявлеия / с объявлением
    // Существующий бланк, добавленрие объявления / удаление объявления
    // удаление объявления выполняестся оотдельно.
    // стирание текста объявления === удалению?
    // announcement

    /*
    условие 1 есть текст нет id НОВОЕ ОБЪЯВЛЕНИЕ
    условие 2 есть текст есть id существующее объявление (можно проверить изменение запросив по id и тексту на 100% соответствие)
    условие 3 нет текст есть id обновление, тоже можно с проверкой
    удаляем отдельно
    обновляем всегда
    если объявления нет и поля не заполнены ничего не делаем
    $data->announcement_id = db_real_escape_string($data->announcement_id);
    $data->related_announcement_content = db_real_escape_string($data->related_announcement_content);
    if (empty($data->announcement_id) && !empty($data->related_announcement_content)) {
      db_query("INSERT INTO `ftt_prophecy` ({$keysTextQuery}) VALUES ({$valuesTextQuery})");
    } else {
      db_query("UPDATE `ftt_prophecy` SET {$valuesTextQuery} WHERE  `id` = '{$data->id}'");
    }
     */
    // добавляем новое объявление при создании бланка, если объявление заполнено
    $traineeData = trainee_data::get_data($data->member_key);
    if (!empty($newId) && !empty($data->related_announcement_content)) {
      $topic = "О пророчестве {$data->date}";
      db_query("INSERT INTO `ftt_announcement`
        (`date`, `time`, `publication`, `header`, `content`, `member_key`, `by_list`, `list`, `time_zone`, `archive_date`)
        VALUES
        (CURDATE(), CURTIME(), 1, '{$topic}','{$data->related_announcement_content}','{$adminId}','1','{$data->member_key}', '{$traineeData->ft_time_zone}', CURDATE() + INTERVAL 1 DAY)");

      db_query("UPDATE `ftt_prophecy` SET `announcement_id`= {$newId}");
    } elseif (empty($newId)) { // && !empty($data->related_announcement_content)
      $topic = "О пророчестве {$data->date}";
      db_query("INSERT INTO `ftt_announcement`
        (`date`, `time`, `publication`, `header`, `content`, `member_key`, `by_list`, `list`, `time_zone`, `archive_date`)
        VALUES
        (CURDATE(), CURTIME(), 1, '{$topic}','{$data->related_announcement_content}','{$adminId}','1','{$data->member_key->ft_time_zone}', '{$data->ft_time_zone}', CURDATE() + INTERVAL 1 DAY)");

      // db_query("UPDATE `ftt_prophecy` SET `announcement_id`= {$data->id}");
    }
  }
  /*
  static function getList($memberKey)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'member_key', $memberKey);
  }
  */
  // создание бланка при загрузке файла если бланк не существует
  static function setLineGetId($data)
  {
    global $db;
    foreach ($data as $key => $value) {
      $data->$key = db_real_escape_string($value);
    }
    $res = db_query("INSERT INTO `ftt_prophecy` (`date`, `member_key`) VALUES ('{$data->date}', '{$data->member_key}')");
    if ($res) {
      return $db->insert_id;
    } else {
      return "ERROR: NO ID";
    }
  }
}
