<?php 

// ========== DATE & TIME ==========

function date_filter () {
  $dateFrom = new \Bitrix\Main\Type\DateTime();
  $dateFrom->add('-10 day');
  $dateTo = new \Bitrix\Main\Type\DateTime();
  $filter = [
    ">=CLOSED_DATE" => $dateFrom,
    "<=CLOSED_DATE" => $dateTo,
    'RESPONSIBLE_ID' => $value['ID'],
  ];
  $src = CTasks::GetList([],$filter, []);
}

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