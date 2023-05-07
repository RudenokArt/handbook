<?php 

// ========== HIGHLOADBLOCKS ==========

// подключить модуль highload
use Bitrix\Main\Loader;
Loader::IncludeModule('highloadblock');

// создать highload
$hl_create = Bitrix\Highloadblock\HighloadBlockTable::add(array(
  'NAME' => 'TasksPremium',
  'TABLE_NAME' => 'tasks_premium', 
));

// создать highload с кастомными полями
$hl_create = Bitrix\Highloadblock\HighloadBlockTable::add(array(
  'NAME' => 'DealAward',
  'TABLE_NAME' => 'deal_award', 
));
$hl_id = $hl_create->getId();
$arFields = Array(
  "ENTITY_ID" => "HLBLOCK_".$hl_id,
  "FIELD_NAME" => "UF_TITLE",
  "USER_TYPE_ID" => "string",
  "EDIT_FORM_LABEL" => Array("ru"=>"заголовок", "en"=>"title")
);
$obUserField  = new CUserTypeEntity;
$obUserField->Add($arFields);

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
  array_push($arr, $value);
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