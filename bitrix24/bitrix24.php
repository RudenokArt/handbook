<?php 


// отключить авторизацию на странице
define('NOT_CHECK_PERMISSIONS', true);


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

?>

<script>
  // Открыть слайдер
  BX.SidePanel.Instance.open('add_faq_form.php?update='+item_id, {
    allowChangeHistory: false,
  });
  
</script>