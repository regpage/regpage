  <!-- Announcement -->
  <!-- OUTBOX -->
  <div class="container pl-0">
    <br>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link <?php echo $tab_two_active; ?>" data-toggle="tab" href="#announcement_tab_2">
          Входящие <?php echo $announcements_statistics; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo $tab_one_active; ?>" data-toggle="tab" href="#announcement_tab_1">Исходящие </a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div id="" class="tab-content">
      <div id="announcement_tab_1" class="tab-pane <?php echo $tab_one_active; ?>">
        <div class="row">
          <div class="ftt_buttons_bar btn-group" style="padding-left: 15px; padding-top: 21px;">
            <button type="button" id="announcement_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#announcement_modal_edit">Добавить</button>
            <button type="button" id="modal_flt_open" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#announcement_modal_flt" style="display: none;">Фильтры</button>
            <select id="flt_service_ones" class="form-control form-control-sm mr-2" name="" style="width: 180px">
              <?php FTT_Select_fields::rendering($serving_ones_list, $memberId, 'Все служащие') ?>
            </select>
            <select id="flt_time_zone" class="form-control form-control-sm mr-2">
              <?php FTT_Select_fields::rendering($gl_time_zones, '01'); ?>
            </select>
            <select id="flt_public" class="form-control form-control-sm mr-2">
              <option value="_all_">Текущие</option>
              <option value="2">Архивные</option>
            </select>
          </div>
        </div>
        <div id="list_announcement" class="row">
          <div class="container" style="padding-left: 13px;  padding-bottom: 0px;">
            <div id="list_header" class="row list_header" style="margin-left: -4px; padding-bottom: 10px; border-bottom: 1px lightgray solid; display: none;">
              <div class="col-1 pl-1"><b>Дата</b></div>
              <div class="col-2"><b>Часовой пояс</b></div>
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
              $time_zone = $value['time_zone'];
              $time_zone_show = $gl_time_zones[$time_zone];
              $archive_date = $value['archive_date'];

              $is_active = true;
              $badge_text = 'не опубликованно';
              $badge_class = 'warning';

              if ($date !== '0000-00-00' && $date && $publication) {
                if ($time) {
                  $is_active = !DatesCompare::isMoreThanCurrentTime($date.' '.$time);
                } else {
                  $is_active = !DatesCompare::isMoreThanCurrent($date);
                }
              }

              if ($archive_date !== '0000-00-00' && $archive_date && $is_active && $publication) {
                $is_active = DatesCompare::isMoreThanCurrent($archive_date);
                if (!$is_active) {
                  $badge_text = 'архив';
                  $badge_class = 'secondary';
                }
              }

              if ($publication && $is_active) {
                $text_badge = 'опубликованно';
                $publication_badge = "<span class='badge badge-success'>{$text_badge}</span>";
            } else {
              $publication_badge = "<span class='badge badge-{$badge_class}'>{$badge_text}</span>";
            }
            $short_comment = CutString::cut($comment);
            $short_header = $header; // CutString::cut($header);

            $show_string = 'style="display: none"';
            if ($memberId === $member_key && $badge_text !== 'архив') {
              $show_string = '';
            }

            echo "<div class='row list_string' {$show_string} data-id='{$id}' data-date='{$date}' data-time='{$time}' data-publication='{$publication}' data-header='{$header}' data-author='{$member_key}' data-comment='{$comment}' data-time_zone='{$time_zone}' data-archive_date='{$archive_date}'><div class='col-1 pl-1'>{$date_show}</div><div class='col-2'>{$time_zone_show}</div><div class='col-4'>{$short_header}</div><div class='col-3'>{$short_comment}</div><div class='col-2'>{$publication_badge}</div><div class='col-12' style='display:none;'>{$short_header}</div><div class='col-12 light_text_grey' style='display:none;'>{$short_comment}</div></div>";
          }
          ?>
       </div>
     </div>
    </div>
  <!-- INBOX -->
  <div id="announcement_tab_2" class="tab-pane <?php echo $tab_two_active; ?>">
  <?php include_once 'components/ftt_announcement/staff_content_part_two.php';  ?>
  </div>
  </div>
</div>
