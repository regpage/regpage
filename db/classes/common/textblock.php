<?php
/**
 * получаем текстовый блок из бд для текущей страницы (при наличии) и отрисовываем его
 * db_get($name) получаем блок из базы
 * get_block() готовим
 */
class TextBlock extends DBQuery
{

  static function getText($block)
  {
    $text = parent::get('str', 'textblock', 'value', 'name', $block);    

    if (empty($text)) {
      return '';
    } else {
      return $text;
    }
  }

  private static function db_get()
  {
    $page = explode('.', substr($_SERVER['PHP_SELF'], 1))[0];
    return parent::get('str', 'textblock', 'value', 'name', $page);

    /*$name = db_real_escape_string($name);

      $res=db_query ("SELECT value FROM textblock WHERE name='$name'");

      if ($row = $res->fetch_assoc())
          return $row['value'];
      else
          return '';*/
  }

  static function get_block()
  {
    $textBlock = self::db_get();
    $s = $_SERVER['QUERY_STRING'];

    if ($textBlock && trim($textBlock)!='' && (!strlen($s) || strlen($s) > 2) ) {
      echo "<div class='textblock container'><div class='alert'>". $textBlock ."</div></div>";
    }
  }

}
