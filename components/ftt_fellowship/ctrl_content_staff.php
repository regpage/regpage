<?php
// Сортировка

if (isset($_COOKIE['meet_sorting'])) {
  $meet_curent_sorting = $_COOKIE['meet_sorting'];
  $fa_sort_arr = explode('-', $meet_curent_sorting);
  if (isset($fa_sort_arr[1]) && $fa_sort_arr[1] === 'asc') {
    $fa_sort = 'fa fa-sort-asc';
  } elseif (isset($fa_sort_arr[1]) && $fa_sort_arr[1] === 'desc') {
    $fa_sort = 'fa fa-sort-desc';
  }
  if ($fa_sort_arr[0] === 'meet_sort_date') {
    $meet_sort_date_ico = $fa_sort;
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_servingone') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = $fa_sort;
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_trainee') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = $fa_sort;
    $meet_sort_time_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_time') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = $fa_sort;
  } else {
    $meet_sort_date_ico = 'fa fa-sort-asc';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = 'hide_element';
    $meet_curent_sorting = 'meet_sort_date-asc';
  }
} else {
  $meet_sort_date_ico = 'fa fa-sort-asc';
  $meet_sort_s_one_ico = 'hide_element';
  $meet_sort_trainee_ico = 'hide_element';
  $meet_sort_time_ico = 'hide_element';
  $meet_curent_sorting = 'meet_sort_date-asc';
}

// Фильтры
// вкладка служащие
if ($fellowship_bbd_tab_active !== 'active') {
  if (!empty($_COOKIE['meet_flt_staff'])) {
    $serving_ones_flt = $_COOKIE['meet_flt_staff'];
  } else {
    $serving_ones_flt = $memberId;
  }

  if (!empty($_COOKIE['meet_flt_trainee'])) {
    $trainee_flt = $_COOKIE['meet_flt_trainee'];
  } else {
    $trainee_flt = '_all_';
  }

  if (isset($_COOKIE['meet_flt_active'])) {
    $active_flt = $_COOKIE['meet_flt_active'];
  } else {
    $active_flt = 1;
  }
} else { // вкладка братья кбк
  if (!empty($_COOKIE['meet_flt_kbk'])) {
    $serving_ones_flt = $_COOKIE['meet_flt_kbk'];
  } else {
    $serving_ones_flt = '_allkbk_';
  }
  if (!empty($_COOKIE['meet_flt_trainee_kbk'])) {
    $trainee_flt = $_COOKIE['meet_flt_trainee_kbk'];
  } else {
    $trainee_flt = '_all_';
  }

  if (isset($_COOKIE['meet_flt_active_kbk'])) {
    $active_flt = $_COOKIE['meet_flt_active_kbk'];
  } else {
    $active_flt = 1;
  }
}
