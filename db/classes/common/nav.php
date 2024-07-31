<?php
/**
 * Роли (role):
 * 0 для всех, доступ без авторизации
 * 1 для всех авторизованных пользователей
 * 2 для администраторов сайта 0
 * 3 для администраторов сайта 1
 * 4 для администраторов сайта 2
 * 5 для разработчиков сайта
 * Группы (group):
 * all любой авторизованный пользователь (раздел не обязательно доступен по умолчанию, доступ может регулироваться настройками и доп. списками)
 * для пользователей сайта регистрации в соответствии с ролью и др. настройками доступа такими как заоны и тп
 * zone пользователи с зонами
 * ftt разделы ПВОМ
 * mng админы роль 2
 * dvlp разработчики
 */
class Nav
{

  function __construct(argument)
  {
    // code...
  }

  static function points($role='')
  {

    $points = array(
      'login.php' => array('role'=> 0, 'position'=> 0, 'group'=> 'all', 'active'=> 1, 'description'=>'Авторизация на сайте'),
      'signup.php' => array('role'=> 0, 'position'=> 0, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'passrec.php' => array('role'=> 1, 'position'=> 0, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'profile.php' => array('role'=> 1, 'position'=> 0, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'settings.php' => array('role'=> 1, 'position'=> 0, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'index.php' => array('role'=> 1, 'position'=> 1, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'reg.php' => array('role'=> 0, 'position'=> 2, 'group'=> 'zone', 'active'=> 1, 'description'=>''),
      'member.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'zone', 'active'=> 1, 'description'=>''),
      'attend.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'zone', 'active'=> 1, 'description'=>''),
      'youth.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'zone', 'active'=> 1, 'description'=>''),
      'list.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'mng', 'active'=> 1, 'description'=>''),
      'activity.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'mng', 'active'=> 1, 'description'=>''),
      'meetings.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'reg', 'active'=> 1, 'description'=>''),
      'visits.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'reg', 'active'=> 1, 'description'=>''),
      'vtraining.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'reg', 'active'=> 1, 'description'=>''),
      'statistic.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'reg', 'active'=> 1, 'description'=>''),
      'ch_statistic.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'reg', 'active'=> 1, 'description'=>''),
      'contacts.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'practices.php' => array('role'=> 0, 'position'=> 0, 'group'=> 'all', 'active'=> 0, 'description'=>'Учёт ежедневных практик'),
      'reference.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'mng', 'active'=> 1, 'description'=>''),
      'panel.php' => array('role'=> 5, 'position'=> 1, 'group'=> 'dvlp', 'active'=> 1, 'description'=>''),
      'application.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'all', 'active'=> 1, 'description'=>''),
      'ftt_service.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_extrahelp.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_announcement.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_absence.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_schedule.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_list.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_application.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_attendance.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_gospel.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_fellowship.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_reading.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'ftt_settings.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'ftt', 'active'=> 1, 'description'=>''),
      'opros.php' => array('role'=> 0, 'position'=> 1, 'group'=> 'all', 'active'=> 1, 'description'=>'Опрос для пира любви в Москве, доступ без авторизации.')
    );
  }
}
