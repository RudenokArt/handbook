<!-- BITRIX VUE 3 -->
<?php \Bitrix\Main\UI\Extension::load("ui.vue"); ?>
<div id="app">{{ message }}</div>
<script>
  BX.Vue.createApp({
    data () {
      return {
        message: 'hello',
      };
    }
  }).mount('#app');
</script>

<!-- BITRIX VUE -->
<?php \Bitrix\Main\UI\Extension::load("ui.vue"); ?>
<?php define('VUEJS_DEBUG', true); ?>
<script>
  BX.Vue.create({
    el: '#roof_step4_vue_app',
  });
</script>

<script>
  BX.ready(function(){
    //...code
  });
</script>

<!-- Кнопки (уши) горизонтальной прокрутки -->
<?php \Bitrix\Main\UI\Extension::load("ui.ears"); ?>
<script>
  const ears = new  BX.UI.Ears({
    container: document.querySelector('#checkin_checkout-table-container'),
    smallSize: true,
    noScrollbar: true
  });
  ears.init();

</script>

<!-- Виджет TagSelector -->
<?php \Bitrix\Main\UI\Extension::load('ui.entity-selector'); ?>
<script>
  var tagSelector = new BX.UI.EntitySelector.TagSelector({
    dialogOptions: {
      items: [
        { id: 1, entityId: 'false', title: 'User 1', tabs: 'users' },
        { id: 2, entityId: 'false', title: 'User 2', tabs: 'users' },
      ],
      tabs: [
        { id: 'users', title: 'users' }
      ],
      showAvatars: false,
      dropdownMode: true
    }
  });
  tagSelector.renderTo(document.getElementById('container'));
// <!-- Виджет TagSelector для юзеров и отделов -->
  var tagSelector = new BX.UI.EntitySelector.TagSelector({
    dialogOptions: {
      entities: [
        {
          id: 'department',
          options: {
            selectMode: 'usersAndDepartments',
          },
        },
      ],
    }
  });
  tagSelector.renderTo(document.getElementById('container'));

// Битриксовый алерт
  BX.UI.Dialogs.MessageBox.alert('Access denied!');

// Принять пулл 
  BX.ready(function(){
    BX.addCustomEvent("onPullEvent", function(module_id, command, params) {
      console.log(module_id, command, params);
    });
    BX.PULL.extendWatch('PULL_TEST');
  });


  <?php // Отправить push
  CPullStack::AddShared([
    'module_id' => 'crm',
    'command' => '',``
    'params' => [],
  ]);

  ?>


// !!!!!!! подключить библиотеку рабоыты со слайдером (в слайдере например)
// CJSCore::Init(['sidepanel']);
// Открыть слайдер
  BX.SidePanel.Instance.open('add_faq_form.php?update='+item_id, {
    allowChangeHistory: false,
  });
// Перезагрузить слайдер
  BX.SidePanel.Instance.reload(); 
// Закрыть слайдер
  BX.SidePanel.Instance.close();
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
  \CJSCore::RegisterExt('Panel_visability_js', array(
    'js' => '/local/gadgets/custom/panel_visability/main.js',
  ));
  \CUtil::InitJSCore(array('Panel_visability_js'));
}

?>
