<?php

// Добавить дело в timeline

$params = [
  'PROVIDER_ID' => 'CRM_TODO',
  'PROVIDER_TYPE_ID' => 'TODO',
  'TYPE_ID' => 6,
  'BINDINGS' => [
    ['OWNER_ID' => $_POST['OWNER_ID'], 'OWNER_TYPE_ID' => CCrmOwnerType::Deal]
  ],
  'SUBJECT' => $_POST['SUBJECT'],
  'COMPLETED' => 'N',
  'DESCRIPTION' => $_POST['DESCRIPTION'],
  'RESPONSIBLE_ID' => $_POST['RESPONSIBLE_ID'],
  'DIRECTION' => CCrmActivityDirection::Outgoing,
  'START_TIME' => new \Bitrix\Main\Type\DateTime($_POST['START_TIME'], 'd.m.Y'),
];
$response = CCrmActivity::Add($params, false, false);
print_r($params);

// получить дела (из timline)
$data = CCrmActivity::getList([], ['ID' => $id])->Fetch();

// Добавить комментарий в timeline
\Bitrix\Main\Loader::includeModule('crm');
$resId = \Bitrix\Crm\Timeline\CommentEntry::create([
  'TEXT' => 'test2',
  'SETTINGS' => [],
  'AUTHOR_ID' => 1,
  'BINDINGS' => array(array('ENTITY_TYPE_ID' => CCrmOwnerType::Deal, 'ENTITY_ID' => $deal_id))
]);



// Получить комментарии из Timeline:
$comments = Bitrix\Crm\Timeline\Entity\TimelineTable::getList(array(
  'order' => array("ID" => "DESC"),
  'select'=>array("ID", "COMMENT", "TYPE_ID", "AUTHOR_ID", "BINDINGS"),
  'filter' => [
    'TYPE_ID' => 7,
    'CRM_TIMELINE_ENTITY_TIMELINE_BINDINGS_ENTITY_ID' => $deal['ID'],
  ],
))->fetchAll();

// Получить комментарии из Timeline вместе с файлами
$src = Bitrix\Crm\Timeline\Entity\TimelineTable::getList([
  'filter' => [
    'TYPE_ID' => Bitrix\Crm\Timeline\TimelineType::COMMENT,
    'AUTHOR_ID' => $_REQUEST['userId'],
    'BINDINGS.ENTITY_TYPE_ID' => CCrmOwnerType::Deal,
    'BINDINGS.ENTITY_ID' => $deal['ID']
  ]
]);
$src->addFetchDataModifier(function(&$data) {
  $data['FILES'] = Bitrix\Crm\Timeline\CommentController::getFiles($data['UALIAS_0'], $data['UALIAS_2'], $data['UALIAS_1']);
});
$comments = $src->fetchAll();


// ДОБАВЛЕНИЕ КОММЕНТАРИЯ В TIMELINE С ПРИЛОЖЕНИЕМ ФАЙЛА
// 1. добавляем файл в диск
$arFiles = [CFile::makeFileArray($file_id)]; // $file_id - b_file
if ($storage = Bitrix\Disk\Driver::getInstance()->getStorageByUserId($_REQUEST['userId'])) {
  $folder = $storage->getFolderForUploadedFiles();
  foreach ($arFiles as $arFile) {
    if ($file = $folder->uploadFile($arFile, ['CREATED_BY' => $_REQUEST['userId'],], [], true)) {
      $files[] = 'n' . $file->getId();
      $filesArr[] = $file->getId();
    }
  }
  // 2. Добавить непосредственно комментарий
  $commentId = Bitrix\Crm\Timeline\CommentEntry::create([
   'TEXT' => $_REQUEST['TEXT'],
   'AUTHOR_ID' => $_REQUEST['userId'],
   'SETTINGS' => [
     'HAS_FILES' => 'Y'
   ],
   'FILES' => $files,
   'BINDINGS' => [
     [
       'ENTITY_ID' => $_REQUEST['projectDealId'],
       'ENTITY_TYPE_ID' => CCrmOwnerType::Deal,
     ],
   ]
 ]);
  echo $commentId;
}

