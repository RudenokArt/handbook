<?php

// ===== B24 REST ====
// https://bitrix.vetliva.by/rest/1/1hfn9tdkh923zrq6/im.message.add.json?DIALOG_ID=27427&MESSAGE=Hello%2C%20world!
// https://bitrix.vetliva.by/rest/1/1hfn9tdkh923zrq6/tasks.task.add.json?fields[TITLE]=test%2C%20task&fields[RESPONSIBLE_ID]=27427

function rest_request () { // Простой запрос через webhook
  $web_hook = 'https://b24-k6lwae.bitrix24.by/rest/1/6fac44vzeyp9xcin/'; 
  $api_method = 'crm.lead.get?'; 
  $api_query = http_build_query([
    'filter' => ['ID' => 62959],
    'select' => ['*', 'UF_*'],
  ]); 
  $json = file_get_contents($web_hook.$api_method.$api_query); 
  $arr = json_decode( $json, $assoc_array = true ); 
}
?>

<!-- // Javascript (JS) запрос через webhook -->
<script>
  $(function () {
    var webHook = '<?php echo $booking_mod_request::WEB_HOOK;?>';
    $('#booking_mod_request').submit(async function (e) {
      e.preventDefault();
      var queryString = new URLSearchParams();
      queryString.set('fields[ASSIGNED_BY_ID]', 27427);
      queryString.set('fields[TITLE]', 'Заявка на тур: ');
      var request = webHook + 'crm.lead.add.json?' + queryString.toString();
      console.log(request);
      var result = await $.get(request);
      console.log(result);
    });
  });
</script>

<script src="//api.bitrix24.com/api/v1/"></script> подключить BX24
<script>
$(function(){ // создать пользовательское поле
  BX24.callMethod('userfieldtype.add', {
    USER_TYPE_ID: 'test',
    HANDLER: 'https://b24.phpdev.org/test/b24uf.php',
    TITLE: 'Test type',
    DESCRIPTION: 'Test userfield type for documentation'
  });

  $('#slider-show').click(function () { 
        BX24.openApplication({ // Открыть серверное приложение в слайдере
          'opened': true,
        },
        function() {
          console.log('Application closed!');
        });
      });

  $('#slider-show').click(function () {
        BX24.init( // Открыть страницу в слайдере
          function() {
            BX24.openPath(
              '/crm/deal/details/5/',
              function(result) {
                console.log(result);
              });
          });
      });

});
</script>


<?php

// ===== СОЗДАНИЕ И УДАЛЕНИЕ ВЕБХУКА 

function installWebHook () {
  Bitrix\Rest\APAuth\PermissionTable::add([
    'PASSWORD_ID' => Bitrix\Rest\APAuth\PasswordTable::Add([
      'USER_ID' => 1,
      'PASSWORD' => randString(32),
      'TITLE' => 'itachsoft.loyalitysystemintegration',
      'COMMENT' => 'itachsoft.loyalitysystemintegration',
      'DATE_CREATE' => new Bitrix\Main\Type\DateTime,
      'ACTIVE' => 'Y'
    ])->getID(),
    'PERM' => 'itachsoft.loyalitysystemintegration'
  ]);
}

function unInstallWebHook () {
  $APAuth = Bitrix\Rest\APAuth\PermissionTable::getRow([
    'select' => ['ID', 'PASSWORD_ID'],
    'filter' => ['PERM' => 'itachsoft.loyalitysystemintegration'],
  ]);
  Bitrix\Rest\APAuth\PermissionTable::delete($APAuth['ID']);
  Bitrix\Rest\APAuth\PasswordTable::delete($APAuth['PASSWORD_ID']);

  $integration = Bitrix\Rest\Preset\IntegrationTable::getRow([
    'select' => ['ID'],
    'filter' => ['PASSWORD_ID' => $APAuth['PASSWORD_ID']]
  ]);
  Bitrix\Rest\Preset\IntegrationTable::delete($integration['ID']);
}

// ПОЛУЧИТЬ WEBHOOK
$APAuth = Bitrix\Rest\APAuth\PermissionTable::getRow([
      'select' => ['ID', 'PASSWORD_ID'],
      'filter' => ['PERM' => 'itachsoft.loyalitysystemintegration'],
    ]);
$webHookPassword = \Bitrix\Rest\APAuth\PasswordTable::getRow([
      'select' => ['ID', 'USER_ID', 'PASSWORD'],
      'filter' => [
        'ID' => $APAuth['PASSWORD_ID'],
      ],
    ]);