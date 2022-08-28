  <!-- Nav tabs
  <ul class="nav nav-tabs" role="tablist" style="display: none;">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#tab_trainee">Обучающиеся</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#tab_service_one">Служащие</a>
    </li>
  </ul> -->
  <!-- Tab panes -->
  <div class="row" style="padding-left: 15px; padding-top: 20px; padding-bottom: 20px;">
    <select id="change_tab" class="col-2 form-control form-control-sm select_bold mr-2" style="max-width: 189px;">
      <option value="tab_trainee" <?php if ($tab_active === 'tab_trainee') echo 'selected'; ?>>Обучающиеся</option>
      <option value="tab_service_one" <?php if ($tab_active === 'tab_service_one') echo 'selected'; ?>>Служащие</option>
    </select>
    <input id="search_field" class="w-50 form-control form-control-sm" type="text" placeholder="Поиск">
  </div>
  <div id="tab_content" class="tab-content">
    <div id="tab_trainee" class="tab-pane <?php if ($tab_active === 'tab_trainee') echo 'active'; ?>">
      <div class="container">
        <div id="" class="row" style="padding-bottom: 15px;">
          <select id="semester_select" class="col-2 form-control form-control-sm mr-2">
            <option value="_all_">Все семестры</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          <select id="time_zone_selected" class="col-2 form-control form-control-sm mr-2">
            <?php foreach (extra_lists::get_time_zones() as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              /*if ($value['utc'] === "0") {
                echo "<option value='{$key}' $selected>Все часовые пояса";
              } else {*/
                echo "<option value='{$key}' $selected>{$value['name']}";
              /*}*/
            endforeach; ?>
          </select>
          <select id="localities_select" class="col-2 form-control form-control-sm mr-2" name="">
            <option value="_all_">Все местности</option>
            <?php foreach ($localities as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
          <select id="sevice_one_select" class="col-2 form-control form-control-sm mr-2">
            <option value="_all_">Все служащие</option>
            <?php foreach ($serving_ones_list as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
          <select id="category_select" class="col-2 form-control form-control-sm mr-2">
              <option value="_all_" selected>Все категории</option>
              <?php foreach ($categories_list as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
          </select>
        </div>

        <div id="list_header" class="row border-bottom pb-2">
            <div class="col-2 pl-1 cursor-pointer text-info" style="min-width: 200px;">
              <b class="sorting" data-field="name">Фамиля Имя </b><?php if ($sort_field === 'name') echo $sort_icon; ?>
            </div>
            <div class="col-2 cursor-pointer text-info">
              <b class="sorting" data-field="locality_name">Город </b> <?php if ($sort_field === 'locality_name') echo $sort_icon; ?>
            </div>
            <div class="col-2" style="max-width: 140px;"><b>Телефон</b></div>
            <div class="col-3"><b>Емайл</b></div>
            <div class="col-1 cursor-pointer text-info" style="min-width: 105px;">
              <b class="sorting" data-field="birth_date">Возраст </b><?php if ($sort_field === 'birth_date') echo $sort_icon; ?>
            </div>
            <div class="col-1" style="max-width: 50px;"><b>С</b></div>
            <div class="col-1" style="max-width: 40px;"><b></b></div>
        </div>
      </div>
      <div id="list_content" class="container mb-2">
        <?php
          $current_date_z = date("Y-m-d");

          foreach ($trainee_list_list as $key => $value):
/* Получать минимум необходимый для сортировки и поиска */
// ДАННЫЕ
            $trainee_id = $value['member_key'];
            $semester = $value['semester'];
            $name = $value['name'];
            $short_name = short_name::no_middle($value['name']);
            $time_zone = $value['time_zone'];
            $male = $value['male'];
            $locality_key = $value['locality_key'];
            $serving_one = $value['serving_one'];
            $coordinator = $value['coordinator'];
            $locality_name = $value['locality_name'];
            $birth_date = $value['birth_date'];
            $age = date_convert::get_age($birth_date);
            $phone = $value['cell_phone'];
            $email = $value['email'];
            $category_key = $value['category_key'];
            $attend_meeting = $value['attend_meeting'];
            $changed = $value['changed'];

/*
          $serving_one = $value['serving_one'];

          $comment = $value['comment'];
          $comment_short;
          if (strlen($comment) > 30) {
            $comment_short = iconv_substr($comment, 0, 70, 'UTF-8');
            if (strlen($comment) >= 70) {
              $comment_short .= '...';
            }
          } else {
            $comment_short = $comment;
          }
*/
// ОТМЕТКИ И ОТОБРАЖЕНИЕ

          $show_string = '';
          $mark_string = '';
          if ($category_key !== "FT") {
            $mark_string = 'bg_pink';
          }
          $change_pencil = '';
          if ($changed === '1') {
            $change_pencil = '<i class="fa fa-pencil" title="Изменения еще не обработаны"></i>';
          }

          $attend_cheched = '';
          if ($attend_meeting === '1') {
            $attend_cheched = 'checked';
          }

          echo "<div class='row list_string {$mark_string}' data-member_key='{$trainee_id}'
          data-semester='{$semester}' data-name='{$name}'
          data-time_zone='{$time_zone}' data-male='{$male}'
          data-locality_key='{$locality_key}' data-serving_one='{$serving_one}'
          data-coordinator='{$coordinator}' data-category_key='{$category_key}'
          data-birth_date='$birth_date' data-comment='' data-toggle='modal' $show_string>
          <div class='col-2 pl-1' style='min-width: 200px;'><span class='m_name'>{$short_name} </span>(<span class='m_semester'>{$semester}</span>)</div>
          <div class='col-2'><span class='m_locality'>{$locality_name}</span>, <span class='d-none m_age'>{$age}</span><span class='d-none'> лет, {$phone}</span></div>
          <div class='col-2' style='max-width: 140px;'><span class='m_cell_phone'>{$phone}</span></div>
          <div class='col-3'><span class='m_email'>{$email}</span></div>
          <div class='col-1' style='min-width: 105px;'><span class='m_age'>{$age}</span></div>
          <div class='col-1' style='max-width: 50px;'><input type='checkbox' {$attend_cheched} disabled></div>
          <div class='col-1' style='max-width: 40px;'>{$change_pencil}</div>
          </div>";
        endforeach; ?>
      </div>
    </div>
    <div id="tab_service_one" class="container tab-pane <?php if ($tab_active === 'tab_service_one') echo 'active'; ?>">
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
          <input id="search_field_staff" class="col-2 form-control form-control-sm" type="text" placeholder="Поиск">
        </div>
        <div id="" class="row border-bottom pb-2">
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
            $time_zone_staff = $value['time_zone'];
            $gospel_team_staff = $value['gospel_team'];
            $locality_key_staff = $value['locality_key'];
            $locality_name_staff = $value['locality_name'];
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
            $attend_cheched_staff = '';
            if ($attend_meeting_staff === '1') {
              $attend_cheched_staff = 'checked';
            }

            echo "<div class='row list_string'
            data-member_key='{$service_one_id}' data-name='{$name_staff}'
            data-time_zone='{$time_zone_staff}' data-gospel_team='$gospel_team_staff'
            data-locality_key='{$locality_key_staff}' data-birth_date='{$birth_date_staff}'
            data-comment='{$comment_staff}' data-toggle='modal' $show_string_staff>
            <div class='col-2 pl-1' style='min-width: 200px;'><span class='m_name'>{$short_name_staff}</span></div>
            <div class='col-2'><span class='m_locality'>{$locality_name_staff}</span><span class='d-none m_age'>{$age}</span><span class='d-none'> лет.</span></div>
            <div class='col-2' style='max-width: 140px;'><span class='m_cell_phone'>{$phone_staff}</span></div>
            <div class='col-3'><span class='m_email'>{$email_staff}</span></div>
            <div class='col-1' style='min-width: 105px;' class='m_age'><span>{$age_staff}</span></div>
            <div class='col-1' style='max-width: 50px;'><input type='checkbox' {$attend_cheched_staff} disabled></div>
            <div class='col-1' style='max-width: 40px;'>{$change_pencil_staff}</div>
            </div>";
          endforeach;
          ?>
        </div>
    </div>
  </div>
