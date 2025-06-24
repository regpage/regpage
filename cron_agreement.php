<?php
// ЕЖЕДНЕВНАЯ ПРОВЕРКА НАЛИЧИЕ ПОЛЬЗОВАТЕЛЕЙ БЕЗ СОГЛАСИЙ
// право доступа
require_once 'cronkey.php';
include_once 'config.php';

// ПАКЕТНЫЙ КРОН
// получение пользователей без согласий
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

function iteratorArr(array $adminsData, string $func): array
{
  $result = [];
  foreach ($adminsData as $key => $value) {
    $result[] = $func($key, $value);
  }
  return $result;
}

// добавление недостающих согласий из сессий или таблицы админов при наличии сессии и отсутствии 9900
function addAgreementByNameOrSession($key, array $value): bool
{
  $key = db_real_escape_string($key);
  $memberKey = db_real_escape_string($value['m_key']);
  $name = db_real_escape_string($value['name']);
  $session = db_real_escape_string($value['session']);
  $timeCreate = db_real_escape_string($value['time_create']);

  if (!$timeCreate) {
    $timeCreate = ' NOW() ';
  } else {
    $timeCreate = "'{$timeCreate}'";
  }

  return db_query("INSERT INTO `agreement` (`member_key`, `fio`, `session_id`, `type`, `agree`, `date_agreement`, `comment`) VALUES ('{$memberKey}', '{$name}', '{$session}', 'personal data', 1, {$timeCreate}, 'Создано автоматически на основании данных администратора и существующей сессии.')");

}
// добавление согласий для бывших 9900
function addAgreementForNineNine($key, $value): bool
{
  $key = db_real_escape_string($key);
  $session = db_real_escape_string($value);

  return db_query("UPDATE `agreement` SET `member_key` = '{$value}' WHERE `id` = '{$key}'");
}
// получить согласия для 9900
function getAgreementsForNineNine(): array
{
  $result = [];
  $res = db_query("SELECT ag.id, ad.member_key AS ad_key
    FROM agreement ag
    LEFT JOIN member m ON ag.fio=m.name
    LEFT JOIN (SELECT * FROM admin ad_temp WHERE ad_temp.created > DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL - 7 DAY)) ad ON ad.member_key=m.key
    WHERE ag.member_key LIKE '9900%' AND ad.member_key IS NOT NULL");
  while ($row = $res->fetch_assoc()) $result[$row['id']] = $row['ad_key'];

  return $result;
}

// отслеживать 9900 по именам с аккаунтами создаными не более 7 дней назад
$arrNineNine = getAgreementsForNineNine();
if (count($arrNineNine) > 0) {
  echo "Всего согласий 9900**** с новыми ключами " . count($arrNineNine) . " записей<br>";
  $idsUpdate = iteratorArr($arrNineNine, 'addAgreementForNineNine');
  echo "Обновлено " . count($idsUpdate) . " записей согласий <br>";
} else {
  echo 'Не обновлены. ';
}

// добавление недостающих согласий из сессий или таблицы админов
$arrMissingAgreements = getAdminsKyesWithoutAgreement();
if (count($arrMissingAgreements) > 0) {
  echo "Всего " . count($arrMissingAgreements) . " записей админов без согласий<br>";
  $idsAdded = iteratorArr($arrMissingAgreements, 'addAgreementByNameOrSession');
  echo "Добавлено " . count($idsAdded) . " записей согласий <br>";
} else {
  echo 'Не добалены. ';
}
