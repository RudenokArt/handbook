<?php

// Регистрация обработчика события
\Bitrix\Main\Loader::includeModule('crm');
AddEventHandler('crm', 'OnAfterCrmDealUpdate', 'LocalEventHandler::OnAfterCrmDealUpdate');
class LocalEventHandler {
  function OnAfterCrmDealUpdate ($arr) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test/log.json', json_encode($arr));
  } 
}
// Регистрация обработчика события с ананимной функцией
AddEventHandler('main', 'OnBeforeEventSend', function  ($arr=false) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log.json', json_encode($arr));
});

// Регистрация обработчика события при установке модуля
registerModuleDependences('documentgenerator', 'onBeforeProcessDocument', $this->MODULE_ID, 'DocumentGeneratorHandler', 'customizeDocument');
class DocumentGeneratorHandler {
  public static function customizeDocument($document)
  { 
    $document->setValues(['signature' => '${signature}']);
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

// ТАБЛИЧНЫЕ ДАННЫЕ ПРИ ГЕНЕРАЦИИ ДОКУМЕНТА 
// ($arr - ассоциативный массив [поле => значение])
$object = 'table';
    $options = [
      'ITEM_NAME' => 'table',
      'ITEM_PROVIDER' => \Bitrix\DocumentGenerator\DataProvider\HashDataProvider::class,
    ];
    $resultValues[$object] = new \Bitrix\DocumentGenerator\DataProvider\ArrayDataProvider($arr, $options);
    foreach ($arr as $key => $value) {
      foreach ($value as $key1 => $value1) {
        $resultValues[$key1] =  'table.table.'.$key1;
      }
    }
    $resultFields[$object] = [
      'PROVIDER' => \Bitrix\DocumentGenerator\DataProvider\ArrayDataProvider::class,
      'OPTIONS' => $options,
      'VALUE' => $arr,
    ];
    $resultFields['image'] = ['TYPE' => \Bitrix\DocumentGenerator\DataProvider::FIELD_TYPE_IMAGE];
    $document->setFields($resultFields);
    $document->setValues($resultValues);


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
