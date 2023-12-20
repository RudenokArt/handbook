<?php

// Добавить запись в timeline
\Bitrix\Main\Loader::includeModule('crm');
$resId = \Bitrix\Crm\Timeline\CommentEntry::create([
  'TEXT' => 'test2',
  'SETTINGS' => [],
  'AUTHOR_ID' => 1,
  'BINDINGS' => array(array('ENTITY_TYPE_ID' => CCrmOwnerType::Deal, 'ENTITY_ID' => $deal_id))
]);

// получить дела (из timline)
$data = CCrmActivity::getList([], ['ID' => $id])->Fetch();

// Получить комментарии из Timeline:
$comments = Bitrix\Crm\Timeline\Entity\TimelineTable::getList(array(
  'order' => array("ID" => "DESC"),
  'select'=>array("ID", "COMMENT", "TYPE_ID", "AUTHOR_ID", "BINDINGS"),
  'filter' => [
    'TYPE_ID' => 7,
    'CRM_TIMELINE_ENTITY_TIMELINE_BINDINGS_ENTITY_ID' => $deal['ID'],
  ],
))->fetchAll();


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

