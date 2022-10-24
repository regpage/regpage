<?php
// LIST
function getAnnouncements($admin_id)
{
    $result = [];
    $res = db_query("SELECT `id`, `date`, `time`, `publication`, `header`, `member_key`, `comment`, `to_14`, `to_56`, `to_coordinators`, `to_servingones`, `by_list`, `timezone`, `archive_date` FROM `ftt_announcement` WHERE 1");
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

  $publication_date = $db->real_escape_string($data->publication_date);
  $publication_time = $db->real_escape_string($data->publication_time);
  $archivation_date = $db->real_escape_string($data->archivation_date);
  $publication = $db->real_escape_string($data->publication);
  $comment = $db->real_escape_string($data->comment);
  $recipients ='';
  //$recipients = $data->recipients;
  if ($publication !== '1') {
    $recipients = $db->real_escape_string($data->recipients);
  }

  if (empty($id)) { // new
    $res = db_query("INSERT INTO `ftt_announcement` (`id`, `date`, `time`, `publication`, `header`, `content`, `member_key`, `comment`, `to_14`, `to_56`, `to_coordinators`, `to_servingones`, `by_list`, `list`, `timezone`, `archive_date`)
    VALUES ('$id', '$publication_date', '$publication_time', '$publication', '$header', '$content', '$author', '$comment', '$to_14', '$to_56', '$to_coordinators', '$to_servingones', '$by_list', '$recipients', '$time_zone', '$archivation_date')");
  } else { // update
    $res = db_query("UPDATE `ftt_announcement` SET
      `date`='$publication_date', `time`='$publication_time', `publication`='$publication', `header`='$header',
      `content`='$content', `member_key`='$author', `comment`='$comment', `to_14`='$to_14', `to_56`='$to_56',
      `to_coordinators`='$to_coordinators', `to_servingones`='$to_servingones', `by_list`='$by_list',
      `list`='$recipients', `timezone`='$time_zone', `archive_date`='$archivation_date'
      WHERE `id` = '$id'");
  }
  return $res;
}
