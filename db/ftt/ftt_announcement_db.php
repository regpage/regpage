<?php
// LIST
function getAnnouncements($admin_id)
{
    $result = [];
    $res = db_query("SELECT `id`, `date`, `time`, `publication`, `header`, `member_key`, `comment`, `to_14`, `to_56`, `to_coordinators`, `to_servingones`, `by_list`, `time_zone`, `archive_date` FROM `ftt_announcement` WHERE 1");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
}

function getAnnouncement($id)
{
    $result = [];
    $res = db_query("SELECT * FROM `ftt_announcement` WHERE `id`=$id");
    while ($row = $res->fetch_assoc()) $result = $row;
    return $result;
}

// BLANK
function saveAnnouncement($data)
{
  global $db;
  $data = json_decode($data);
  $id = $db->real_escape_string($data->id);
  $author = $db->real_escape_string($data->author);
  $to_14 = $db->real_escape_string($data->to_14);
  $to_56 = $db->real_escape_string($data->to_56);
  $to_coordinators = $db->real_escape_string($data->to_coordinators);
  $to_servingones = $db->real_escape_string($data->to_servingones);
  $by_list = $db->real_escape_string($data->by_list);
  $time_zone = $db->real_escape_string($data->time_zone);
  $header = $db->real_escape_string($data->header);
  $content = $db->real_escape_string($data->content);
  $recipients = $db->real_escape_string($data->recipients);
  $groups = $db->real_escape_string($data->groups);
  $publication_date = $db->real_escape_string($data->publication_date);
  $publication_time = $db->real_escape_string($data->publication_time);
  $archivation_date = $db->real_escape_string($data->archivation_date);
  $publication = $db->real_escape_string($data->publication);
  $comment = $db->real_escape_string($data->comment);

  if ($publication === '1') {
    if ($by_list === '1' && $recipients) {
      $groups .= $recipients;
    }
    $groups = array_unique(explode(",", $groups));
    // добавляем получателей
    $check_exist = [];
    $res_2 = db_query("SELECT `member_key` FROM `ftt_announcement_recipients` WHERE `id_announcement` = '$id'");
    while ($row = $res_2->fetch_assoc()) $check_exist[] = $row['member_key'];
    if (count($check_exist) === 0) {
      foreach ($groups as $key => $value) {
        db_query("INSERT INTO `ftt_announcement_recipients` (`id_announcement`, `member_key`) VALUES ('$id', '$value')");
      }
    } else {
      $elements_for_add = array_diff($groups, $check_exist);
      foreach ($elements_for_add as $key => $value) {
        db_query("INSERT INTO `ftt_announcement_recipients` (`id_announcement`, `member_key`) VALUES ('$id', '$value')");
      }
      $elements_for_delete = array_diff($check_exist, $groups);
      foreach ($elements_for_delete as $key => $value) {
        db_query("DELETE FROM `ftt_announcement_recipients` WHERE `member_key`='$value' AND `id_announcement` = '$id'");
      }
    }
  }

  if (empty($id)) { // new
    $res = db_query("INSERT INTO `ftt_announcement` (`id`, `date`, `time`, `publication`, `header`, `content`, `member_key`, `comment`, `to_14`, `to_56`, `to_coordinators`, `to_servingones`, `by_list`, `list`, `time_zone`, `archive_date`)
    VALUES ('$id', '$publication_date', '$publication_time', '$publication', '$header', '$content', '$author', '$comment', '$to_14', '$to_56', '$to_coordinators', '$to_servingones', '$by_list', '$recipients', '$time_zone', '$archivation_date')");
  } else { // update
    $res = db_query("UPDATE `ftt_announcement` SET
      `date`='$publication_date', `time`='$publication_time', `publication`='$publication', `header`='$header',
      `content`='$content', `member_key`='$author', `comment`='$comment', `to_14`='$to_14', `to_56`='$to_56',
      `to_coordinators`='$to_coordinators', `to_servingones`='$to_servingones', `by_list`='$by_list',
      `list`='$recipients', `time_zone`='$time_zone', `archive_date`='$archivation_date'
      WHERE `id` = '$id'");
  }
  return $res;
}
