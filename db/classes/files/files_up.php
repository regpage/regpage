<?php
/**
 * сохраниени пити к файлу с добавления этого пути к существующей строке с разделителем.
 */
class FilesUp
{

  static function setPics($id, $file, $table, $field='file', $changed=1)
  {

    $file = db_real_escape_string($file);
    $id = db_real_escape_string($id);
    $table = db_real_escape_string($table);
    $field = db_real_escape_string($field);
    $changed = db_real_escape_string($changed);
    if ($changed == 1) {
      $changed = ", `changed` = 1";
    } else {
      $changed = "";
    }
    $result = '';

    $res = db_query("SELECT {$field} FROM `{$table}` WHERE `id` = '$id'");
    while ($row = $res->fetch_assoc()) $result = $row['file'];

    if (!empty($result)) {
      $file = $file . ';' . $result;
    }

    $res = db_query("UPDATE `{$table}` SET `{$field}` = '{$file}' {$changed} WHERE `id` = '$id'");

    return $file;
  }
}
