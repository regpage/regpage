<?php
include_once 'config.php';

$books = [
  ['Быт.', 50],
  ['Исх.', 40],
  ['Лев.', 27],
  ['Числ.', 36],
  ['Втор.', 34],
  ['Иис.Н.', 24],
  ['Суд.', 21],
  ['Руф.', 4],
  ['1 Цар.', 31],
  ['2 Цар.', 24],
  ['3 Цар.', 22],
  ['4 Цар.', 25],
  ['1 Пар.', 29],
  ['2 Пар.', 36],
  ['Эздр.', 10],
  ['Неем.', 13],
  ['Эсф.', 10],
  ['Иов.', 42],
  ['Пс.', 150],
  ['Прит.', 31],
  ['Эккл.', 12],
  ['Песн.П.', 8],
  ['Ис.', 66],
  ['Иер.', 52],
  ['Плач.', 5],
  ['Иез.', 48],
  ['Дан.', 12],
  ['Ос.', 14],
  ['Иоил.', 3],
  ['Ам.', 9],
  ['Авд.', 1],
  ['Ион.', 4],
  ['Мих.', 7],
  ['Наум.', 3],
  ['Авв.', 3],
  ['Соф.', 3],
  ['Агг.', 2],
  ['Зах.', 14],
  ['Мал.', 4],
  ['Мф.', 28],
  ['Мк.', 16],
  ['Лк.', 24],
  ['Ин.', 21],
  ['Деян.', 28],
  ['Рим.', 16],
  ['1 Кор.', 16],
  ['2 Кор.', 13],
  ['Гал.', 6],
  ['Эф.', 6],
  ['Флп.', 4],
  ['Кол.', 4],
  ['1 Фес.', 5],
  ['2 Фес.', 3],
  ['1 Тим.', 6],
  ['2 Тим.', 4],
  ['Тит.', 3],
  ['Флм.', 1],
  ['Евр.', 13],
  ['Иак.', 5],
  ['1 Пет.', 5],
  ['2 Пет.', 3],
  ['1 Ин.', 5],
  ['2 Ин.', 1],
  ['3 Ин.', 1],
  ['Иуд.', 1],
  ['Отк.', 22]
];

foreach ($books as $value) {
  $res = db_query("INSERT INTO `bible` (`book`, `chapter`) VALUES ('{$value[0]}', '{$value[1]}')");
  if ($res) {
    $text = $value[0] . ' ' . $value[1] . ' —  OK<br>';
    echo $text;
  }
  /*for ($i=1; $i <= $value[1]; $i++) {
    $res = db_query("INSERT INTO `bible` (`book`, `chapter`) VALUES ('{$value[0]}', '{$i}')");
    if ($res) {
      $text = $value[0] . ' ' . $i . ' —  OK<br>';
      echo $text;
    }
  }*/
}