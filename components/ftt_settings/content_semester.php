<!-- Настройки семестра -->
<div class="row pt-3">
  <div class="col-12">
    <h5>Настройки семестра</h5>
    <span class="grey_text">Данные из таблицы ftt_param</span>
  </div>
</div>
<!-- Таблицы с данными ПВОМ -->
<div class="row pt-3">
  <div class="col-12">
    <p>
      <?php
      $paramsNames = [
        'schedule_end' => 'Дата завершения показа расписания',
        'schedule_start' => 'Дата начала показа рассписания',
        'attendance_end' => 'Дата завершения учёта посещаемости',
        'attendance_start' => 'Дата начала учёта посещаемости',
        'acceptance_of_applications' => 'Открыт приём заявлений на ПВОМ (1/0)',
        'consecration' => 'Согласие с положениями и требованиями ПВОМ (посвящение)',
        'extrahelp_service_id' => 'Ключ (06) служения с доб. заданиями (координатор)',
        'ftt_text' => 'Текст на главной странице о запросе заявления на ПВОМ',
        'interview_help' => 'Пояснения к результатам собеседования',
        'min_baptism' => 'Минимальные цели благовестия: крещения',
        'min_flyers' => 'Минимальные цели благовестия: листовки',
        'min_fruit' => 'Минимальные цели благовестия: остающиеся плоды',
        'min_pay' => 'Минимальный платёж за ПВОМ (рубли)',
        'min_pay_dlr' => 'Минимальный платёж за ПВОМ (доллары)',
        'min_people' => 'Минимальные цели благовестия: скольким людям хотите благовествовать в течении недели',
        'min_prayers' => 'Минимальные цели благовестия: спасённые',
        'monthly_pay' => 'Ежемесячный платёж за ПВОМ (рубли)',
        'monthly_pay_dlr' => 'Ежемесячный платёж за ПВОМ (доллары)',
        'request_bottom' => 'Информация по завершении заполнеия заявления на ПВОМ',
        'request_candidate_info' => 'Информация (справка) о заполнении заяввления на ПВОМ',
        'request_interview_info' => 'Информация для проводящего собеседование',
        'request_recommend_info' => 'Информация для того, кто составляет рекомендацию'
      ];
      foreach (fttParam::getAll() as $value) {
        $fullName = '';
        if (isset($paramsNames[$value['name']])) {
          $fullName = $paramsNames[$value['name']];
        }
        $editBtn = "<button type='button' class='btn btn-warning btn-sm mx-2 py-0 edit_param_btn' style='padding-left: 6px; padding-right: 6px;' data-param='{$value['name']}' data-param_value='{$value['value']}' data-title='{$paramsNames[$value['name']]}'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
        if (mb_strlen(strip_tags($value['value'])) > 30) {
          $shortValue = CutString::cut(strip_tags($value['value']), 30);
          $collapse = "<a class='btn btn-sm btn-primary btn-primary py-0' data-toggle='collapse' href='#collapse{$value['name']}' role='button' aria-expanded='false' aria-controls='collapse{$value['name']}'><b>+</b></a><div class='collapse mt-2' id='collapse{$value['name']}'><div class='card card-body'>{$value['value']}</div></div>";
        } else {
          $shortValue = trim($value['value']);
          $collapse = '';
        }
        echo "<span>{$fullName}<br><i><span class='grey_text'>({$value['name']})</span></i><br><span> {$shortValue}</span> {$editBtn} {$collapse} </span><hr style='border-top: 1px dashed #6c757d;'>";
      }
      ?>
    </p>
  </div>
</div>
<hr class="mb-2 mt-2">
