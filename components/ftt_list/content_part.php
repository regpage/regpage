  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" style="display: none;">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#tab_trainee">Обучающиеся</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#tab_service_one">Служащие</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div class="row">
    <select id="change_tab" class="col-2 form-control form-control-sm">
      <option value="tab_trainee">Обучающиеся</option>
      <option value="tab_service_one">Служащие</option>
    </select>
  </div>
  <div id="tab_content" class="tab-content">
    <div id="tab_trainee" class="tab-pane active"><br>
      <div class="container">
        <div id="bar_extra_help" class="row mb-2">
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
                echo "<option value='{$key}' $selected>{$value['name']} ({$value['utc']})";
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
          <select id="sevice_one_select" class="col-2 form-control form-control-sm">
            <option value="_all_">Все служащие</option>
            <?php foreach ($serving_ones_list as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
        </div>

        <div id="list_header" class="row border-bottom">
            <div class="col-2 pl-1"><b>Фамиля Имя</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-3"><b>Поле</b></div>
            <div class="col-2"><b>Поле</b></div>
        </div>
      </div>
      <div id="list_content" class="container mb-2">
        <?php
          $current_date_z = date("Y-m-d");

          foreach ($trainee_list_list as $key => $value):
/* Получать минимум необходимый для сортировки и поиска */
            $trainee_id = $key;
            $semester = $value['semester'];
            $name = $value['name'];
            $short_name = short_name::no_middle($value['name']);
            $time_zone = $value['time_zone'];
            $male = $value['male'];
            $locality_key = $value['locality_key'];
            $serving_one = $value['serving_one'];
            $coordinator = $value['coordinator'];
/*
          $serving_one = $value['serving_one'];
          $date_born = $value['date_born'];
          $age = 0;

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
          $show_string = '';

          echo "<div class='row list_string cursor-pointer' data-id='' data-date='' data-member_key='{$trainee_id}' data-semester='{$semester}' data-date_name='{$name}' data-time_zone='{$time_zone}' data-male='{$male}' data-locality='' data-locality_key='{$locality_key}' data-serving_one='{$serving_one}' data-coordinator='{$coordinator}'
          data-age='' data-comment='' data-toggle='modal' $show_string>
          <div class='col-7 pl-1'><span class=''>{$short_name}</span><span>({$semester})</span></div>
          <div class='col-1'><span class='trainee_name'>{$time_zone}</span></div>
          <div class='col-1'><span class='trainee_name'>{$male}</span></div>
          <div class='col-1'><span class='trainee_name'></span></div>
          <div class='col-1'><span class='trainee_name'></span></div>
          <div class='col-1'><span class='trainee_name'></span></div>
          </div>";
        endforeach; ?>
      </div>
    </div>
    <div id="tab_service_one" class="container tab-pane"><br>
        <div id="" class="row mb-2">
          <select class="col-2 form-control form-control-sm mr-2" name="">
            <?php foreach (extra_lists::get_time_zones() as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value['name']} ({$value['utc']})";
            endforeach; ?>
          </select>
          <select class="col-2 form-control form-control-sm" name="">
            <option value="">Все местности</option>
            <?php foreach ($localities_staff as $key => $value):
              $selected = '';
              /*if ($key === $serving_one_selected) {
                $selected = 'selected';
              }*/
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
        </div>
        <div id="" class="row border-bottom">
            <div class="col-5 pl-1"><b>Фамиля Имя</b></div>
            <div class="col-3"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
            <div class="col-1"><b>Поле</b></div>
        </div>
        <div id="" class="mb-2">
          <?php
          foreach ($serving_ones_list_list as $key => $value):
            $show_string_staff = '';
            $service_one_id = $key;
            $name_staff = $value['name'];
            $short_name_staff = short_name::no_middle($value['name']);
            $time_zone_staff = $value['time_zone'];
            $gospel_team_staff = $value['gospel_team'];
            $locality_key_staff = $value['locality_key'];
            echo "<div class='row list_string_staff cursor-pointer' data-id='' data-date='' data-member_key='{$service_one_id}' data-semester='' data-date_name='{$name_staff}' data-time_zone='{$time_zone_staff}'
            data-gospel_team='$gospel_team_staff' data-locality='' data-locality_key='{$locality_key_staff}' data-age='' data-comment='' data-toggle='modal' $show_string>
            <div class='col-7 pl-1'><span class=''>{$short_name_staff}</span></div>
            <div class='col-1'><span class=''>{$time_zone_staff}</span></div>
            <div class='col-1'><span class=''>{$gospel_team_staff}</span></div>
            <div class='col-1'><span class=''></span></div>
            <div class='col-1'><span class=''></span></div>
            <div class='col-1'><span class=''></span></div>
            </div>";
          endforeach;
          ?>
        </div>
    </div>
  </div>
