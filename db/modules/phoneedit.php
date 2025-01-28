<?php
// подготавливаем номер телефона
function phoneNumberPrepare($tel) {
  if (empty($tel)) {
    return '';
  }
  $result = "+";
  for ($i = 0; $i < strlen($tel); $i++) {
    if ($i === 0 || $i === 3 || $i === 6) {
      $result .= $tel[$i] . " ";
    } else {
      $result .= $tel[$i];
    }
  }
  return $result;
}
