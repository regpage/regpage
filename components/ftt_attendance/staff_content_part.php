<?php
namespace App\Ui\Components\Lists;

?>
<style>
#list_content {
  padding-left: 0px;
  padding-right: 0px;
}
#ftt_sub_container {
  margin-right: 0px !important;
  padding-right: 0px !important;
}
</style>
<div id="extra_help_staff" class="container">
  <!-- Nav tabs-->
  <br>
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_attendance_active; ?>" data-toggle="tab" href="#current_extra_help">Листы посещаемости</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_permission_active; ?>" data-toggle="tab" href="#permission_tab">
        Листы отсутствия <?php echo $permission_statistics; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_missed_class_active; ?>" data-toggle="tab" href="#missed_class_tab">
        Пропущенные занятия <?php echo $missed_class_statistics; ?>
      </a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div id="tab_content_extra_help" class="tab-content">
    <div id="current_extra_help" class="container tab-pane <?php echo $tab_attendance_active; ?>"><br>
      <div id="bar_extra_help" class="btn-group mb-2">
        <select id="sevice_one_select" class="form-control form-control-sm">
          <option value="_all_">Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $serving_one_selected) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <?php
        $selected_week = '';
        $selected_month = '';
        $selected_all = '';
        if (isset($_COOKIE['filter_period_att'])) {
          $selected_week = '';
          $selected_month = '';
          $selected_all = '';
          if ($_COOKIE['filter_period_att'] === 'week') {
            $selected_week = 'selected';
          } elseif ($_COOKIE['filter_period_att'] === 'month') {
            $selected_month = 'selected';
          } else {
            $selected_all = 'selected';
          }
        }
        ?>
      </div>
      <div id="list_content" class="row">
        <div class="" id="accordion_attendance">
          <hr style="margin-left: 12px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
        <?php
          $filter_period_att = 'week';
          $prev_member_key = '';
          $id_head_start = '';
          $list_access = '_all_';

          // RENDER LIST
          $dataForAttendanceList = PrepareAttendanceListArray::prepare(getFttAttendanceSheetAndStrings($list_access, $filter_period_att, $serving_one_selected));

          foreach ($dataForAttendanceList as $key => $value) {
            $traineeName = RenderColAttandanceName::render($value);
            echo "<div data-member_key='{$key}' style='margin-top: 2px;'>";
            echo "<div class='card_header cursor-pointer'>";
            echo "<button class='btn btn-link'>{$traineeName}</button>";
            echo RenderColAttandanceDays::render($value['attendance_sheets']);
            echo RenderColAttandanceComment::render($value);
            echo "</div></div>";
          }




        ?>
        </div>
      </div>
    </div>
    <div id="permission_tab" class="tab-pane container <?php echo $tab_permission_active; ?>">
      <?php
      // if ($tab_permission_active === 'active') {
        include 'components/ftt_attendance/staff_content_part_permission.php';
      //}
      ?>
    </div>
    <div id="missed_class_tab" class="tab-pane container <?php echo $tab_missed_class_active; ?>">
      <?php
      //if ($tab_missed_class_active === 'active') {
        include 'components/ftt_attendance/content_classes.php';
      //}
       ?>
    </div>
  </div>
</div>
