<?php

/**
 * статистика благовестия для служащих
 * html, bd, hundler
 */

class GospelStatistic
{

  static function blocks()
  {

  }

  // команда служащего
  static function getTeamByStaff($memberId)
  {
    $memberId = self::check($memberId);
    $team = [];
    $teamPreparing = db_query("SELECT fgs.gospel_team, fs.name
      FROM ftt_serving_one AS fs
      LEFT JOIN ftt_gospel_team fgs ON fs.gospel_team = fgs.id
      WHERE fgs.member_key = '$memberId'");
    while ($row = $teamPreparing->fetch_assoc()) $team[$row['gospel_team']] = $row['name'];

    return $team;
  }

  // обучающиеся из команды
  static function traineesByTeam($team)
  {
    $team = self::check($team);
    $trainees = [];
    $traineesPreparing = db_query("SELECT `member_key`, `gospel_group` FROM `ftt_trainee` WHERE `gospel_team` = '$team'");
    while ($row = $traineesPreparing->fetch_assoc()) $trainees[$row['member_key']] = $row['gospel_group'];

    return $trainees;
  }

  static function traineesByTeamWithName($team) {

    $team = self::check($team);
    $trainees = [];
    $traineesPreparing = db_query("SELECT ft.member_key, m.name
       FROM ftt_trainee AS ft
       INNER JOIN member m ON ft.member_key = m.key
       WHERE ft.gospel_team = '$team'");
    while ($row = $traineesPreparing->fetch_assoc()) $trainees[$row['member_key']] = short_name::no_middle($row['name']);

    return $trainees;
  }

  // статистика по благовестию, команда.
  static function teamReport($team, $from, $period=7)
  {
    $team = self::check($team);
    $from = self::check($from);
    $period = self::check($period);
    $blanks = [];

    if ($period === '_all_') {
      $condition = '';
    } else {
      $condition = " AND `date` >= ('$from' - INTERVAL $period DAY) AND `date` < '$from' ";
    }

    $res = db_query("SELECT *
      FROM `ftt_gospel`
      WHERE `gospel_team`='$team' {$condition}
      ORDER BY `gospel_group`, `date`");
    while ($row = $res->fetch_assoc()) $blanks[] = $row;

    return $blanks;
  }

  // личная статистика по благовестию
  static function personalReport($memberId, $period=7, $from='CURDATE()')
  {
    global $db;
    $period = $db->real_escape_string($period);
    $from = $db->real_escape_string($from);
    $result = [];
    $and = '';
    $conditionBlanks = '';
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        $count = 0;
        foreach ($memberId as $key => $value) {
          if ($count == 0) {
            $count++;
            $conditionBlanks = " (fgm.member_key = '{$key}' ";
          } else {
            $conditionBlanks .= " OR fgm.member_key = '{$key}' ";
          }
        }
      } else {
        return $result;
      }
    } else {
      return $result;
    }
    if ($from!=='CURDATE()') {
      $from = "'$from'";
    }
    if ($conditionBlanks) {
      $and = ' AND ';
      $conditionBlanks .= ')';
    }

    $res = db_query("SELECT fgm.*, m.name FROM ftt_gospel_members AS fgm
      INNER JOIN ftt_gospel fg ON fgm.blank_id = fg.id
      LEFT JOIN member m ON fgm.member_key = m.key
      WHERE fg.date >= {$from} - INTERVAL {$period} DAY AND fg.date < {$from} {$and} {$conditionBlanks}");
      while ($row = $res->fetch_assoc()) $result[] = $row;

      return $result;
  }

  // данные бланков благовестия обучающихся
  static function membersBlanksStatistic()
  {
    $statistic = [];
    $statisticPreparing = db_query("SELECT * FROM `ftt_gospel_members`");
    while ($row = $statisticPreparing->fetch_assoc()) $statistic[] = $row;

    $statisticResult = [];
    foreach ($statistic as $key => $value) {
      if (isset($statisticResult[$value['blank_id']])) {
        $statisticResult[$value['blank_id']]['number'] += $value['number'];
        $statisticResult[$value['blank_id']]['first_contacts'] += $value['first_contacts'];
        $statisticResult[$value['blank_id']]['further_contacts'] += $value['further_contacts'];
      } else {
        $statisticResult[$value['blank_id']] = $value;
      }
    }

    return $statisticResult;
  }

  // check
  static function check($strOrNumer)
  {
    global $db;
    return $db->real_escape_string($strOrNumer);
  }

}


?>
