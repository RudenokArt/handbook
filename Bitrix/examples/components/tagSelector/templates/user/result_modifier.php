<?php
\Bitrix\Main\UI\Extension::load('ui.entity-selector');
$filter = [];
if ($arParams['FILTER']) {
  $filter = $arParams['FILTER'];
}
$usersList = \Bitrix\Main\UserTable::getList([
  'filter' => $filter,
  'select' => [
    'ID',
    'NAME',
    'LAST_NAME',
    'SECOND_NAME',
    'LOGIN',
    'EMAIL',
  ],
])->fetchAll();

foreach ($usersList as $key => $value) {
  $arResult['usersList'][] = [
    'id' => $value['ID'],
    'entityId' => 'users',
    'tabs' => 'users',
    'title' => $value['NAME'].' '.$value['LAST_NAME'].' '.$value['SECOND_NAME'],
    'subtitle' => $value['LOGIN'].' (ID: '.$value['ID'].')',
  ];
}

$arResult['id'] = '_'.rand(100, 1000);