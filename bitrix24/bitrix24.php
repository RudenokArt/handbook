<?php 

// Копировать родительскую задачу:
// ?PARENT_ID=26516&COPY=26516&TEMPLATE=Y


// отключить авторизацию на странице
define('NOT_CHECK_PERMISSIONS', true);
// доступ к скрипту для пользователей extranet
define("EXTRANET_NO_REDIRECT", true);

// Получить статусы задач
CTaskItem::getStatusMap();

// Запустить бизнесспроцесс для сделки кодом:
$fields = [
  'STAGE_ID' => 'C1:UC_556F1H',
];
$update = \Bitrix\Crm\DealTable::update($dealId, $fields);
$workflows = Bitrix\Bizproc\Workflow\Template\Entity\WorkflowTemplateTable::getList([
  'select' => ['ID'],
  'filter' => ['=DOCUMENT_STATUS' => $fields['STAGE_ID']]
]);
while ($workflow = $workflows->fetch()) {
  CBPDocument::startWorkflow($workflow['ID'], ['crm', 'CCrmDocumentDeal', 'DEAL_' . $dealId], [], $errors);
}


// получить id документа в actitivity бизнесс процесса
$deal_id = $this->GetDocumentId();

// получить ID инфоблока "Торговый каталог"
$iblock_id = Bitrix\Main\Config\Option::get('crm', 'default_product_catalog_id');

// Вызов Rest методов на php
// для CRM
CCrmRestService::onRestServiceMethod([], false, new CRestServer(['METHOD' => 'crm.deal.fields']));

// для остальных
class BitrixRest {
  public function checkAuth($query) {
    if ($query['initiator'] === self::class) return true;
  }
  public static function call($method, $params) {
    addEventHandler('rest', 'onRestCheckAuth', ['BitrixRest', 'checkAuth']);
    return (new CRestServer(['CLASS' => 'CRestProvider', 'METHOD' => $method, 'QUERY' => array_merge($params, ['initiator' => self::class])]))->process()['result'];
  }
}
print_r(
 BitrixRest::call('crm.contact.get', ['id' => 187])
);


// подключить библиотеку рабоыты со слайдером (в слайдере например)
CJSCore::Init(['sidepanel']);
?>


<script>
// Принять пулл 
  BX.ready(function(){
    BX.addCustomEvent("onPullEvent", function(module_id, command, params) {
      console.log(module_id, command, params);
    });
    BX.PULL.extendWatch('PULL_TEST');
  });

// Открыть слайдер
  BX.SidePanel.Instance.open('add_faq_form.php?update='+item_id, {
    allowChangeHistory: false,
  });
  
  BX.SidePanel.Instance.reload(); // Перезагрузить слайдер
</script>