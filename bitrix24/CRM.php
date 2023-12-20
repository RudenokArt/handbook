<?php 


// Смарт процессы
Bitrix\Crm\Model\Dynamic\TypeTable::getList();

// Подключить модуль
\Bitrix\Main\Loader::includeModule('crm');

// ========== CRM DEALS ==========

// Контакты
\Bitrix\Crm\ContactTable::getList();

// Таблица связи инвойсов и контактов:
// b_crm_entity_contact


// Статусы сделок
Bitrix\Crm\StatusTable::getList();

// Категории сделок
Bitrix\Crm\Category\DealCategory::getAll(true);

// Все сделки по контакту: 
\Bitrix\Crm\Binding\DealContactTable::getContactDealIDs($contact_id);

// Связь сделок и контактов
\Bitrix\Crm\Binding\DealContactTable::getList();

// Телефоны и email контактов
\Bitrix\Crm\FieldMultiTable::getList();

// Адреса контактов
\Bitrix\Crm\AddressTable::getList();

// Получить типы сделок: 
CCrmStatus::GetStatusListEx('DEAL_TYPE');

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

// ========== СМАРТ ПРОЦЕССЫ ==========
// получить фабрику (хз что это) по id типа смартпроцесса
$factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory($typeid);
// получить список элементов
$src = $factory->getItems([
  'select' => [],
  'filter' => [],
]);

// ========== CRM INVOICE ==========

// Таблица с новыми инвойсами:
// b_crm_dynamic_items_31

// Таблица связи инвойсов и контактов:
// b_crm_entity_contact

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

// ===== ТОРГОВЫЙ КАТАЛОГ (TRADE CATALOG) =====

CCrmProductRow::GetList(); // Получить товары по сделке/лиду
CCatalogSKU::getOffersList($arr); // получить торговые предложения

