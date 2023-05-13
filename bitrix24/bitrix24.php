<?php 


// отключить авторизацию на странице
define('NOT_CHECK_PERMISSIONS', true);

// МОДУЛЬ DOCUMENTGENERATOR
\Bitrix\Main\Loader::includeModule('documentgenerator');
// классы для таблицы b_documentgenerator_template
print_r(get_class_methods('Bitrix\DocumentGenerator\Model\TemplateTable'));
print_r(get_class_methods('Bitrix\DocumentGenerator\Template'));
// Класс для работы с таблицей b_documentgenerator_file
Bitrix\DocumentGenerator\Model\FileTable();
// Класс для работы с таблицей b_documentgenerator_document
Bitrix\DocumentGenerator\Model\DocumentTable();
// Получить элемент из таблицы b_file по полю FILE_ID таблицы b_documentgenerator_template
Bitrix\DocumentGenerator\Model\FileTable::getBFileId($file_id);

// получить id документа в actitivity бизнесс процесса
$deal_id = $this->GetDocumentId();

// получить ID инфоблока "Торговый каталог"
$iblock_id = Bitrix\Main\Config\Option::get('crm', 'default_product_catalog_id');

// Вызов Rest методов на php
// для CRM
CCrmRestService::onRestServiceMethod([], false, new CRestServer(['METHOD' => 'crm.deal.fields']));

// для остальных
class BitrixRest {
  public function checkAuth($query) {
    if ($query['initiator'] === self::class) return true;
  }
  public static function call($method, $params) {
    addEventHandler('rest', 'onRestCheckAuth', ['BitrixRest', 'checkAuth']);
    return (new CRestServer(['CLASS' => 'CRestProvider', 'METHOD' => $method, 'QUERY' => array_merge($params, ['initiator' => self::class])]))->process()['result'];
  }
}
print_r(
 BitrixRest::call('crm.contact.get', ['id' => 187])
);