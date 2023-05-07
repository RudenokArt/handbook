<?php 

// ========== CRM DEALS ==========

// получить сделки по фильтру
$src = CCrmDeal::GetList([], [
  'ID' => $deal_id,
], []);
if($row = $src->Fetch()){
// code
}   

// ПОЛУЧИТЬ ТОВАРЫ ПО СДЕЛКЕ
// $entity_type - Тип сущности ('D' - сделкa, 'L' - лид) 
// $entity_id - ID сущности
// $products - массив товаров
$products = CAllCrmProductRow::LoadRows($entity_type, $entity_id);

// ПОЛУЧИТЬ ТОВАРЫ ПО СДЕЛКЕ С КОЛИЧЕСТВОМ И СТОИМОСТЬЮ
$products = CCrmDeal::LoadProductRows($entity_type, $entity_id);

$prod = CCrmProductRow::GetList([], [
  'OWNER_ID' => $deal_id,
  'OWNER_TYPE' => 'D', // DEAL OR L-LEAD
])->Fetch();

$products = \Bitrix\Crm\ProductRowTable::getList([
  'select' => ['PRICE', 'QUANTITY'],
  'filter' => [
    'OWNER_ID' => $deal_id,
    'OWNER_TYPE' => 'D', // DEAL OR L-LEAD
  ]
])->fetchAll();

// Получить стандартные поля по сделке
CCrmDeal::GetFieldsInfo();
// или так:
CCrmOwnerType::getFieldsInfo(
  CCrmOwnerType::Deal
);

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

// ===== TIME LINE ====

// Добавить запись в timeline
\Bitrix\Main\Loader::includeModule('crm');
$resId = \Bitrix\Crm\Timeline\CommentEntry::create([
  'TEXT' => 'test2',
  'SETTINGS' => [],
  'AUTHOR_ID' => 1,
  'BINDINGS' => array(array('ENTITY_TYPE_ID' => CCrmOwnerType::Deal, 'ENTITY_ID' => $deal_id))
]);


// селект для сделок, лидов и т.п.
CModule::IncludeModule('crm');
$fieldIdentifier='COMPANY_ID';
$GLOBALS["APPLICATION"]->IncludeComponent('bitrix:crm.entity.selector',
  '',
  array(
    'ENTITY_TYPE' => ['COMPANY','LEAD'],
    'INPUT_NAME' => $fieldIdentifier,
    'INPUT_VALUE' => 'company',
    'FORM_NAME' => "",
    'MULTIPLE' => 'N',
    'FILTER'=>'Y',
  ),
  false,
  array('HIDE_ICONS' => 'Y')
); 


?>