<?php 

// ========== DATE & TIME ==========


// Первый и последний день месяца:
$arr['date']['date_to'] = date('Y-m-d', mktime(0, 0, 0, $arr['date']['month'], 1, $arr['date']['year']));
$arr['date']['date_from'] = date('Y-m-t', mktime(0, 0, 0, $arr['date']['month'], 1, $arr['date']['year']));

// Фильтр D7 с ... по ...
$arr = \Bitrix\Sn\PlanTable::getList([
  'filter' => [
    '>=BEGIN_DATE' => $period['beginDate']->toString(),
    '<=CLOSE_DATE' => $period['closeDate']->toString(),
  ],
])->fetchAll();

// Фильтр из GET параметров
if (isset($_GET['filter']['>=DATE_CREATE'])) {
  $_GET['filter']['>=DATE_CREATE'] = new \Bitrix\Main\Type\DateTime($_GET['filter']['>=DATE_CREATE'], 'Y-m-d');
}
if (isset($_GET['filter']['<=DATE_CREATE'])) {
  $_GET['filter']['<=DATE_CREATE'] = new \Bitrix\Main\Type\DateTime($_GET['filter']['<=DATE_CREATE'], 'Y-m-d');
}
// Фильтр из GET параметров + 1 День
if (isset($_GET['date_to']) and $_GET['date_to']) {
  $arResult['tickets_list_filter']['<=DATE_CREATE'] = (new \Bitrix\Main\Type\DateTime($_GET['date_to'], 'Y-m-d'))
  ->add('1D');
}

// Фильтер из timestamp -30 days 
$filter = ['>DATE' => (new \Bitrix\Main\Type\DateTime())->add('-30D'),]

function reportFilterDate () {
  if ($_GET['F_DATE_TYPE']=='month') {
    $interval = [
      ConvertTimeStamp(strtotime(date('Y-m-01'))),
      ConvertTimeStamp(strtotime(date('Y-m-t')))
    ];
  }
  if ($_GET['F_DATE_TYPE']=='month_ago') {
    $interval = [
      ConvertTimeStamp(strtotime(date('Y-m-01', strtotime('-1 month')))), 
      ConvertTimeStamp(strtotime(date('Y-m-t', strtotime('-1 month'))))
    ];
  }
  if ($_GET['F_DATE_TYPE']=='week') {
    $interval = [
      ConvertTimeStamp(strtotime('last monday')),
      ConvertTimeStamp(strtotime('next monday'))
    ];
  }
  if ($_GET['F_DATE_TYPE']=='week_ago') {
    $interval = [
      ConvertTimeStamp(strtotime('last monday -1 week')), 
      ConvertTimeStamp(strtotime('next monday -1 week'))
    ];
  }
  if ($_GET['F_DATE_TYPE']=='days') {
    $interval = [
      ConvertTimeStamp(strtotime($_GET['F_DATE_DAYS'].' days')), 
      ConvertTimeStamp(strtotime('tooday'))
    ];
  }
  if ($_GET['F_DATE_TYPE']=='after') {
    $interval = [
      $_GET['F_DATE_TO'], 
      ConvertTimeStamp(strtotime('tooday'))
    ];
  }
  if ($_GET['F_DATE_TYPE']=='before') {
    $interval = [
      ConvertTimeStamp(strtotime(date('Y-m-01'))),
      $_GET['F_DATE_FROM'],
    ];
  }
  if ($_GET['F_DATE_TYPE']=='interval') {
    $interval = [
      $_GET['F_DATE_FROM'],
      $_GET['F_DATE_TO'],
    ];
  }
  if ($_GET['F_DATE_TYPE']=='all') {
    $interval = [
      '01.01.2000',
      ConvertTimeStamp(strtotime('tooday')),
    ];
  }
  return $interval;
}

?>