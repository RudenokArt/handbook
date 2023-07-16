<?php 

// ========== ORM ==========

// ===== JOIN ======

$messages = Bitrix\Im\Model\MessageTable::getList([
  'filter' => [
    'CHAT_ID' => $_REQUEST['chatId'],
    '!=AUTHOR_ID' => 0,
  ],
  'select' => ['ID', 'CHAT_ID', 'DATE_CREATE', 'MESSAGE', 'AUTHOR_ID', 'USER.PERSONAL_PHOTO'],
  'order' => ['ID' => 'ASC'],
  'runtime' => [
    'USER' => [
      'data_type' => Bitrix\Main\UserTable::getEntity(),
      'reference' => ['this.AUTHOR_ID' => 'ref.ID'],
    ],
  ],
])->fetchAll();

// ===== DOUBLE JOIN + MODIFIER =====

if (isset($_REQUEST['getChatMessages'])) {
  $messages_src = Bitrix\Im\Model\MessageTable::getList([
    'filter' => [
      'CHAT_ID' => $_REQUEST['chatId'],
      '!=AUTHOR_ID' => 0,
    ],
    'select' => ['ID', 'CHAT_ID', 'DATE_CREATE', 'MESSAGE', 'AUTHOR_ID', 'USER.PERSONAL_PHOTO', 'FILE.FILE_NAME', 'FILE.SUBDIR'],
    'order' => ['ID' => 'ASC'],
    'runtime' => [
      'USER' => [
        'data_type' => Bitrix\Main\UserTable::getEntity(),
        'reference' => ['this.AUTHOR_ID' => 'ref.ID'],
      ],
      'FILE' => [
        'data_type' => Bitrix\Main\FileTable::getEntity(),
        'reference' => ['this.IM_MODEL_MESSAGE_USER_PERSONAL_PHOTO' => 'ref.ID'],
      ],
    ],
  ]);
  $messages_src->addFetchDataModifier(function (&$data) {
    $bbTextParser = new CTextParser();
    $data['DATE'] = ConvertDateTime($data['DATE_CREATE'], 'YYYY-MM-DD HH:MI:SS');
    $data['MESSAGE'] = $bbTextParser->convertText($data['MESSAGE']);
  });
  $messages = $messages_src->fetchAll();

// ===== Insert - add() =====

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