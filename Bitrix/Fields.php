<?php 

// Заполнить поле типа "Файл"
add(["UF_UPLOAD_FILE" => \CFile::MakeFileArray($FileID)]);

// Добавить пользовательское поле тип CRM
$oUserTypeEntity = new CUserTypeEntity();
$aUserFields_log = array(
  'ENTITY_ID' => 'CRM_DEAL',
  'FIELD_NAME' => 'UF_AGENT_REFERAL',
  'USER_TYPE_ID' => 'crm',
  'MULTIPLE'=> 'N',
  'SETTINGS' => ['CONTACT' => 'Y'],
  'EDIT_FORM_LABEL' => array(
    'ru' => 'Агент (реферал)',
    'en' => 'Agent (referal)',
    'de' => 'Agent (referal)',
  ),
  'LIST_COLUMN_LABEL' => array(
    'ru' => 'Агент (реферал)',
    'en' => 'Agent (referal)',
    'de' => 'Agent (referal)',
  ),
);
$oUserTypeEntity->Add( $aUserFields_log );

// Добавить пользовательское поле
$field_id = (new CUserTypeEntity())->Add([
 'ENTITY_ID' => 'CRM_DEAL',
 'FIELD_NAME' => 'UF_CRM_DEAL_AWARD',
 'USER_TYPE_ID' => 'string',
]);

// Получить пользовательские поля по фильтру
$field = CUserTypeEntity::GetList([], [
 'ENTITY_ID' => 'CRM_DEAL',
 'FIELD_NAME' => 'UF_CRM_DEAL_AWARD',
]);
// или в D7:
Bitrix\Main\UserFieldTable::getList([
  'filter' => ['ENTITY_ID' => 'CRM_DEAL']
])->fetchAll();

// получить значение пользовательского поля типа "список"
$rsEnum = CUserFieldEnum::GetList([], ['ID' => $field_id]);
$arEnum = $rsEnum->Fetch();
$row['award_type'] = $arEnum['VALUE'];

// удалить кастомное поле по ID
$delete = (new CUserTypeEntity())->Delete($field_id);

// получить имя пользовательского поля по UF_*
$prop = \Bitrix\Main\UserFieldTable::getList([
  'filter' => ['FIELD_NAME' => 'UF_CRM_1682406244497'],
])->fetch();
$prop = CUserTypeEntity::GetByID($prop['ID']);


// Получить стандартные поля по сделке
CCrmDeal::GetFieldsInfo();
// или так:
CCrmOwnerType::getFieldsInfo(
  CCrmOwnerType::Deal
);
// пользовательские поля сделок 
Bitrix\Main\UserFieldTable::getList(['filter' => ['ENTITY_ID' => 'CRM_DEAL']])->fetchAll();

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