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
CJSCore::Init(array("jquery"));
// bootstrap
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

// jQuery + bootstrap
CJSCore::Init(['jquery', 'ui.bootstrap4']);
// font-awesome
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
?>

<!-- CALENDAR - DATEPICKER -->
<?php CJSCore::Init(array('date')); ?>
<div class="ui-ctl ui-ctl-after-icon">
  <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
  <input type="text" name="INPUTNAME" onclick="BX.calendar({node: this, field: this, bTime: false});" class="ui-ctl-element ui-ctl-textbox">
</div>

<?php 
// BITRIX CAPTHA
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
$cpt = new CCaptcha();
$captchaPass = COption::GetOptionString("main", "captcha_password", "");
if(strlen($captchaPass) <= 0) {
  $captchaPass = randString(10);
  COption::SetOptionString("main", "captcha_password", $captchaPass);
}
$cpt->SetCodeCrypt($captchaPass);
?>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12 mice-event-title">
    * Введите код с картинки
    <input value="<?=htmlspecialchars($cpt->GetCodeCrypt());?>" 
    class="captchaSid" name="captcha_code" type="hidden">
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
    <input class="inptext form-control" required="" id="captcha_word" name="captcha_word" type="text">
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
    <img class="captchaImg" 
    src="/bitrix/tools/captcha.php?captcha_code=<?=htmlspecialchars($cpt->GetCodeCrypt());?>">
  </div>
</div>
<pre><?php print_r($cpt->code);?></pre>