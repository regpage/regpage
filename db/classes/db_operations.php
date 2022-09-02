<?php
/**
 * работаем с базой данных
 * удаляем
 * обновляем
 * получаем
 * Обновляем данные в таблице принимая объект с данными типа имя_столбца->значение и имя таблицы
 * сохранение работает для одной таблицы
 */
class DbOperation {
  // добавить добавление обновление changed = 1 как авто опцию
  // Добавить свойство $fields, указывать поля для вывода через заппятую
  // Добавить второе условие
  static function operation($data)  {
    global $db;
    $operation = $db->real_escape_string(trim($data['operation']));
    $table = $db->real_escape_string(trim($data['table']));
    $field = $db->real_escape_string(trim($data['field']));
    $value = $db->real_escape_string(trim($data['value']));
    $condition_field = $db->real_escape_string(trim($data['condition_field']));
    $condition_value = $db->real_escape_string(trim($data['condition_value']));
    $order_by = $db->real_escape_string(trim($data['order_by']));
    $changed = $db->real_escape_string(trim($data['changed']));
    $changed_field = '';
    $equal ='';
    if ($changed === '1') {
      if ($operation = 'set') {
        $changed_field = ', `changed`';
        $equal = '=';
      } elseif ($operation = 'insert') {
        $changed_field = ', `changed`';
        $equal = ',';
      } else {
        $changed = '';
      }
    } else {
      $changed = '';
    }

    if ($operation === 'dlt') {
      $res = db_query("DELETE FROM `{$table}` WHERE `{$condition_field}` = {$condition_value}");
    } elseif ($operation === 'set') {
      $res = db_query("UPDATE `{$table}` SET `{$field}` = '{$value}' {$changed_field}{$equal}{$changed} WHERE `{$condition_field}` = '{$condition_value}'");
    } elseif ($operation === 'get') {
      $res = db_query("SELECT {$field} FROM {$table} WHERE {$condition_field} = '{$condition_value}' ORDER BY {$order_by}");
    } elseif ($operation === 'insert') {
      $res = db_query("INSERT INTO `{$table}` (`{$field}` {$equal}{$changed_field}) VALUES ('$value' {$equal}{$changed})");
    }

    return $res;
  }

  static function update_multi($data)
  {
    global $db;
    $data = json_decode($data);
    $table = $db->real_escape_string($data->table);
    $condition_field = $db->real_escape_string($data->condition->field);
    $condition_value = $db->real_escape_string($data->condition->value);
    $result;
    $query_set = '';
    foreach ($data as $key => $value) {
      if ($key !== 'table' && $key !== 'condition') {
        if ($query_set) {
          $query_set .= ', ';
        }
        $key = $db->real_escape_string($key);
        $value = $db->real_escape_string($value);
        $query_set .= ' `'.$key."`='$value'";
      }
    }
        
    $result = db_query("UPDATE `{$table}` SET {$query_set} WHERE `{$condition_field}` = '{$condition_value}'");

    return $result;
  }
}

/**
 * Задаём данные
 */
 // Добавить свойство $fields, указывать поля для вывода через запятую (можно и для value)  или в виде массива
 // Добавить второе условие
class DbData
{
  protected $operation;
  protected $table;
  protected $field='';
  protected $value='';
  protected $condition_field='';
  protected $condition_value='';
  protected $order_by='';
  protected $changed='';

  function __construct($operation, $table)
  {
    $this->operation=$operation;
    $this->table=$table;
  }

  public function get()
  {
    return [
      "operation" => $this->operation,
      "table" => $this->table,
      "field" => $this->field,
      "value" => $this->value,
      "condition_field" => $this->condition_field,
      "condition_value" => $this->condition_value,
      "order_by" => $this->order_by,
      "changed" => $this->changed,
    ];
  }

  public function set($prop,$value='')
  {
    $this->$prop=$value;
  }
}

?>
