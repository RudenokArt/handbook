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

?>


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