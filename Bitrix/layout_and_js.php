
<!-- BITRIX VUE -->
<?php \Bitrix\Main\UI\Extension::load("ui.vue"); ?>
<?php define('VUEJS_DEBUG', true); ?>
<script>
  BX.Vue.create({
    el: '#roof_step4_vue_app',
  });
</script>

<?php 
// url шаблона сайта
SITE_TEMPLATE_PATH;
// ========== JS LIBRARY ==========

function js_library () { // js библиотека
  CJSCore::RegisterExt('Panel_visability_js', array(
    'js' => '/local/gadgets/custom/panel_visability/main.js',
  ));
  CUtil::InitJSCore(array('Panel_visability_js'));
}


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


<script> // преопределить битриксовый прелодер
BX.ready(function(){
  BX.showWait = function() {
    console.log('start');
  };
  BX.closeWait = function() {
    console.log('finish');
  };
});
</script>