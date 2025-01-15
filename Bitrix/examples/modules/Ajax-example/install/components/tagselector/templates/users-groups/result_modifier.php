<?php

$groupsArr = \Bitrix\Main\GroupTable::getList(array(
	'order'  => array('C_SORT'),
	'select'  => array('NAME','ID','STRING_ID','C_SORT'),
))->fetchAll();
foreach ($groupsArr as $key => $value) {
	$grousList[] = [
		'id' => (int)$value['ID'],
		'entityId' => 'group',
		'title' => $value['NAME'],
		'tabs' => 'groups',
	];
}
$arResult['groups'] = json_encode($grousList);