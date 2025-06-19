<?php
// ЕЖЕДНЕВНАЯ ПРОВЕРКА НАЛИЧИЕ ПОЛЬЗОВАТЕЛЕЙ БЕЗ СОГЛАСИЙ
include_once 'config.php';
function getAdminsKyesWithoutAgreement(): array
{
  $result = [];
  $res = db_query("SELECT ad.member_key AS m_key, m.name, ads.id_session AS session, ads.time_create
    FROM admin ad
    LEFT JOIN member m ON m.key = ad.member_key
    LEFT JOIN agreement ag ON ag.member_key=ad.member_key
    LEFT JOIN admin_session ads ON ads.admin_key=ad.member_key
    WHERE ag.member_key IS NULL AND ad.member_key NOT LIKE '9900%'");
  while ($row = $res->fetch_assoc()) $result[$row['m_key']] = $row;
  return $result;
}

function addAgreementMass(array $adminsData): string
{
  $result = '';
  foreach ($adminsData as $key => $value) {
    $timeCreate = ' NOW() ';
    if ($value['time_create']) {
      $timeCreate = "'{$value['time_create']}'";
    }
    $result .= db_query("INSERT INTO `agreement` (`member_key`, `fio`, `session_id`, `type`, `agree`, `date_agreement`, `comment`) VALUES ('{$value['m_key']}', '{$value['name']}', '{$value['session']}', 'personal data', 1, {$timeCreate}, 'Создано автоматически на основании предыдущих данных.')");
  }

  return $result;
}
$arr = [];

$arr = getAdminsKyesWithoutAgreement();
echo "Всего " . count($arr) . " записей<br>";
if (isset($arr['000005716']) || isset($arr['000010810'])) {
  echo 'Дубликаты присутствуют в наборе';
} else {
  $answer = addAgreementMass($arr);
  echo "{$answer}<br>Дубликаты в наборе осутствуют";
}
