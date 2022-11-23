<!-- ПРЕДОСМОТР ЗАЯВЛЕНИЕ ЗАЯВИТЕЛЯ -->
<div class="row">
  <!--<div class="col"><img src="img/lsm-logo.png" alt=""></div>-->
  <div class="col">
    <!-- ЗАГОЛОВОК -->
    <h5>Заявление для участия в Полновременном обучении</h5>
    <h6><?php echo getValueFttParamByName("semester"); ?>  (<?php echo getValueFttParamByName("period"); ?>)<h6>
    <hr style="margin: 0;">
  </div>
</div>
<!-- PERSONAL DATA раздел 1
<div class="row">
  <div class="col">
    <h6>ЛИЧНЫЕ ДАННЫЕ</h6>
  </div>
</div>-->
<!-- БЛОК 1 -->
<!-- ФИО -->
<div class="row">
  <div class="col">
    <span class=""><span>Фамилия Имя Отчество</span>: </span>
    <input id="member_fio" type="text" class="input-request i-width-280-px" required data-member_key="<?php echo $request_data['m_key']; ?>" data-table="member" data-field="name" data-value="<?php echo $request_data['name']; ?>"
     value="<?php echo $request_data['name']; ?>">
   </div>
</div>
<!-- Дата рождения, возраст -->
<div class="row">
  <div class="col">
    <span class=""><span>Дата рождения</span>: </span>
    <input type="date" class="input-request b-width-150-px" data-table="member" data-field="birth_date" data-value="<?php echo $birth_date; ?>" value="<?php echo $birth_date; ?>" required>
    <span>(<?php echo intval($request_data['age'] / 1); ?> <?php echo $age_word; ?>)</span>
  </div>
</div>
<!-- Пол
<div class="row">
  <div class="col">
    <label for="brother">Брат: </label><input type="checkbox" id="brother" class="input-request" data-table="member" data-field="male"  value="1" style="margin-right: 25px;" required
        <?php if ($request_data['male'] == 1): ?>
          checked
        <?php endif; ?>
      >
    <label for="sister"> Сестра: </label><input type="checkbox" id="sister" class="input-request" data-table="member" data-field="male" value="0" required
        <?php if ($request_data['male'] == 0): ?>
          checked
        <?php endif; ?>
      >
  </div>
</div>-->
      <!-- БЛОК 2 -->
      <div class="row">
      <!-- Местность -->
      <div class="col">
        <span class="">Город: </span>
        <select class="i-width-280-px" data-table="member" data-field="locality_key" data-value="<?php echo $request_data['locality_key']; ?>" required>
          <?php
              foreach (db_getLocalities() as $id => $name) {
                if ($id == $request_data['locality_key']) {
                  $selected_locality = 'selected';
                } else {
                  $selected_locality = '';
                }
                echo "<option value='$id' $selected_locality>".htmlspecialchars ($name)."</option>";
              };
          ?>
          <!-- <?php // echo $request_data['locality_name']; ?>-->
        </select>
      </div>
    </div>
    <div class="row">
      <!-- Страна -->
      <div class="col">
        <span class="">Страна: </span>
        <select id="request_country_key" class="b-width-150-px" disabled data-field="country_key" data-value="<?php echo $request_data['country_key']; ?>" required>
          <option value=""></option>
          <?php foreach ($countries1 as $id => $name) {
            if ($id == $request_data['country_key']) {
              $selected_country = 'selected';
            } else {
              $selected_country = '';
            }
            echo "<option value='$id' $selected_country>".htmlspecialchars ($name)."</option>";
          } ?>
          <option disabled="disabled">---------------------------</option>
          <?php foreach ($countries2 as $id => $name) {
            if ($id == $request_data['country_key']) {
              $selected_country = 'selected';
            } else {
              $selected_country = '';
            }
            echo "<option value='$id'>".htmlspecialchars ($name)."</option>";
          } ?>
          <!-- <?php // echo $request_data['country_name']; ?>-->
        </select>
      </div>
    </div>
    <!-- Гражданство -->
    <div class="row">
      <div class="col"><span class="">Гражданство: </span>
        <select class="b-width-150-px" data-table="member" data-field="citizenship_key" data-value="<?php echo $request_data['citizenship_key']; ?>" required>
          <option value=""></option>
          <?php foreach ($countries1 as $id => $name) {
            if ($id == $request_data['citizenship_key']) {
              $selected_country = 'selected';
            } else {
              $selected_country = '';
            }
            echo "<option value='$id' $selected_country>".htmlspecialchars ($name)."</option>";
          } ?>
          <option disabled="disabled">---------------------------</option>
          <?php foreach ($countries2 as $id => $name) {
            if ($id == $request_data['citizenship_key']) {
              $selected_country = 'selected';
            } else {
              $selected_country = '';
            }
            echo "<option value='$id' $selected_country>".htmlspecialchars ($name)."</option>";
          } ?>
        </select>
      </div>
    </div>
    <!-- ДОКУМЕНТЫ раздел 2 -->
    <div class="row">
      <div class="col">
        <h6>ДОКУМЕНТЫ</h6>
      </div>
    </div>
    <!-- БЛОК 3 -->
    <div class="row">
      <!-- Паспорт или ID карта -->
      <div class="col">
        <span class="">Номер паспорта или ID карты: </span>
        <input type="text" class="input-request b-width-150-px" data-table="member" data-field="document_num" data-value="<?php echo $request_data['document_num']; ?>" value="<?php echo $request_data['document_num']; ?>" required>
      </div>
    </div>
    <!-- Дата выдачи -->
    <div class="row">
      <div class="col">
        <span class=""><span>Дата выдачи паспорта или ID</span>: </span>
        <input type="date" class="input-request b-width-150-px" data-table="member" data-field="document_date" data-value="<?php echo $request_data['document_date']; ?>" value="<?php echo $request_data['document_date']; ?>" required>
      </div>
    </div>
    <!-- Срок действия истекает -->
    <div class="row">
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Если в вашем документе не указан срок действия, оставьте это поле пустым.">Cрок действия истекает:</span> </span>
        <input type="text" class="input-request b-width-150-px"  data-field="passport_exp" data-value="<?php echo $request_data['passport_exp']; ?>" value="<?php echo $request_data['passport_exp']; ?>">
      </div>
    </div>
    <!-- БЛОК 4 -->
    <div class="row">
      <!-- Кем выдан -->
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Напишите в точности так, как указано в вашем паспорте.">Кем выдан паспорт или ID:</span> </span>
        <input type="text" class="input-request i-width-long" data-table="member" data-field="document_auth" data-value = "<?php echo $request_data['document_auth']; ?>"
        value="<?php echo $request_data['document_auth']; ?>" required>
      </div>
    </div>
    <!-- БЛОК 5 -->
    <div class="row">
      <!-- Код подразделения -->
      <div class="col" title="">
        <span class="">Код подразделения: </span>
        <input type="text" class="input-request b-width-150-px" data-table="member" data-field="document_dep_code" data-value="<?php echo $request_data['document_dep_code']; ?>"
        value="<?php echo $request_data['document_dep_code']; ?>" required>
      </div>
    </div>
    <!-- ИНН -->
    <div class="row">
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Если вы не знаете свой ИНН (номер налогоплательщика), узнайте его на сайте nalog.ru.">ИНН:</span> </span>
        <input type="text" class="input-request b-width-150-px" data-field="inn" data-value = "<?php echo $request_data['inn']; ?>"
        value="<?php echo $request_data['inn']; ?>" required>
      </div>
    </div>
    <!-- БЛОК 5 -->
    <div class="row">
      <!-- Загранпаспорт -->
      <div class="col">
        <span class="">Номер загранпаспорта: </span>
        <input type="text" class="input-request b-width-150-px" data-table="member" data-field="tp_num" data-value="<?php echo $request_data['tp_num']; ?>" value="<?php echo $request_data['tp_num']; ?>" required>
      </div>
    </div>
    <!-- Кем выдан -->
    <div class="row">
      <div class="col">
        <span class="">Кем выдан загранпаспорт: </span>
        <input type="text" class="input-request b-width-150-px" data-table="member" data-field="tp_auth" data-value="<?php echo $request_data['tp_auth']; ?>" value="<?php echo $request_data['tp_auth']; ?>" required>
      </div>
    </div>
    <!-- Срок действия истекает -->
    <div class="row">
      <div class="col">
        <span class="">Cрок действия истекает:</span>
        <input type="date" class="input-request b-width-150-px" data-table="member" data-field="tp_date" data-value="<?php echo $request_data['tp_date']; ?>" value="<?php echo $request_data['tp_date']; ?>" required>
      </div>
    </div>
    <!-- ОБРАЗОВАНИЕ И ПРОФЕССИЯ раздел 3 -->
    <div class="row">
      <div class="col">
        <h6>ОБРАЗОВАНИЕ И ПРОФЕССИЯ</h6>
      </div>
    </div>
    <!-- БЛОК 6 -->
    <div class="row">
      <!-- Образование -->
      <div class="col"><span class="">Образование: </span>
        <select class="i-width-280-px" data-field="education" required>
          <option value=""></option>
          <option value="1"
          <?php if ($request_data['education'] === '1'): ?>
            selected
          <?php endif; ?>
          >основное общее</option>
          <option value="2"
          <?php if ($request_data['education'] === '2'): ?>
            selected
          <?php endif; ?>
          >среднее общее</option>
          <option value="3"
          <?php if ($request_data['education'] === '3'): ?>
            selected
          <?php endif; ?>
          >среднее профессиональное</option>
          <option value="4"
          <?php if ($request_data['education'] === '4'): ?>
            selected
          <?php endif; ?>
          >незаконченное высшее</option>
          <option value="5"
          <?php if ($request_data['education'] === '5'): ?>
            selected
          <?php endif; ?>
          >высшее</option>
          <option value="6"
          <?php if ($request_data['education'] === '6'): ?>
            selected
          <?php endif; ?>
          >высшее (магистратура)</option>
          <option value="7"
          <?php if ($request_data['education'] === '7'): ?>
            selected
          <?php endif; ?>
          >второе высшее</option>
        </select>
      </div>
    </div>
      <!-- Специальность -->
    <div class="row">
      <div class="col"><span class="">Специальность: </span><input type="text" class="input-request i-width-280-px" data-field="profession" data-value="<?php echo $request_data['profession']; ?>" value="<?php echo $request_data['profession']; ?>" required></div>
    </div>
      <!-- Какими языками владеете -->
    <div class="row">
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Если вы владеете только одним языком (вашим родным), напишите только его. Если вы знаете несколько языков, перечислите их через запятую.">Какими языками владеете:</span> </span><input type="text" class="input-request i-width-280-px" data-field="language" data-value="<?php echo $request_data['language']; ?>" value="<?php echo $request_data['language']; ?>" required></div>
    </div>
    <!-- БЛОК 7 -->
    <div class="row">
      <!-- Род занятий -->
      <div class="col m-b-15px">
        <span class="">Род занятий (в прошлом и настоящем): </span>
        <input type="text" class="input-request i-width-long" data-field="occupation" data-value="<?php echo $request_data['occupation']; ?>" value="<?php echo $request_data['occupation']; ?>" required>
      </div>
    </div>
    <!-- КОНТАКТНЫЕ ДАННЫЕ раздел 4 -->
    <div class="row">
      <div class="col">
        <h6>КОНТАКТНЫЕ ДАННЫЕ</h6>
      </div>
    </div>
    <!-- БЛОК 8 -->
    <div class="row">
      <!-- Email -->
      <div class="col"><span class="">Email: </span>
        <input type="text" class="input-request" data-table="member" data-field="email" data-value="<?php echo $request_data['email']; ?>"
        value="<?php echo $request_data['email']; ?>" style="width: 279px;" required></div>
    </div>
      <!-- Сотовый телефон -->
    <div class="row">
      <div class="col"><span class="">Телефон (моб.): </span>
        <input type="text" class="input-request b-width-150-px" data-table="member" data-field="cell_phone" data-value="<?php echo $request_data['cell_phone']; ?>"
        value="<?php echo $request_data['cell_phone']; ?>" required></div>
    </div>
    <!-- Телефон (дом.) -->
    <div class="row">
      <div class="col"><span class="">
        <span class="help-underline" data-tooltip="Если у вас нет домашнего телефона, оставьте это поле пустым.">Телефон (дом.):</span> </span>
        <input type="text" class="input-request b-width-150-px"  data-field="phone_home" data-value="<?php echo $request_data['phone_home']; ?>" value="<?php echo $request_data['phone_home']; ?>">
      </div>
    </div>
    <!-- БЛОК 9 -->
    <div class="row">
      <!-- Адрес постоянной прописки -->
      <div class="col m-b-15px">
        <span class="">Адрес постоянной прописки: </span>
        <input type="text" class="input-request i-width-long" data-field="reg_address" data-value="<?php echo $request_data['reg_address']; ?>" value="<?php echo $request_data['reg_address']; ?>" required>
      </div>
    </div>
    <!-- БЛОК 10 -->
    <div class="row">
      <!-- Фактический адрес проживания -->
      <div class="col m-b-15px">
        <span class="">Фактический адрес проживания (почтовый): </span>
        <input type="text" class="input-request i-width-long" data-table="member" data-field="address" data-value="<?php echo $request_data['address']; ?>" value="<?php echo $request_data['address']; ?>" required>
      </div>
    </div>
    <!-- СПАСЕНИЕ И ЦЕРКОВНАЯ ЖИЗНЬ раздел 5 -->
    <div class="row">
      <div class="col">
        <h6>СПАСЕНИЕ И ЦЕРКОВНАЯ ЖИЗНЬ</h6>
      </div>
    </div>
    <!-- БЛОК 11 -->
    <div class="row">
      <!-- Дата спасения -->
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Дата спасения:</span> </span>
        <input type="text" class="input-request b-width-150-px"  data-field="salvation_date"  data-value="<?php echo $request_data['salvation_date']; ?>" value="<?php echo $request_data['salvation_date']; ?>" required>
      </div>
    </div>
    <!-- Дата крещения -->
    <div class="row">
      <div class="col"><span class=""><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Дата крещения:</span></span>
        <input type="text" class="input-request b-width-150-px" data-table="member" data-field="baptized" data-value = "<?php echo $baptized_date; ?>" value="<?php echo $baptized_date; ?>" required></div>
    </div>
    <!-- Когда вы пришли в церковную жизнь -->
    <div class="row">
      <div class="col "><span><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Когда вы пришли в церковную жизнь:</span> </span>
        <input type="text" class="input-request i-width-long"  data-field="church_life_date" data-value="<?php echo $request_data['church_life_date']; ?>" value="<?php echo $request_data['church_life_date']; ?>" required></div>
    </div>
    <!-- БЛОК 40 -->
    <div class="row">
      <div class="col "><span class="">Вы в церковной жизни в городе: </span>
      <input type="text" class="input-request i-width-long"  data-field="	church_life_city" data-value="<?php echo $request_data['church_life_city']; ?>" value="<?php echo $request_data['church_life_city']; ?>" required></div>
    </div>
    <!-- БЛОК 12 -->
    <div class="row">
      <!-- В скольких пятидневных -->
      <div class="col "><span class="">В скольких пятидневных обучениях в Москве вы участвовали? </span>
        <input type="text" class="input-request i-width-long"  data-field="swt_num" data-value="<?php echo $request_data['swt_num']; ?>" value="<?php echo $request_data['swt_num']; ?>" required></div>
    </div>
    <!-- БЛОК 13 -->
    <div class="row">
      <!-- В скольких обучениях ответственных братьев -->
      <div class="col "><span class="">В скольких Обучениях для ответственных братьев вы участвовали? </span>
      <input type="text" class="input-request i-width-long" data-field="rbr_num" data-value="<?php echo $request_data['rbr_num']; ?>" value="<?php echo $request_data['rbr_num']; ?>" required></div>
    </div>
    <!-- БЛОК 14 -->
    <?php if (!$is_guest): ?>
    <div class="row">
      <!-- Сколько семестров Полновременного Обучения вы закончили? -->
      <div class="col ">
        <span class="">Сколько семестров Полновременного обучения вы закончили? </span>
        <input type="text" class="input-request i-width-long" data-field="ftt_num" data-value="<?php echo $request_data['ftt_num']; ?>" value="<?php echo $request_data['ftt_num']; ?>">
        </div>
    </div>
    <div class="row">
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Когда:</span> </span>
        <input type="text" class="input-request b-width-150-px" data-field="ftt_date" data-value="<?php echo $request_data['ftt_date']; ?>" value="<?php echo $request_data['ftt_date']; ?>">
      </div>
    </div>
    <?php endif; ?>
    <?php if ($is_guest): ?>
    <div class="row">
        <div class="col ">
          <span>В течении какого периода времени вы хотели бы участвовать в обучении? </span>
          <span> С </span><input type="text" class="input-request b-width-150-px"  data-field="guest_time_from" data-value="<?php echo $request_data['guest_time_from']; ?>" value="<?php echo $request_data['guest_time_from']; ?>" required>
          <span> по </span><input type="text" class="input-request b-width-150-px"  data-field="guest_time_to" data-value="<?php echo $request_data['guest_time_to']; ?>" value="<?php echo $request_data['guest_time_to']; ?>" required>
        </div>
    </div>

  <?php endif; ?>
    <!-- СЕМЕЙНОЕ ПОЛОЖЕНИЕ раздел 6 -->
    <div class="row">
      <div class="col">
        <h6>СЕМЕЙНОЕ ПОЛОЖЕНИЕ</h6>
      </div>
    </div>
    <!-- БЛОК 15 -->
    <div class="row">
        <div class="col">
            <span class="">Семейное положение: </span>
            <select id="marriage_select" class="b-width-150-px" data-field="marital_status" data-value="<?php echo $request_data['marital_status']; ?>" required>
                <option value=""></option>
                <option value="1" <?php if ($request_data['marital_status'] === '1') : echo 'selected'; endif; ?>>не состою в браке</option>
                <option value="2" <?php if ($request_data['marital_status'] === '2') : echo 'selected'; endif; ?>>состою в браке</option>
                <option value="3" <?php if ($request_data['marital_status'] === '3') : echo 'selected'; endif; ?>><?php echo $pomolvlen; ?></option>
                <option value="4" <?php if ($request_data['marital_status'] === '4') : echo 'selected'; endif; ?>><?php echo $razveden; ?></option>
                <option value="5" <?php if ($request_data['marital_status'] === '5') : echo 'selected'; endif; ?>><?php echo $vdova; ?></option>
            </select>
        </div>
    </div>
    <!-- БЛОК 16 -->
    <div class="row divorce_block">
      <!-- Разведён(а) когда -->
        <div class="col"><span class="">
          <span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Когда:</span> </span>
          <input type="text" class="input-request b-width-150-px" data-field="marital_info" data-value="<?php echo $request_data['marital_info']; ?>" value="<?php echo $request_data['marital_info']; ?>" required>
        </div>
    </div>
    <!-- БЛОК 17 -->
    <div class="row widow_block">
      <!-- Овдовел(а) когда -->
        <div class="col">
          <span class=""><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">С какого времени:</span> </span>
          <input type="text" class="input-request b-width-150-px" data-field="marital_info" data-value="<?php echo $request_data['marital_info']; ?>" value="<?php echo $request_data['marital_info']; ?>" required>
        </div>
    </div>
    <!-- БЛОК 18 -->
    <div class="row marriage_block">
      <!-- Дата свадьбы -->
      <div class="col">
        <span class="">Дата свадьбы: </span>
        <input type="text" class="input-request b-width-150-px" data-field="marital_info" data-value="<?php echo $request_data['marital_info']; ?>" value="<?php echo $request_data['marital_info']; ?>" required>
      </div>
    </div>
    <!-- БЛОК 19 -->
    <div class="row marriage_block">
      <!-- Ф.И.О супруга -->
        <div class="col">
          <span class="">Ф.И.О <?php $request_data['male']; ?> <?php echo $suprug; ?> </span>
          <input type="text" class="input-request i-width-220-px" data-field="spouse_name" data-value="<?php echo $request_data['spouse_name']; ?>" value="<?php echo $request_data['spouse_name']; ?>" required>
        </div>
      </div>
      <!-- Возраст супруга -->
      <div class="row marriage_block">
        <div class="col">
          <span class="">Возраст <?php echo $suprug; ?>: </span>
          <input type="text" class="input-request b-width-150-px" data-field="spouse_age" data-value="<?php echo $request_data['spouse_age']; ?>" value="<?php echo $request_data['spouse_age']; ?>" required>
        </div>
    </div>
    <!-- БЛОК 20 -->
    <div class="row marriage_block">
      <!-- Он(она) верующий(ая)? -->
      <div class="col" style="padding-right: 0px;"><span class="span-label-width-275"><?php echo $who; ?> <?php echo $verujuschiy; ?>? </span>
        <select class="b-width-100-px" data-field="spouse_faith" required>
          <option value=""></option>
          <option value="yes" <?php if ($request_data['spouse_faith'] === 'yes'):?> selected <?php endif; ?>>да</option>
          <option value="no" <?php if ($request_data['spouse_faith'] === 'no'): ?> selected <?php endif; ?>>нет</option>
        </select>
      </div>
    </div>
    <!-- Он(она) находится в церковной жизни? -->
    <div class="row marriage_block">
      <div class="col"><span class="span-label-width-275"><?php echo $who; ?> находится в церковной жизни? </span>
        <select class="b-width-100-px" data-field="spouse_church" required>
          <option value=""></option>
          <option value="yes" <?php if ($request_data['spouse_church'] === 'yes'):?> selected <?php endif; ?>>да</option>
          <option value="no" <?php if ($request_data['spouse_church'] === 'no'): ?> selected <?php endif; ?>>нет</option>
        </select>
      </div>
    </div>
    <!-- Отношение супруга (и) к вашему участию в Обучении -->
    <div class="row marriage_block">
      <div class="col">
        <span>Отношение <?php echo $suprug; ?> к вашему участию в Обучении: </span>
        <select class="" data-field="spouse_state" data-value="<?php echo $request_data['spouse_state']; ?>" required>
          <option value=""></option>
          <option value="positive" <?php if ($request_data['spouse_state'] === 'positive') : echo 'selected'; endif; ?>>положительное</option>
          <option value="negative" <?php if ($request_data['spouse_state'] === 'negative') : echo 'selected'; endif; ?>>отрицательное</option>
        </select>
      </div>
    </div>
    <!-- БЛОК 21 -->
    <!-- Письменное заявление супруга -->
    <div class="row marriage_block">
      <div class="col">
        <strong>Если вы <?php echo $v_brake; ?>, то вам необходимо присоединить к вашему заявлению письменное согласие <?php echo $vashego; ?> <?php echo $suprug; ?> на ваше участие в Полновременном обучении.</strong>
      </div>
    </div>
    <!-- БЛОК 22 -->
    <div class="row marriage_block">
      <!-- файл со сканом заявления -->
      <div class="col">
        <span>Файл со сканом или фотографией заявления</span>
        <input type="file" class="input-request" data-field="spouse_consent" accept=".jpg, .jpeg, .png, .pdf" required>
      </div>
      <div class="col">
        <a href="<?php echo $request_data['spouse_consent']; ?>" target="blank"><img src="<?php echo $img_link_spouse_consent; ?>" alt="" style="height:100px;"></a><i class="fa fa-trash pic-delete" aria-hidden="true"></i>
      </div>
    </div>
    <?php if (!$is_guest): ?>
    <!-- БЛОК 23 -->
    <div class="row support_block">
      <!-- кто находится на вашем иждивении -->
      <div class="col"><span>Пожалуйста, приведите имена и возраст всех, кто находится на вашем иждивении:</span></div>
    </div>
    <!-- БЛОК 24 -->
    <!-- КНОПКА ДОБАВИТЬ -->
    <div class="row support_block"><div class="col"><button type="button" id="add_support_block_extra" class="btn btn-info"> <b>+</b> Добавить</button></div></div>
    <!-- Дополнительный блок -->
    <?php include_once "application_extra.php"; ?>
    <!-- БЛОК 29 -->
    <br>
    <div class="row support_block_extra who-extra">
      <!-- каким образом они будут обеспечены материально -->
      <div class="col m-b-15px"><span>Если вы поступите на Обучение, кто сможет позаботиться о них, и каким образом они будут обеспечены материально? </span></div>
    </div>
    <div class="row support_block_extra who-extra">
      <div class="col"><input type="text" class="input-request i-width-long-one" data-field="support_info" data-value="<?php echo $support_info_part_who; ?>" value="<?php echo $support_info_part_who; ?>" required></div>
    </div>
    <!-- ФИНАНСОВЫЕ ВОПРОСЫ раздел 7 -->
    <div class="row">
      <div class="col">
        <h6>ФИНАНСОВЫЕ ВОПРОСЫ</h6>
      </div>
    </div>
    <?php endif; ?>
    <?php if (!$is_guest): ?>
      <!-- БЛОК 30 -->
    <div class="row">
      <!-- PAY -->
      <div class="col"><span>Затраты Обучения составляют сейчас <?php echo $ftt_monthly_pay; ?> рублей в месяц (<?php echo $ftt_monthly_pay * 4; ?> рублей за семестр) на одного обучающегося. Мы просим каждого обучающегося в обязательном порядке вносить по крайней мере <?php echo $ftt_min_pay; ?> рублей в месяц (<?php echo $ftt_min_pay * 4; ?> рублей за семестр).</span></div>
    </div>
    <!-- БЛОК 31 -->
    <div class="row">
      <!-- Сумма -->
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip ="Если у вас есть какие-то комментарии, добавьте их в этом поле после суммы.">Укажите сумму, которую вы можете внести за семестр:</span> </span>
        <input type="text" class="input-request i-width-long" data-field="semester_pay" data-value="<?php echo $request_data['semester_pay']; ?>" value="<?php echo $request_data['semester_pay']; ?>" required>
      </div>
    </div>
    <?php endif; ?>
    <?php if ($is_guest): ?>
      <!-- БЛОК 32 -->
    <div class="row">
      <!-- PAY GUEST -->
      <div class="col"><span>Затраты Полновременного обучения составляют сейчас <?php echo $ftt_monthly_pay; ?> рублей в месяц на одного обучающегося. Мы просим вас полностью покрывать свои расходы. Если вы не можете покрыть свои расходы полностью, мы просим вас сообщить нам об этом, так как это потребует дополнительного общения.</span></div>
    </div>
    <!-- БЛОК 33 -->
    <div class="row">
      <!-- Сумма гость -->
      <div class="col">
        <span>Можете ли вы покрыть свои расходы полностью? </span>
        <input type="text" class="input-request i-width-long" data-field="semester_pay" data-value="<?php echo $request_data['semester_pay']; ?>" value="<?php echo $request_data['semester_pay']; ?>" required>
      </div>
    </div>
    <?php endif; ?>
    <!-- ЗДОРОВЬЕ раздел 8 -->
    <div class="row">
      <div class="col">
        <h6>ЗДОРОВЬЕ</h6>
      </div>
    </div>
    <!-- БЛОК 34 -->
    <div class="row">
      <!-- проблемы со здоровьем -->
      <div class="col"><span>Физическое и психологическое состояние вашего здоровья: </span>
      <!-- оценка здоровья -->
        <select class="" data-field="health_condition" data-value="<?php echo $request_data['health_condition']; ?>" required>
          <option value=""></option>
          <option value="good" <?php if ($request_data['health_condition'] === 'good') : echo 'selected'; endif; ?>>хорошее</option>
          <option value="middle" <?php if ($request_data['health_condition'] === 'middle') : echo 'selected'; endif; ?>>среднее</option>
          <option value="bad" <?php if ($request_data['health_condition'] === 'bad') : echo 'selected'; endif; ?>>плохое</option>
        </select>
      </div>
    </div>
    <!-- БЛОК 35 -->
    <div class="row">
      <!-- Проблемы со здоровьем -->
      <div class="col m-b-15px">
        <span>
          <span class="help-underline" data-tooltip='Если у вас нет проблем со здоровьем, напишите "Проблем со здоровьем нет".'>Существующие проблемы со здоровьем:</span>
          <input type="text" class="input-request i-width-long" list="health_list" data-field="health_problems" data-value="<?php echo $request_data['health_problems']; ?>" value="<?php echo $request_data['health_problems']; ?>" required>
          <datalist id="health_list">
            <option value="Проблем со здоровьем нет"></option>
          </datalist>
        </span>
      </div>
    </div>
    <!-- БЛОК 36 -->
    <div class="row">
      <!-- психические расстройства -->
      <div class="col"><span>Проходили ли вы лечение от психических расстройств? </span>
        <select class="" data-field="mental_problems" data-value="<?php echo $request_data['mental_problems']; ?>" required>
          <option value=""></option>
          <option value="no" <?php if ($request_data['mental_problems'] === 'no') : echo 'selected'; endif; ?>>нет</option>
          <option value="yes" <?php if ($request_data['mental_problems'] === 'yes') : echo 'selected'; endif; ?>>да</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col mental_problems_block">
        <span class="" for="mental_yes"><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Когда:</span> </span>
        <input type="text" class="input-request b-width-150-px" data-field="mental_problems_when" data-value="<?php echo $request_data['mental_problems_when']; ?>" value="<?php echo $request_data['mental_problems_when']; ?>" required>
      </div>
    </div>
    <!-- БЛОК 37 -->
    <div class="row">
      <!-- Зависимости -->
      <div class="col"><span>От алкогольной или наркотической зависимости? </span>
        <select class="" data-field="dependency_problems" data-value="<?php echo $request_data['dependency_problems']; ?>" required>
            <option value=""></option>
            <option value="no" <?php if ($request_data['dependency_problems'] === 'no') : echo 'selected'; endif; ?>>нет</option>
            <option value="yes" <?php if ($request_data['dependency_problems'] === 'yes') : echo 'selected'; endif; ?>>да</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col dependency_problems_block">
        <span for="alcohol_yes" class="span-label-width-210"><span class="help-underline" data-tooltip="Если вы знаете точную дату, напишите её в формате дд.мм.гггг. Если вы не помните точную дату, напишите месяц и год или только год.">Когда:</span> </span>
        <input type="text" class="input-request b-width-150-px" data-field="dependency_problems_when" data-value="<?php echo $request_data['dependency_problems_when']; ?>" value="<?php echo $request_data['dependency_problems_when']; ?>" required>
      </div>
    </div>
    <!-- БЛОК 38 -->
    <div class="row mental_dependency_problems_block">
      <!-- Подробности о псих. расстройствах и /или зависимостях -->
      <div class="col">
        <span>Подробности: </span>
        <input type="text" class="input-request i-width-long" data-field="problems_info" data-value="<?php echo $request_data['problems_info']; ?>" value="<?php echo $request_data['problems_info']; ?>" required>
      </div>
    </div>
    <!-- Мотивы и уточнения раздел 9 -->
    <div class="row">
      <div class="col">
        <h6>ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ И МОТИВЫ</h6>
      </div>
    </div>
    <!-- БЛОК 39 -->
    <div class="row">
      <div class="col">
        <span>Кто из соработников или ответственных братьев знает вас лучше всего? </span>
        <input type="text" class="input-request i-width-long" data-field="known_to" data-value="<?php echo $request_data['known_to']; ?>" value="<?php echo $request_data['known_to']; ?>">
      </div>
    </div>
    <!-- БЛОК 41 -->
    <div class="row">
      <div class="col"><strong>Коротко изложите свои переживания спасения и крещения, свой опыт церковной жизни и, в частности, причины, по которым вы желаете участвовать в Полновременном обучении: </strong></div>
    </div>
    <!-- БЛОК 42 -->
    <div class="row">
      <div class="col"><textarea rows="4" cols="30" class="t-width-long" data-field="request_info" data-value="<?php echo $request_data['request_info']; ?>" required><?php echo $request_data['request_info']; ?></textarea></div>
    </div>
    <!-- КОПИЯ ПАСПОРТА раздел 10 -->
    <div class="row">
      <div class="col">
        <h6>КОПИЯ ПАСПОРТА</h6>
      </div>
    </div>
    <!-- БЛОК 43 -->
    <div class="row">
      <div class="col"><span>Скан или фото паспорта (страницы с фотографией и пропиской). Не более трёх(3) файлов.: </span><input type="file" class="input-request" multiple data-field="passport_scan" accept=".jpg, .jpeg, .png, .pdf" required></div>
    </div>
    <!-- БЛОК 44 -->
    <div class="row">
      <div class="col"><a href="<?php echo $request_data['passport_scan']; ?>" target="_blank"><img src="<?php echo $img_scan_1; ?>" alt="" style="height:100px;"></a><i class="fa fa-trash pic-delete" aria-hidden="true"></i></div>
      <div class="col"><a href="<?php echo $request_data['passport_scan_2']; ?>" target="_blank"><img src="<?php echo $img_scan_2; ?>" alt="" style="height:100px;"></a><i class="fa fa-trash pic-delete" aria-hidden="true"></i></div>
      <div class="col"><a href="<?php echo $request_data['passport_scan_3']; ?>" target="_blank"><img src="<?php echo $img_scan_3; ?>" alt="" style="height:100px;"></a><i class="fa fa-trash pic-delete" aria-hidden="true"></i></div>
    </div>
    <!-- ВОПРОСЫ раздел 11 -->
    <div class="row">
      <div class="col">
        <h6>ВОПРОСЫ</h6>
      </div>
    </div>
    <!-- БЛОК 45 -->
    <div class="row">
      <div class="col">
        <span><span class="help-underline" data-tooltip="Если у вас нет вопросов, оставьте это поле пустым.">Вопросы, которые вы хотели бы задать служащим Полновременного обучения:</span> </span>
        <input type="text" class="input-request i-width-long" data-field="questions" data-value="<?php echo $request_data['questions']; ?>" value="<?php echo $request_data['questions']; ?>">
      </div>
    </div>
    <!-- ПОДПИСЬ И СОГЛАСИЕ раздел 12 -->
    <div class="row">
      <div class="col">
        <h6>ПОДПИСЬ И СОГЛАСИЕ</h6>
      </div>
    </div>
    <!-- БЛОК 46 -->
    <div class="row">
      <div class="col"><input type="checkbox" id="policy_agree" class="input-request" data-table="" data-field="agreement" data-value="" value="" required <?php echo $agreement; ?>>
      <label for="policy_agree"> даю согласие на обработку персональных данных <!--(<a href="#">согласие</a>)--></label></div>
    </div>
    <!-- БЛОК 47 -->
    <div class="row">
      <div class="col">
        <span class=""><span class="help-underline" data-tooltip="Напишите здесь ваши имя и фамилию. Это поле считается простой электронной подписью.">Подпись кандидата:</span> </span>
        <input type="text" class="input-request i-width-280-px" data-field="candidate_signature" data-value="<?php echo $request_data['candidate_signature']; ?>" value="<?php echo $request_data['candidate_signature']; ?>" required>
      </div>
    </div>
    <div class="row">
      <div class="col"><span><b><?php echo $status_phrase; ?></b></span></div>
    </div>
    <!-- ВЫВОДИТЬ ТОЛЬКО ПОСЛЕ ОТПРАВКИ ЗАЯВЛЕНИЯ. ЗАПОЛНЯТЬ В МОМЕНТ НАЖАТИЯ ОТПРАВЛЕНО-->
    <div class="row" <?php echo $status_application_show; ?>>
      <div class="col"><span class="span-label-width-210"> Дата отправки заявления: </span><input type="date" disabled class="input-request b-width-150-px" data-field="send_date" data-value="<?php echo $request_data['send_date']; ?>" value="<?php echo $request_data['send_date']; ?>"></div>
    </div>
