<?php 

// ========== CRM DEALS ==========

// Контакты
\Bitrix\Crm\ContactTable::getList();

// Статусы сделок
Bitrix\Crm\StatusTable::getList();
// Категории сделок
Bitrix\Crm\Category\DealCategory::getAll(true);

// Все сделки по контакту: 
\Bitrix\Crm\Binding\DealContactTable::getContactDealIDs($contact_id);

// Телефоны и email контактов
Bitrix\Crm\FieldMultiTable::getList();

// Адреса контактов
\Bitrix\Crm\AddressTable::getList();

// Получить типы сделок: 
CCrmStatus::GetStatusListEx('DEAL_TYPE');

// получить дела (из timline)
$data = CCrmActivity::getList([], ['ID' => $id])->Fetch();

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
// пользовательские поля сделок 
Bitrix\Main\UserFieldTable::getList(['filter' => ['ENTITY_ID' => 'CRM_DEAL']])->fetchAll();

function getDealFieldsArr () { // все поля сделок с именами
  foreach (CCrmDeal::getFieldsInfo() as $id => $field) {
    $fields[] = [
      'FIELD_NAME' => $id,
      'MAIN_USER_FIELD_LANG_EDIT_FORM_LABEL' => CCrmDeal::getFieldCaption($id)
    ];
  }
  $uFields = Bitrix\Main\UserFieldTable::getList([
    'select' => ['FIELD_NAME', 'LANG.EDIT_FORM_LABEL'],
    'filter' => ['ENTITY_ID' => 'CRM_DEAL', 'LANG.LANGUAGE_ID' => LANGUAGE_ID],
    'runtime' => [
      'LANG' => [
        'data_type' => Bitrix\Main\UserFieldLangTable::getEntity(),
        'reference' => ['this.ID' => 'ref.USER_FIELD_ID']
      ]
    ]
  ])->fetchAll();
  return [$fields, $uFields];
}

// ========== CRM INVOICE ==========

// получить инвойс по id (#5);
use Bitrix\Main\Loader;
use Bitrix\Crm\Service;
Loader::includeModule('crm');
$typeid = '31';
$factory = Service\Container::getInstance()->getFactory($typeid);
$sourceItemId = 5;
$item = $factory->getItem($sourceItemId);
print_r($item->getData());

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


// ===== TIME LINE ====

// Добавить запись в timeline
\Bitrix\Main\Loader::includeModule('crm');
$resId = \Bitrix\Crm\Timeline\CommentEntry::create([
  'TEXT' => 'test2',
  'SETTINGS' => [],
  'AUTHOR_ID' => 1,
  'BINDINGS' => array(array('ENTITY_TYPE_ID' => CCrmOwnerType::Deal, 'ENTITY_ID' => $deal_id))
]);


// ПЕРЕЗАПИСЬ ПОЛЕЙ ДОКУМЕНТА В МОМЕНТ ГЕНЕРАЦИИ
\Bitrix\Main\EventManager::getInstance()->addEventHandler('documentgenerator', 'onBeforeProcessDocument', 'onBeforeProcessDocument');
function onBeforeProcessDocument($event) {
  $document = $event->getParameter('document');
  lib\Debugger::singleLog_txt(json_encode(get_class_methods($document)));
  $document->setValues(['sig' => '${sig}']);
  /** @var \Bitrix\DocumentGenerator\Document $document */
    // добавить дополнительные описания полей
    // $document->setFields($newFields);
    // добавить значения полей
    //$document->setValues(['someField' => 'myCustomValue']);
    // получить список полей и их текущих значений
    //$fields = $document->getFields();
}


?>