<?php 

// ========== HIGHLOADBLOCKS ==========

// подключить модуль highload
Bitrix\Main\Loader::includeModule('highloadblock');

// Создание highload блока с кастомными полями.
function hlBlockInstall () {

  $hlCheck = \Bitrix\Highloadblock\HighloadBlockTable::getList([
    'filter'=> [
      'TABLE_NAME' => 'b_happe_timetable_holidays',
    ],
  ])->Fetch();
  if ($hlCheck) {
    return;
  }

  $hlCreate = \Bitrix\Highloadblock\HighloadBlockTable::add(array(
    'NAME' => 'HappeTimetableHolidays',
    'TABLE_NAME' => 'b_happe_timetable_holidays', 
  ));

  $arLangs = Array(
    'ru' => 'Happe - Расписание праздников',
    'en' => 'Happe - holidays timetable',
    'de' => 'Happe - Feiertagsfahrplan',
  );

  if ($hlCreate->isSuccess()) {
    $hlId = $hlCreate->getId();
    foreach($arLangs as $lang_key => $lang_val){
      \Bitrix\Highloadblock\HighloadBlockLangTable::add(array(
        'ID' => $hlId,
        'LID' => $lang_key,
        'NAME' => $lang_val
      ));
    }
  } else {
    $errors = $hlCreate->getErrorMessages();
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log.json', json_encode($errors)); 
  }

  $arFields = Array(
    "ENTITY_ID" => "HLBLOCK_".$hlId,
    'FIELD_NAME' => 'UF_HAPPE_TIMETABLE_HOLIDAY_TITLE',
    'USER_TYPE_ID' => 'string',
    'MULTIPLE'=> 'N',
    'EDIT_FORM_LABEL' => array(
      'ru' => 'Название',
      'en' => 'Title',
      'de' => 'Titel',
    ),
    'LIST_COLUMN_LABEL' => array(
      'ru' => 'Название',
      'en' => 'Title',
      'de' => 'Titel',
    ),
  );
  $obUserField  = new CUserTypeEntity;
  $obUserField->Add($arFields);

  $arFields = Array(
    "ENTITY_ID" => "HLBLOCK_".$hlId,
    'FIELD_NAME' => 'UF_HAPPE_TIMETABLE_HOLIDAY_DATE',
    'USER_TYPE_ID' => 'date',
    'MULTIPLE'=> 'N',
    'EDIT_FORM_LABEL' => array(
      'ru' => 'Дата',
      'en' => 'Date',
      'de' => 'Datum',
    ),
    'LIST_COLUMN_LABEL' => array(
      'ru' => 'Дата',
      'en' => 'Date',
      'de' => 'Datum',
    ),
  );
  $obUserField  = new CUserTypeEntity;
  $obUserField->Add($arFields);
}



// Удалить highload по символьному коду
$hl = \Bitrix\Highloadblock\HighloadBlockTable::getList([
  'filter'=>['TABLE_NAME' => 'tasks_premium',],
])->Fetch()['ID'];
if ($hl) {
  \Bitrix\Highloadblock\HighloadBlockTable::delete($hl);
}

// получить highload-блок по фильтру
$hl = \Bitrix\Highloadblock\HighloadBlockTable::getList([
  'filter'=>['TABLE_NAME' => 'ts_prices',],
])->Fetch();

// получить элементы highload блока
$items = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hl);
$entity_data_class = $items->getDataClass();
$rsData = $entity_data_class::getList(['filter'=>[]]);
$arr = [];
foreach ($rsData as $key => $value) {
  $arr[] = $value;
}

// добавить элемент в highload блок
$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hl); 
$entity_data_class = $entity->getDataClass();
$result = $entity_data_class::add([
  'UF_USER_ID' => $deal['ASSIGNED_BY_ID'],
  'UF_DEAL_ID' => $deal['ID'],
  'UF_AWARD_AMOUNT' => $deal['AWARD_AMOUNT'],
]);
if ($result->isSuccess()) {
  echo 'успешно добавлен';
} else {
  echo 'Ошибка: ' . implode(', ', $result->getErrors()) . "";
}

// Удалить элемент highload блока
$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hl);
$entity_data_class = $entity->getDataClass();
$entity_data_class::delete($item_id);

// Перехват события highload-блока
$highLoadEventManager = \Bitrix\Main\EventManager::getInstance();
$highLoadEventManager->addEventHandler('', 'BookingsOnAfterAdd', function (\Bitrix\Main\Entity\Event $event) {
  $id = $event->getParameter("id");
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test.html', 'id-'.$id);
});


?>