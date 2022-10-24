  <!-- Announcement -->
  <div class="container pl-0">
    <div id="list_header" class="row ftt_buttons_bar">
      <div class="col">
        <button type="button" id="announcement_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#announcement_modal_edit">Добавить</button>
      </div>
    </div>
    <div id="list_announcement" class="row">
      <div class="container">
        <div id="list_header" class="row border-bottom list_header">
            <div class="col-1"><b>Дата</b></div>
            <div class="col-2"><b>Зона</b></div>
            <div class="col-4"><b>Заголовок</b></div>
            <div class="col-3"><b>Комментарий</b></div>
            <div class="col-2"><b>Статус</b></div>
        </div>
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
          $short_comment = CutString::cut($comment);
          $short_header = CutString::cut($header);


          echo "<div class='row list_string' data-id='{$id}' data-date='{$date}' data-time='{$time}' data-publication='{$publication}' data-header='{$header}' data-author='{$member_key}' data-comment='{$comment}' data-timezone='{$timezone}' data-archive_date='{$archive_date}'><div class='col-1'>{$date_show}</div><div class='col-2'>{$timezone_show}</div><div class='col-4'>{$short_header}</div><div class='col-3'>{$short_comment}</div><div class='col-2'>{$publication_badge}</div></div>";
        }
       ?>
       </div>
    </div>
    <div class="row">

    </div>
  </div>
