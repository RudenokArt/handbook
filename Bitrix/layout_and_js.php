<!-- BITRIX VUE 3 -->
<?php \Bitrix\Main\UI\Extension::load("ui.vue3"); ?>

<!-- BITRIX VUE -->
<?php \Bitrix\Main\UI\Extension::load("ui.vue"); ?>
<?php define('VUEJS_DEBUG', true); ?>
<script>
  BX.Vue.create({
    el: '#roof_step4_vue_app',
  });
</script>

<!-- CALENDAR - DATEPICKER -->
<?php CJSCore::Init(array('date')); ?>
<div class="ui-ctl ui-ctl-after-icon">
  <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
  <input type="text" name="INPUTNAME" onclick="BX.calendar({node: this, field: this, bTime: false});" class="ui-ctl-element ui-ctl-textbox">
</div>



<script>
// Вывести все события в косоль:
  var originalBxOnCustomEvent = BX.onCustomEvent;
  BX.onCustomEvent = function (eventObject, eventName, eventParams, secureParams)
  {
    // onMenuItemHover например выбрасывает в другом порядке
    var realEventName = BX.type.isString(eventName) ?
    eventName : BX.type.isString(eventObject) ? eventObject : null;

    if (realEventName) {
      console.log(
        '%c' + realEventName, 
        'background: #222; color: #bada55; font-weight: bold; padding: 3px 4px;'
        );
    }
    console.dir({
      eventObject: eventObject,
      eventParams: eventParams,
      secureParams: secureParams
    });
    originalBxOnCustomEvent.apply(
      null, arguments
      );
  };
</script>

<?php 
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