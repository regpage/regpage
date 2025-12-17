<!-- Настройки ПВОМ -->
<br>
<!-- ВКЛАДКИ -->
<ul class="nav nav-tabs" role="tablist">
  <?php foreach (['semester'=>'Настройки семестра','tables'=>'Таблицы с данными семестра ПВОМ','extra'=>'Ещё'] as $key => $value): ?>
    <li class="nav-item">
      <a class="nav-link
        <?php if ((empty($_COOKIE['ftt_settings_tab']) && $key === 'semester') || (!empty($_COOKIE['ftt_settings_tab']) && $key === $_COOKIE['ftt_settings_tab'])): ?>
        active
        <?php endif; ?>" data-toggle="tab" href="#<?php echo $key; ?>">
        <?php echo $value; ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
<!-- Подключаем файл -->
<?php
if (!empty($_COOKIE['ftt_settings_tab']) && ($_COOKIE['ftt_settings_tab'] === 'tables' || $_COOKIE['ftt_settings_tab'] === 'extra')) {
  // Подключаем файл Таблицы, Ещё
  require "components/ftt_settings/content_{$_COOKIE['ftt_settings_tab']}.php";
} else {
  // Вкладка настройки семестра по умолчанию
  require "components/ftt_settings/content_semester.php";
}
?>
