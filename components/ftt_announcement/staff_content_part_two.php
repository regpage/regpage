<!-- INBOX -->
  <div class="ftt_buttons_bar btn-group" style="padding-top: 21px;">
    <select id="flt_read" class="form-control form-control-sm mr-2">
      <option value="_all_">Все</option>
      <option value="1">Прочитанные</option>
      <option value="0">Не прочитанные</option>
    </select>
  </div>
  <div id="list_header_inbox" class="row list_header" style="margin-left: 0px; padding-bottom: 10px; border-bottom: 1px lightgray solid;">
      <div class="col-2 pl-1"><b>Дата</b></div>
      <div class="col-5"><b>Заголовок</b></div>
      <div class="col-3"><b>Группы получателей</b></div>
      <div class="col-2"><b>Часовые пояса</b></div>
  </div>
  <?php
    foreach (getAnnouncementsForRecipient($memberId) as $key => $value) {

      $date = $value['date'];
      $date_show = date_convert::yyyymmdd_to_ddmm($value['date']);
      $header = $value['header'];
      $content = $value['content'];
      $author = $value['author'];
      $archive_date = $value['archive_date'];
      $time = $value['time'];
      $time_zone_text = $gl_time_zones[$value['time_zone']];
      $id = $value['id'];
      $noticed_date = $value['notice'];
      $notice = '';
      if (!$value['notice']) {
        $notice = 'bg-notice-string';
      }

      $recipients_groups_text = '';
      if ($value['to_14']) {
        $recipients_groups_text .= '1-4';
      }
      if($value['to_56']) {
        $recipients_groups_text ? $recipients_groups_text .= ', 5-6' : $recipients_groups_text .= '5-6';
      }
      if ($value['to_coordinators']) {
        $recipients_groups_text ? $recipients_groups_text .= ', координаторы' : $recipients_groups_text .= 'координаторы';
      } elseif ($value['to_servingones']) {
        $recipients_groups_text ? $recipients_groups_text .= ', служащие' : $recipients_groups_text .= 'служащие';
      } elseif ($value['by_list']) {
        $recipients_groups_text ? $recipients_groups_text .= ', по списку' : $recipients_groups_text .= 'по списку';
      }
      if ($noticed_date && $archive_date && !DatesCompare::isMoreThanCurrent($archive_date)) {
        // nothing
      } else {
        echo "<div class='row {$notice} list_string'
        data-id_announcement='{$id}' data-header='{$header}' data-content='{$content}' data-author='{$author}' data-time='{$time}' data-archive_date='{$archive_date}' data-date='{$date}' data-notice='{$noticed_date}'>
        <div class='col-2 pl-1'>{$date_show}</div><div class='col-5'>{$header}</div><div class='col-3'>{$recipients_groups_text}</div><div class='col-2'>{$time_zone_text}</div></div>";
      }
    }
  ?>
