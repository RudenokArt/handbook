<?php 

// Заполнить поле типа "Файл"
add(["UF_UPLOAD_FILE" => \CFile::MakeFileArray($FileID)]);

// Добавить пользовательское поле тип CRM с проверкой уникальности
$field = CUserTypeEntity::GetList([], [
  'ENTITY_ID' => 'CRM_DEAL',
  'FIELD_NAME' => 'UF_LEASING_PERIOD',
])->Fetch();
if (!$field) {
  $oUserTypeEntity = new CUserTypeEntity();
  $aUserFields_bind = array(
    'ENTITY_ID' => 'CRM_DEAL',
    'FIELD_NAME' => 'UF_LEASING_PERIOD',
    'USER_TYPE_ID' => 'crm',
    'MULTIPLE'=> 'N',
    'SHOW_FILTER' => 'I',
    'SETTINGS' => ['CONTACT' => 'Y'],
    'EDIT_FORM_LABEL' => array(
      'ru' => 'Период лизинга',
      'en' => 'Leasing period',
      'de' => 'Leasingdauer',
    ),
    'LIST_COLUMN_LABEL' => array(
      'ru' => 'Период лизинга',
      'en' => 'Leasing period',
      'de' => 'Leasingdauer',
    ),
  );
  $oUserTypeEntity->Add($aUserFields_bind);
}

// Добавить пользовательское поле тип CRM
  $oUserTypeEntity = new CUserTypeEntity();
  $aUserFields_bind = array(
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
  $oUserTypeEntity->Add( $aUserFields_bind );

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

// Найти и удалить поле
  $field = CUserTypeEntity::GetList([], [
   'ENTITY_ID' => 'CRM_DEAL',
   'FIELD_NAME' => 'UF_LEASING_PERIOD',
 ])->Fetch();
  $delete = (new CUserTypeEntity())->Delete($field['ID']);

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



// ==== КАСТОМНОЕ ПОЛЕ (CUSTOM FIELD) ===============================
// в инсталяторе:
  \Bitrix\Main\EventManager::getInstance()->registerEventHandlerCompatible(
    'main', 'onUserTypeBuildList',
    $this->MODULE_ID,
    'Bitrix\Sievert\ObjectContactListField',
    'getUserTypeDescription'
  );
// include.php
  use Bitrix\Main\Loader;
  Loader::registerAutoLoadClasses(
    'sievert.migrations', [
      'Bitrix\Sievert\ObjectContactListField' => 'lib/ObjectContactListField.php',
    ]
  );
// В классе lib/ObjectContactListField.php:
  namespace Bitrix\Sievert;
  class ObjectContactListField extends \Bitrix\Main\UserField\Types\BaseType {
    public const  USER_TYPE_ID = 'ObjectContactListField';
    public const RENDER_COMPONENT = 'sievert:object_contact_list_field';
    public static function getDescription(): array {
      return [
        'DESCRIPTION' => 'ObjectContactListField',
        'BASE_TYPE' => \CUserTypeManager::BASE_TYPE_STRING
      ];

    }
    public static function getDbColumnType(): string {
      return 'text';
    }
  }
// в классе компонента object_contact_list_field
  class ObjectContactListFieldUfComponent extends Bitrix\Main\Component\BaseUfComponent {
    protected static function getUserTypeId(): string {
      return Bitrix\Sievert\ObjectContactListField::USER_TYPE_ID;
    }
    protected function prepareResult(): void {
      if ($this->additionalParameters['mode'] == 'main.view' or $this->additionalParameters == 'main.edit') {
        $this->additionalParameters['mode'] = '.default';
      } else {
        $this->additionalParameters['mode'] = 'empty';
      }
    }
  }
// В шаблоне компонента object_contact_list_field
?><input
value="<?php echo $arResult['userField']['VALUE']; ?>"
name="<?php echo $arResult['userField']['FIELD_NAME']?>"
id="contactListFieldInput"
type="text"><?php 
// ==============================================================