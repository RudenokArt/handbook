<?php

// ========== urlRewrite ==========

[1 => [ 
 "CONDITION" => "#^/news/([A-z-0-9]+)#",
 "RULE" => "SECTION_ID=$1",
 "PATH" => "/news/index.php",
], ];

// ========== USER ==========

function getUserList () {
  $page = 1;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  $filter = ['ACTIVE' => 'Y'];
  $select = [
    'NAV_PARAMS' => ['nPageSize'=>10, 'iNumPage'=>$page],
    'FIELDS' => ['ID', 'NAME', 'LAST_NAME',],
    'SELECT' => [],
  ];
  $src = CUser::GetList('ID','asc', $filter, $select);
  $arr = make_list($src);
  return [
    'page_count' => $src->NavPageCount, 
    'page_nuber' => $src->NavPageNomer, 
    'list' => $arr,
  ];
}


// ========== INFOBLOCKS ==========

function getIBlockUFProperties () { // получить пользовательские поля инфоблока
  $src = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>20]);
  return list_maker($src);
}

 // ========== HELPERS ==========

function logg () {
  $str = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/test_agent.html');
  $str = time().' time: '.date('Y:m:d:H:i:s').'<br>'.$str;
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test_agent.html', $str);
}

function fetch_list_maker ($src) {
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

function deleteAgent () { // удалить агента
  CAgent::RemoveAgent('CodeReview::setTask();');
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

// ===== B24 REST ====

function rest_request () { // Простой запрос через webhook
  $web_hook = 'https://b24-k6lwae.bitrix24.by/rest/1/6fac44vzeyp9xcin/'; 
  $api_method = 'crm.lead.get?'; 
  $api_query = http_build_query([
    'ID' => 1,
  ]); 
  $json = file_get_contents($web_hook.$api_method.$api_query); 
  $arr = json_decode( $json, $assoc_array = true ); 
}




?>