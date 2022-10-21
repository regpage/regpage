  <!-- Announcement -->
  <div class="container pl-0">
    <div id="list_header" class="row ftt_buttons_bar">
      <div class="col">
        <button type="button" id="announcement_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#announcement_modal_edit">Добавить</button>
      </div>
    </div>
    <div id="list_announcement" class="row">
      <div class="container">
      <?php
        foreach (getAnnouncements(1) as $key => $value) {
          $id = $value['id'];
          $date = $value['date'];
          $date_show = date_convert::yyyymmdd_to_ddmm($value['date']);
          $time = $value['time'];
          $publication = $value['publication'];
          $header = $value['header'];
          $member_key = $value['member_key'];
          $comment = $value['comment'];
          $timezone = $value['timezone'];
          $timezone_show = $gl_time_zones[$timezone];
          $archive_date = $value['archive_date'];

          if ($publication) {
            $publication_badge = '<span class="badge badge-info">Опубликованно</span>';
          } else {
            $publication_badge = '<span class="badge badge-secondary">Не публикованно</span>';
          }

          echo "<div class='row list_string' data-id='{$id}' data-date='{$date}' data-time='{$time}' data-publication='{$publication}' data-header='{$header}' data-author='{$member_key}' data-comment='{$comment}' data-timezone='{$timezone}' data-archive_date='{$archive_date}'><div class='col'>{$date_show}</div><div class='col'>{$timezone_show}</div><div class='col'>{$header}</div><div class='col'>{$comment}</div><div class='col'>{$publication_badge}</div></div>";
        }
       ?>
       </div>
    </div>
    <div class="row">

    </div>
  </div>
