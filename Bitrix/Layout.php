<?php
// ===== Получение текущую папку в URL =====
echo $this->getFolder();

// путь к папке шаблона
echo SITE_TEMPLATE_PATH; 

// подключить пролог и эпилог
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");


// footer & header 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

// Вставить компонент
$APPLICATION->IncludeComponent('exxagate:messenger', '', []);

// Текущая страница
$APPLICATION->GetCurDir();
// Получить меню
$APPLICATION->GetMenu('top', false, false, '/');

// jQuery
\CJSCore::Init(array("jquery"));
// bootstrap
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

// jQuery + bootstrap
\CJSCore::Init(['jquery', 'ui.bootstrap4']);
// font-awesome
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
?>

<style>
  button:active, button:focus {
    outline: none !important;
  }
</style>

<!-- CALENDAR - DATEPICKER -->
<?php CJSCore::Init(array('date')); ?>
<div class="ui-ctl ui-ctl-after-icon">
  <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
  <input type="text" name="INPUTNAME" onclick="BX.calendar({node: this, field: this, bTime: false});" class="ui-ctl-element ui-ctl-textbox">
</div>


<!-- СЕЛЕКТОР КОМПАНИЙ  -->
<?php $APPLICATION->IncludeComponent(
  'bitrix:main.user.selector',
  '',
  [
    "ID" => "mail_client_config_queue",
    "API_VERSION" => 3,
    "INPUT_NAME" => "company",
    "USE_SYMBOLIC_ID" => true,
    "BUTTON_SELECT_CAPTION" => 'push',
    "SELECTOR_OPTIONS" => 
    [
      'enableAll' => 'N',
      'userSearchArea' => 'I',
      'multiple' => 'N',
      'enableSonetgroups' => 'N',
      'enableUsers' => 'N',
      'enableAll' => 'N',
      'enableDepartments' => 'N',
      'enableCrm' => 'Y',
      'enableCrmCompanies' => 'Y',
    ]
  ]
); ?>

