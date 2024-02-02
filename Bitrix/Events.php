<?php

// Регистрация обработчика события
\Bitrix\Main\Loader::includeModule('crm');
AddEventHandler('crm', 'OnAfterCrmDealUpdate', 'LocalEventHandler::OnAfterCrmDealUpdate');
class LocalEventHandler {
  function OnAfterCrmDealUpdate ($arr) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/log.json', json_encode($arr));
  } 
}

// Регистрация обработчика события при установке модуля
registerModuleDependences('documentgenerator', 'onBeforeProcessDocument', $this->MODULE_ID, 'DocumentGeneratorHandler', 'customizeDocument');
class DocumentGeneratorHandler {
  public static function customizeDocument($event)
  { 
    $event->setValues(['signature' => '${signature}']);
    // // // добавить дополнительные описания полей
    // // // $document->setFields($newFields);
    // // // добавить значения полей
    // $document->setValues(['signature' => '${signature}']);
    // // // получить список полей и их текущих значений
    // // //$fields = $document->getFields();
  }
}
// Добавление вкладки в crm сущность (сделку) 
// можно из модуля!
Bitrix\Main\EventManager::getInstance()->addEventHandler(
  'crm',
  'onEntityDetailsTabsInitialized', 
  static function(\Bitrix\Main\Event $event) {
    $entityId = $event->getParameter('entityID');
    $typeId = $event->getParameter('entityTypeID');
    $tabs = $event->getParameter('tabs');
    $tabs[] = [
      'id' => 'crm_products_calc',
      'name' => 'Products(calc)',
      'loader' => [
        'serviceUrl' => '/local/components/docbrown/crm_products_calc/lazyload.ajax.php', // путь к компоненту
        'componentData' => [ // arParams компонента
          'dealId' => $entityId 
        ]
      ]
    ];
    return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
      'tabs' => $tabs,
    ]);
  }
);
