<?php 

// получить id документа в actitivity бизнесс процесса
 $this->deal_id = $this->GetDocumentId();

// получить ID инфоблока "Торговый каталог"
$iblock_id = Bitrix\Main\Config\Option::get('crm', 'default_product_catalog_id');

// ========== CRM DEALS ==========

// получить сделки по фильтру
$src = CCrmDeal::GetList([], [
  'ID' => $deal_id,
], []);
if($row = $src->Fetch()){
// code
}   

// ПОЛУЧИТЬ ТОВАРЫ ПО СДЕЛКЕ
// $entity_type - Тип сущности ('D' - сделкa, 'L' - лид) 
// $entity_id - ID сущности
// $products - массив товаров
$products = CAllCrmProductRow::LoadRows($entity_type, $entity_id);

// ПОЛУЧИТЬ ТОВАРЫ ПО СДЕЛКЕ С КОЛИЧЕСТВОМ И СТОИМОСТЬЮ
$products = CCrmDeal::LoadProductRows($entity_type, $entity_id);

$prod = CCrmProductRow::GetList([], [
  'OWNER_ID' => $deal_id,
  'OWNER_TYPE' => 'D', // DEAL OR L-LEAD
])->Fetch();

$products = \Bitrix\Crm\ProductRowTable::getList([
  'select' => ['PRICE', 'QUANTITY'],
  'filter' => [
    'OWNER_ID' => $deal_id,
    'OWNER_TYPE' => 'D', // DEAL OR L-LEAD
  ]
])->fetchAll();

// ========== CRM LEADS ==========

function get_leads_sourses () {  // получить источники лидов
  CCrmStatus::GetStatusList('SOURCE');
}

function getSourceList () { // получить источники лидов через rest
  $str = file_get_contents('https://crm.maunfeld.by/rest/10/shdvcx5dj3zd289m/crm.status.entity.items.json?entityId=SOURCE');
  $arr = json_decode($str,true);
  $list = [];
  foreach ($arr['result'] as $key => $value) {
    array_push($list, [
      'SOURCE_ID' => $value['NAME'], 
      'SOURCE' => $value['STATUS_ID']
    ]);
  }
  return $list;
}

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

<script> // Javascript (JS) запрос через webhook
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

  <?php // селект для сделок, лидов и т.п.
  CModule::IncludeModule('crm');
  $fieldIdentifier='COMPANY_ID';
  $GLOBALS["APPLICATION"]->IncludeComponent('bitrix:crm.entity.selector',
    '',
    array(
      'ENTITY_TYPE' => ['COMPANY','LEAD'],
      'INPUT_NAME' => $fieldIdentifier,
      'INPUT_VALUE' => 'company',
      'FORM_NAME' => "",
      'MULTIPLE' => 'N',
      'FILTER'=>'Y',
    ),
    false,
    array('HIDE_ICONS' => 'Y')
    ); ?>