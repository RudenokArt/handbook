<?php

// users
$arResult['FILTER'][] = 
[
	'id' => 'USER', 
	'name' => getMessage('AWARD_USERS_USER'),
	'default' => true,
	'type' => 'dest_selector',
	'params' => [
		'multiple' => 'Y',
		'enableDepartments' => 'N',
		'userSearchArea' => 'I'
	]
];

// CRM deals
$arResult['FILTER'][] = [
	'id' => 'deal',
	'name' => getMessage('DEAL'),
	'type' => 'entity_selector',
	'params' => [
		'multiple' => 'Y',
       // 'addEntityIdToResult' => 'N',
		'dialogOptions' => [
			// 'dropdownMode' => true,
			// 'enableSearch' => true,
			'items' => $this->dealsSelect,
			// 'tabs' => [
			// 	[ 'id' => 'deal-tab', 'title' => '',],
			// ],
			// 'showAvatars' => false,
		]
	],
	// 'type' => 'list',
	// 'items' => $this->dealsSelect,
];

$arResult['FILTER'][] = [
	'id' => 'deal2',
	'name' => getMessage('DEAL'),
	'type' => 'dest_selector',
	'params' => [
		'multiple' => 'Y',
		'enableSonetgroups' => 'N',
		'enableUsers' => 'N',
		'enableAll' => 'N',
		'enableDepartments' => 'N',
		'enableCrm' => 'Y',
		'enableCrmDeals' => 'Y'
	]
];

$arResult['FILTER'][] = [
	'id' => 'deal3',
	'name' => getMessage('DEAL'),
	'type' => 'entity_selector',
	'default' => true,
	'params' => [
		'multiple' => 'Y',
		'dialogOptions' => [
			'entities' => [
				[
					'id' => 'deal',
					'dynamicLoad' => true,
					'dynamicSearch' => true
				]
			]
		]
	]
];


Toolbar::addFilter([
	'GRID_ID' => $arResult['GRID_ID'],
	'FILTER_ID' => $arResult['GRID_ID'],
	'FILTER' => $arResult['FILTER'],
	'ENABLE_LIVE_SEARCH' => true,
	'ENABLE_LABEL' => true,
	'DISABLE_SEARCH' => $USER->isAdmin() ? false : true
]);



?>

<script>
	// перезагрузить грид
	var gridObject = BX.Main.gridManager.getById('tinkoff_operations_list');
	var gridCurrentPage = document.querySelector('.main-ui-pagination-active').textContent;
	if (gridObject.hasOwnProperty('instance')){ // сохранить текущую страницу при перезагрузке
		gridObject.instance.reloadTable('POST', {}, null, BX.Grid.Utils.addUrlParams(gridObject.instance.baseUrl, {
			[gridObject.instance.getId()]: `page-${gridCurrentPage}` 
		}));
	}
	
	// Получить выбранные строки грида
	gridObject.instance.getRows().getSelectedIds();

	// 

	// перезагрузить родительский грид из слайдера
	var gridObject = top.BX.Main.gridManager.getById('tinkoff_operations_list');
	if (gridObject.hasOwnProperty('instance')){
		gridObject.instance.reloadTable('POST', {apply_filter: 'N', clear_nav: 'N'});
	}
</script>

