<?php

// ===== Получение текущую папку в URL =====
echo $this->getFolder();

// путь к папке шаблона
echo SITE_TEMPLATE_PATH; 

// подключить пролог и эпилог
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");


// footer & header 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

// jQuery
CJSCore::Init(array("jquery"));

// font-awesome
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
// bootstrap
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

// Автозагрузка классов
Bitrix\Main\Loader::registerAutoLoadClasses(null, [
  'Classes\Infoblock' => '/local/php_interface/classes/infoblock.php'
]);

// получить путь к компоненту в шаблоне компонента
$this->getComponent()->getPath();

// получить путь к компоненту в классе компонента
$this->getPath();

// получить список стран
print_r(GetCountryArray(LANGUAGE_ID));

// Регистрация события при установке модуля
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


// ===== Получение файла по id =====
$file=CFile::GetFileArray($id)['SRC'];

// ===== Загрузка файла на сервер ======
echo CFile::InputFile("IMAGE_ID", 20, $str_IMAGE_ID); // отрисовать поле для загрузки
$arr_file=Array( // загрузить файл 
  "name" => $_FILES[IMAGE_ID][name],
  "size" => $_FILES[IMAGE_ID][size],
  "tmp_name" => $_FILES[IMAGE_ID][tmp_name],
  "type" => "",
  "old_file" => "",
  "del" => "Y",
  "MODULE_ID" => "main");
$fid = CFile::SaveFile($arr_file, "main");
$fields['PERSONAL_PHOTO'] = $_FILES[IMAGE_ID];// записать в свойства сущности

// ========== Иммитация сессии ==========
// запись данных
$localStorage = \Bitrix\Main\Application::getInstance()->getLocalSession('main_event');
$localStorage->set('main_event','test-data');
// получение данных
$localStorage = \Bitrix\Main\Application::getInstance()->getLocalSession('main_event');
print_r($localStorage->get('main_event'));

// ========== urlRewrite ==========
// Для отключения проактивной защиты хостов/доменов в файле:
// bitrix/modules/main/include.php закоментировать:
// foreach (GetModuleEvents("main", "OnPageStart", true) as $arEvent)
//   ExecuteModuleEventEx($arEvent);

[1 => [ 
 "CONDITION" => "#^/news/([A-z-0-9]+)#",
 "RULE" => "SECTION_ID=$1",
 "PATH" => "/news/index.php",
], ];

// Вставить компонент
$APPLICATION->IncludeComponent(
  "vetliva:advertisement_popup",
  "",
  Array()
);

// ========= Отложенный вывод контента или компонента ==============
$APPLICATION->ShowViewContent('rus_bank_approved_order'); // собственно вывод - метка для подстановки ?>
<?php
ob_start(); // старт отложенного вывода 
$APPLICATION->IncludeComponent(
  "vetliva:bank_russia",
  "",
  Array()
);
$rus_bank_approved_order = ob_get_contents(); // сложили все в буфер
ob_end_clean(); // очистили 
$APPLICATION->AddViewContent("rus_bank_approved_order", $rus_bank_approved_order); // объявили метку и указали что в ней выводить
// ======================================================================


// ========== AGETNS ==========
function agentCreate () { // Создать агента
  CAgent::AddAgent(
    "WorkReport::reportLogging();", // имя функции
    "", // идентификатор модуля
    "N", // агент не критичен к кол-ву запусков
    60, // интервал запуска - 1 сутки
    "03.02.2022 16:30:00", // дата первой проверки на запуск
    "Y", // агент активен
    "03.02.2022 16:30:00", // дата первого запуска
    "");
}
function deleteAgent () { // удалить агента
  CAgent::RemoveAgent('CodeReview::setTask();');
}


?>



Перенос на другой домен.
Если сайт редиректит на старый домен...
Для отключения защиты понадобится доступ к сайту по FTP. Откройте файл:
bitrix/modules/main/include.php
Найдите и закомментируйте строки:
foreach (GetModuleEvents("main", "OnPageStart", true) as $arEvent)
ExecuteModuleEventEx($arEvent);