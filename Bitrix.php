<?php

// ===== Получение файла по id =====

$file=CFile::GetFileArray($id)['SRC'];

// ===== Загрузка файла на сервер ======
echo CFile::InputFile("IMAGE_ID", 20, $str_IMAGE_ID); // отрисовать поле для загрузки
$arr_file=Array( // загрузить файл 
  "name" => $_FILES[IMAGE_ID][name],
  "size" => $_FILES[IMAGE_ID][size],
  "tmp_name" => $_FILES[IMAGE_ID][tmp_name],
  "type" => "",
  "old_file" => "",
  "del" => "Y",
  "MODULE_ID" => "main");
$fid = CFile::SaveFile($arr_file, "main");
$fields['PERSONAL_PHOTO'] = $_FILES[IMAGE_ID];// записать в свойства сущности

// ========== Иммитация сессии ==========
// запись данных
$localStorage = \Bitrix\Main\Application::getInstance()->getLocalSession('main_event');
$localStorage->set('main_event','test-data');
// получение данных
$localStorage = \Bitrix\Main\Application::getInstance()->getLocalSession('main_event');
print_r($localStorage->get('main_event'));

// ========== urlRewrite ==========

[1 => [ 
 "CONDITION" => "#^/news/([A-z-0-9]+)#",
 "RULE" => "SECTION_ID=$1",
 "PATH" => "/news/index.php",
], ];

// Вставить компонент
$APPLICATION->IncludeComponent(
  "vetliva:advertisement_popup",
  "",
  Array()
);

// путь к папке шаблона
echo SITE_TEMPLATE_PATH; 
// подключить пролог
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// footer & header 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

// font-awesome
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
// bootstrap
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

// Автозагрузка классов
Bitrix\Main\Loader::registerAutoLoadClasses(null, [
  'Classes\Infoblock' => '/local/php_interface/classes/infoblock.php'
]);

// получить путь к компоненту в шаблоне компонента
$this->getComponent()->getPath();

// получить путь к компоненту в классе компонента
$this->getPath();

// получить список стран
print_r(GetCountryArray(LANGUAGE_ID));

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
    'page_number' => $src->NavPageNomer, 
    'list' => $arr,
  ];
}

// id текущего пользователя
global $USER;
return $USER->GetID();


// проверка на принадлежность пользователя к группе exchange_rates:
in_array(CGroup::GetList(($by="id"), ($order="asc"),['STRING_ID'=>'exchange_rates'])->Fetch()['ID'], $USER->GetUserGroupArray());

// добавить пользователя в группу
$arGroups = CUser::GetUserGroup($user_id);
$arGroups[] = $group_id;
CUser::SetUserGroup($user_id, $arGroups);

// ========== HIGHLOADBLOCKS ==========

// получить highload-блок по фильтру
$hl = \Bitrix\Highloadblock\HighloadBlockTable::getList([
  'filter'=>['TABLE_NAME' => 'ts_prices',],
]);
$highloadblock=$hl->Fetch();

// получить элементы highload блока
$items = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highloadblock);
$entity_data_class = $items->getDataClass();
$rsData = $entity_data_class::getList(['filter'=>[]]);
$arr = [];
foreach ($rsData as $key => $value) {
  array_push($arr, $value);
}

// добавить элемент в highload блок
$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($highloadblock); 
$entity_data_class = $entity->getDataClass();
$arr_data = self::postData();
$data = [
  'UF_AUTHOR' => $arr_data['author'],
  'UF_RECIPIENT' => $arr_data['recipient'],
  'UF_MESSAGE' => $arr_data['message'],
];
$result = $entity_data_class::add($data);
if ($result->isSuccess()) {
  echo 'успешно добавлен';
} else {
  echo 'Ошибка: ' . implode(', ', $result->getErrors()) . "";
}

// Перехват события highload-блока
$highLoadEventManager = \Bitrix\Main\EventManager::getInstance();
$highLoadEventManager->addEventHandler('', 'BookingsOnAfterAdd', function (\Bitrix\Main\Entity\Event $event) {
  $id = $event->getParameter("id");
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test.html', 'id-'.$id);
});

// ========== INFOBLOCKS ==========

// Сложный фильтр 

function getSerarchFilter () {
  if (isset($_GET['search']) and !empty($_GET['search'])) {
    $filter = [
      'IBLOCK_CODE' => 'tours',
      'SECTION_CODE' => $this->section_code,
      [
        "LOGIC" => "OR",
        ["NAME" => '%'.$_GET['search'].'%'],
        ["DETAIL_TEXT" => '%'.$_GET['search'].'%'],
        ["PREVIEW_TEXT" => '%'.$_GET['search'].'%'],
      ]
    ];
  } else {
    $filter = [
      'IBLOCK_CODE' => 'tours',
      'SECTION_CODE' => $this->section_code,
    ];
  }
  return $filter;
}

// сортировка по двум признакам
Array(
 "LOGIC" => "AND",
 array("ID" => "DESC"),
 array("DATE_ACTIVE_FROM" => "ASC"));

function getIBlockUFProperties () { // получить пользовательские поля инфоблока
  $src = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>20]);
  return list_maker($src);
};

// Простая пагинация для инфоблока
$pagination = [
  'page_count' => $src->NavPageCount, 
  'page_number' => $src->NavPageNomer,
]; 
if ($arResult['pagination']['page_number']>1): ?>
  <a href="?page_number=1">1</a>...
<?php endif ?>
<?php if ($arResult['pagination']['page_number']>2): ?>
  <a href="?page_number=<?php echo $arResult['pagination']['page_number']-1;?>">
    <?php echo$arResult['pagination']['page_number']-1;?>
  </a>
<?php endif ?>
<?php echo $arResult['pagination']['page_number'];?>
<?php if ($arResult['pagination']['page_number']<$arResult['pagination']['page_count']): ?>
 <a href="?page_number=<?php echo $arResult['pagination']['page_number']+1;?>">
  <?php echo $arResult['pagination']['page_number']+1;?>
</a> 
<?php endif ?>
...
<a href="?page_number=<?php echo $arResult['pagination']['page_count'];?>">
  <?php echo $arResult['pagination']['page_count'];?>
</a>
<?php

$GLOBALS['bottom_menu_filter'] = [// фильтр для компонента (news.list)
'SECTION_CODE' => 'bottom_menu',
]; 
$GLOBALS['main_event_filter'] = [ // Фильтр по свойству
'ACTIVE'=>'Y', 
'PROPERTY_main_event_VALUE'=>'Y'
];

// ========== SQL ==========

function getBookingPrices () {
  global $DB;
  $dbRes = $DB->Query('SELECT * FROM `ts_rates_category` WHERE ID = 10');
  $arr = [];
  while ($row = $dbRes->Fetch()) {
    array_push($arr, $row);
  }
  return $arr;
}

 // ========== HELPERS ==========

function logg () {
  $str = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/test_agent.html');
  $str = time().' time: '.date('Y:m:d:H:i:s').'<br>'.$str;
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test_agent.html', $str);
}

function getList_fetch ($src) {
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


?>


<script> // преопределить битриксовый прелодер
BX.ready(function(){
  BX.showWait = function() {
    console.log('start');
  };
  BX.closeWait = function() {
    console.log('finish');
  };
});
</script>