        <div class="row" style="padding-bottom: 15px;">
          <select id="time_zones_staff" class="col-2 form-control form-control-sm mr-2">
            <?php foreach (extra_lists::get_time_zones() as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value['name']} ({$value['utc']})";
            endforeach; ?>
          </select>
          <select id="localities_staff" class="col-2 form-control form-control-sm mr-2">
            <option value="_all_">Все местности</option>
            <?php foreach ($localities_staff as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
          <!--<input id="search_field_staff" class="col-2 form-control form-control-sm" type="text" placeholder="Поиск">-->
        </div>
        <div id="list_header_staff" class="row border-bottom pb-2">
          <div class="col-2 pl-1 cursor-pointer text-info" style="min-width: 200px;">
            <b class="sorting_staff" data-field="name">Фамиля Имя</b>
            <?php if ($sort_field_staff === 'name') echo $sort_icon_staff; ?>
          </div>
          <div class="col-2 cursor-pointer text-info">
            <b class="sorting_staff" data-field="locality_name">Город</b>
            <?php if ($sort_field_staff === 'locality_name') echo $sort_icon_staff; ?>
          </div>
          <div class="col-2" style="max-width: 140px;"><b>Телефон</b></div>
          <div class="col-3"><b>Емайл</b></div>
          <div class="col-1 cursor-pointer text-info" style="min-width: 105px;">
            <b class="sorting_staff" data-field="birth_date">Возраст</b>
            <?php if ($sort_field_staff === 'birth_date') echo $sort_icon_staff; ?>
          </div>
          <div class="col-1" style="max-width: 50px;"><b>С</b></div>
          <div class="col-1" style="max-width: 40px;"><b></b></div>
        </div>
        <div id="list_content_staff" class="mb-2">
          <?php
          foreach ($serving_ones_list_list as $key => $value):
            $show_string_staff = '';
            //$service_one_id = $key; // выдаёт порядковый номер ходя должен быть member_key
            $service_one_id = $value['member_key'];
            $name_staff = $value['name'];
            $short_name_staff = short_name::no_middle($value['name']);
            $male = $value['male'];
            $time_zone_staff = $value['time_zone'];
            $gospel_team_staff = $value['gospel_team'];
            $locality_key_staff = $value['locality_key'];
            $locality_name_staff = $value['locality_name'];
            $new_locality_staff = $value['new_locality'];
            $birth_date_staff = $value['birth_date'];
            $age_staff = date_convert::get_age($birth_date_staff);
            $phone_staff = $value['cell_phone'];
            $email_staff = $value['email'];
            $attend_meeting_staff = $value['attend_meeting'];
            $comment_staff = $value['comment'];
            $changed_staff = $value['changed'];
            $change_pencil_staff = '';
            if ($changed_staff === '1') {
              $change_pencil_staff = '<i class="fa fa-pencil" title="Изменения еще не обработаны"></i>';
            }

            $locality_name_for_list = $locality_name_staff;
            if (empty($locality_name_for_list)) {
              $locality_name_for_list = $new_locality_staff;
            }
            $attend_checked_staff = '';
            if ($attend_meeting_staff === '1') {
              $attend_checked_staff = 'checked';
            }

            echo "<div class='row list_string'
            data-member_key='{$service_one_id}' data-name='{$name_staff}'
            data-time_zone='{$time_zone_staff}' data-gospel_team='$gospel_team_staff'
            data-locality_key='{$locality_key_staff}' data-birth_date='{$birth_date_staff}'
            data-male ='{$male}'
            data-comment='{$comment_staff}' data-toggle='modal' $show_string_staff>
            <div class='col-2 pl-1' style='min-width: 200px;'><span class='m_name'>{$short_name_staff}</span></div>
            <div class='col-2'><span class='m_locality'>{$locality_name_for_list}</span><span class='d-none m_age'>, {$age_staff}</span><span class='d-none'> лет, {$phone_staff}</span></div>
            <div class='col-2' style='max-width: 140px;'><span class='m_cell_phone'>{$phone_staff}</span></div>
            <div class='col-3'><span class='m_email'>{$email_staff}</span></div>
            <div class='col-1' style='min-width: 105px;'><span class='m_age'>{$age_staff}</span></div>
            <div class='col-1' style='max-width: 50px;'><input type='checkbox' class='attend_chbox' data-field='attend_meeting' {$attend_checked_staff} ></div>
            <div class='col-1' style='max-width: 40px;'>{$change_pencil_staff}</div>
            </div>";
          endforeach;
          /*<div class='col-2'><span class='m_locality'>{$locality_name_for_list}</span><span class='d-none m_age'>{$age}</span><span class='d-none'> лет.</span></div>
          <div class='col-2' style='max-width: 140px;'><span class='m_cell_phone'>{$phone_staff}</span></div>
          <div class='col-3'><span class='m_email'>{$phone_staff}</span></div>
          <div class='col-1' style='min-width: 105px;' class='m_age'><span>{$age_staff}</span></div>
          <div class='col-1' style='max-width: 50px;'><input type='checkbox' class='attend_chbox_staff' data-field='attend_meeting' {$attend_checked_staff}></div>
          <div class='col-1' style='max-width: 40px;'>{$change_pencil_staff}</div>*/
          ?>
        </div>
