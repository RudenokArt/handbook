<?php

// ?bitrix_include_areas=Y

// custom debugger;
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log.json', json_encode($list));

// Подключить модуль
\Bitrix\Main\Loader::includeModule('crm');

// Автозагрузка классов в init.php
Bitrix\Main\Loader::registerAutoLoadClasses(null, [
  'Classes\Infoblock' => '/local/php_interface/classes/infoblock.php'
]);

// получить путь к компоненту в шаблоне компонента
$this->getComponent()->getPath();

// получить путь к компоненту в классе компонента
$this->getPath();

// Установка и получение пользовательских опция (модуль, название, значение)
CUserOptions::SetOption('sn', 'checkin_checkout', $limit);
CUserOptions::GetOption('sn', 'checkin_checkout');

// получить список стран
print_r(GetCountryArray(LANGUAGE_ID));

// ===== Конвертировать BB коды в html ======
$bbTextParser = new CTextParser();
$messages[$key]['MESSAGE'] = $bbTextParser->convertText($value['MESSAGE']);

// ===== Получение файла по id =====
$file=CFile::GetFileArray($id)['SRC'];

// ===== Получить ссылку на файл ===== 
CBitrixComponent::includeComponentClass('bitrix:main.file.input'); 
$fileId = 358; 
$mfiController = new MFIController; 
$mfiController->generateCid($fileId)->registerFile($fileId); 
echo '<a href="' . $mfiController->getUrlDownload($fileId) . '" target="_blank">Click me!</a>';

// ===== Принять файл с формы, сохранить и записать в таблицу b_file;
$file_id = CFile::SaveFile(
  array_merge($_FILES['contact_photo'], ['del' => 'N', 'MODULE_ID' => 'main', ]),
  'tmp'
);

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
 "CONDITION" => "#^/news/([A-z-0-9]+)/?#",
 "RULE" => "SECTION_ID=$1",
 "PATH" => "/news/index.php",
], ];

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