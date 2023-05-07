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

?>