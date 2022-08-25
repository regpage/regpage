
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

          <input id="search_field" class="col-1 form-control form-control-sm" type="text" placeholder="Поиск">
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
            $show_string = '';

          echo "<div class='row list_string' data-member_key='{$trainee_id}'
          data-semester='{$semester}' data-name='{$name}'
          data-time_zone='{$time_zone}' data-male='{$male}'
          data-locality_key='{$locality_key}' data-serving_one='{$serving_one}'
          data-coordinator='{$coordinator}' data-category_key='{$category_key}'
          data-birth_date='$birth_date' data-comment='' data-toggle='modal' $show_string>
          <div class='col-2 pl-1' style='min-width: 200px;'><span class='m_name'>{$short_name} </span>(<span class='m_semester'>{$semester}</span>)</div>
          <div class='col-2'><span class='m_locality'>{$locality_name} </span><span class='d-none m_age'>{$age}</span><span class='d-none'> лет.</span></div>
          <div class='col-2' style='max-width: 140px;'><span class='m_cell_phone'>{$phone}</span></div>
          <div class='col-3'><span class='m_email'>{$email}</span></div>
          <div class='col-1' style='min-width: 105px;'><span class='m_age'>{$age}</span></div>
          <div class='col-1' style='max-width: 50px;'><span>{$attend_meeting}</span></div>
          <div class='col-1' style='max-width: 40px;'><span m_changed>{$changed}</span></div>
          </div>";
        endforeach; ?>
      </div>
