<?php 

// ========== ORM ==========

// Insert - add();
$result = Bitrix\Live\SignatureTable::add([
  'FELI_ID' => $file_id,
  'DOCUMENT_ID' => $deal_id,
  'PASSWORD' => $password,
]);
echo $result->getErrorMessages();

// ========== SQL ==========

function getBookingPrices () {
  global $DB;
  $dbRes = $DB->Query('SELECT * FROM `ts_rates_category` WHERE ID = 10');
  $arr = [];
  while ($row = $dbRes->Fetch()) {
    array_push($arr, $row);
  }
  return $arr;
}

/**
 * 
 */
class ClassName extends DataManager
{

  // Валидация средствами SQL
  public static function validatedAdd(array $arFields) {
    try {
      return parent::add($arFields)->getId();
    } catch (\Bitrix\Main\DB\SqlQueryException $e) {
      return $e->getMessage();
    }
  }
}

?>