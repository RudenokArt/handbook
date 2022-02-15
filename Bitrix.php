<?php 



// ========== INFOBLOCKS ==========

function getIBlockUFProperties () { // получить пользовательские поля инфоблока
  $src = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>20]);
  return list_maker($src);
}

 // ========== HELPERS ==========

function list_maker($src) {
  $arr = [];
  while ($item = $src->Fetch()) {
    array_push($arr, $item);
  }
  return $arr;
}

// ========== JS LIBRARY ==========

function js_library () { // js библиотека
  CJSCore::RegisterExt('Panel_visability_js', array(
    'js' => '/local/gadgets/custom/panel_visability/main.js',
  ));
  CUtil::InitJSCore(array('Panel_visability_js'));
}

// ========== AGETNS ==========

function agentCreate () { // Создать агента
  CAgent::AddAgent(
    "WorkReport::reportLogging();", // имя функции
    "", // идентификатор модуля
    "N", // агент не критичен к кол-ву запусков
    60, // интервал запуска - 1 сутки
    "03.02.2022 16:30:00", // дата первой проверки на запуск
    "Y", // агент активен
    "03.02.2022 16:30:00", // дата первого запуска
    "");
}

// ========== CRM LEADS ==========

function get_leads_sourses () {  // получить источники лидов
  CCrmStatus::GetStatusList('SOURCE');
}

function getSourceList () { // получить источники лидов через rest
  $str = file_get_contents('https://crm.maunfeld.by/rest/10/shdvcx5dj3zd289m/crm.status.entity.items.json?entityId=SOURCE');
  $arr = json_decode($str,true);
  $list = [];
  foreach ($arr['result'] as $key => $value) {
    array_push($list, [
      'SOURCE_ID' => $value['NAME'], 
      'SOURCE' => $value['STATUS_ID']
    ]);
  }
  return $list;
}

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