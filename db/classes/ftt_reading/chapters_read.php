<?php

/**
 * получаем прочитанные главы обучающегося за период
 */
class ChaptersRead
{
  static function get($member_key, $condition)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $condition = $db->real_escape_string($condition);
    $result = array('ot' => [], 'nt' => []);

    // задаём условие период для запроса
    if ($condition === 'week') {
      $condition = ' AND DATE(`date`) > (NOW() - INTERVAL 7 DAY) ';
    } elseif ($condition === 'month') {
      $condition = ' DATE(`date`) > (NOW() - INTERVAL 1 MONTH) ';
    } elseif ($condition === '_all_') {
      $semsterBegin = date_convert::ddmmyyyy_to_yyyymmdd(ftt_info::begin());
      $condition = " AND DATE(`date`) >= '{$semsterBegin}' ";
    }

    $res = db_query("SELECT `book_ot`, `chapter_ot`, `read_footnotes_ot`, `date` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' AND `book_ot` != '' AND `start` != 1 {$condition}");
    while ($row = $res->fetch_assoc()) $result['ot'][$row['date']] = $row;

    $res2 = db_query("SELECT `book_nt`, `chapter_nt`, `read_footnotes_nt`, `date` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' AND `book_nt` != '' AND `start` != 1 {$condition}");
    while ($row = $res2->fetch_assoc()) $result['nt'][$row['date']] = $row;

    return $result;
  }
}
