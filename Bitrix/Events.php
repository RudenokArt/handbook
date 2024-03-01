<?php

// Регистрация обработчика события
\Bitrix\Main\Loader::includeModule('crm');
AddEventHandler('crm', 'OnAfterCrmDealUpdate', 'LocalEventHandler::OnAfterCrmDealUpdate');
class LocalEventHandler {
  function OnAfterCrmDealUpdate ($arr) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/log.json', json_encode($arr));
  } 
}
// Регистрация обработчика события
AddEventHandler('main', 'OnBeforeEventSend', function  ($arr=false) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log.json', json_encode($arr));
});

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

// Регистрация обработчика события при установке модуля D7
// Получение объекта события
\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
  'documentgenerator',
  'onBeforeProcessDocument',
  $this->MODULE_ID,
  '\\Docbrown\\Documentgeneratorhandler\\EventManager',
  'documentEdit'
);
// namespace Docbrown\Documentgeneratorhandler;
class EventManager {
  static function documentEdit (\Bitrix\Main\Event $event) { 
    file_put_contents(
      $_SERVER['DOCUMENT_ROOT'].'/local/log.json',
      json_encode([
        'docbrown.documentgeneratorhandler',
        get_class_methods($document)
      ])
    );
  }
}

// Регистрация обработчика события при установке модуля D7
// Получение старых аргументов
\Bitrix\Main\EventManager::getInstance()->registerEventHandlerCompatible(
  'documentgenerator',
  'onBeforeProcessDocument',
  $this->MODULE_ID,
  '\\Docbrown\\Documentgeneratorhandler\\EventManager',
  'documentEdit'
);
// namespace Docbrown\Documentgeneratorhandler;
class EventManager {
  static function documentEdit (\Bitrix\DocumentGenerator\Document $document) {
    file_put_contents(
      $_SERVER['DOCUMENT_ROOT'].'/local/log.json',
      json_encode([
        'docbrown.documentgeneratorhandler',
        get_class_methods($document)
      ])
    );
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
    $parameters = $event->getParameters(); // все параметры (если надо)
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
