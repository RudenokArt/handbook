
Произвольный контент в Toolbar
<?php $this->SetViewTarget("pagetitle", 100);?>
<?php echo 'pagetitle  ' ?>
<?php $this->EndViewTarget(); ?>

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
// crm contacts
[
	'id' => 'CONTACT_NAME',
	'name' => getMessage('CONTACT_NAME'),
	'type' => 'entity_selector',
	'params' => [
		'multiple' => 'Y',
		'dialogOptions' => [
			'entities' => [
				[
					'id' => 'contact',
					'dynamicLoad' => true,
					'dynamicSearch' => true
				]
			]
		]
	]
], 

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
		'enableCrmDeals' => 'Y',
		'crmPrefixType' => 'SHORT',
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
	// получить все гриды на странице
	var gridList = BX.Main.gridManager.data;
	// получить грид по ID
	var productGrid = BX.Main.gridManager.getInstanceById('CCrmEntityProductListComponent');

	// перезагрузить грид
	var gridObject = BX.Main.gridManager.getById('tinkoff_operations_list');
	var gridCurrentPage = document.querySelector('.main-ui-pagination-active').textContent;
	var gridRowsCount = gridObject.instance.getRows().getBodyChild().length;
	var del = false;
	if (del &&gridRowsCount <= 1 && gridCurrentPage > 1) { // отлистать страницу назад, если последняя строка
		gridCurrentPage = gridCurrentPage - 1;
	}
	if (gridObject.hasOwnProperty('instance')){ // сохранить текущую страницу при перезагрузке
		gridObject.instance.reloadTable('POST', {}, null, BX.Grid.Utils.addUrlParams(gridObject.instance.baseUrl, {
			[gridObject.instance.getId()]: `page-${gridCurrentPage}` 
		}));
	}
	
	// Получить строки грида
	gridObject.instance.getRows();
	// Получить выбранные строки грида
	gridObject.instance.getRows().getSelectedIds();

	// Получить и перезапустить грид из слайдера не зная его ID
	var grids = top.BX.Main.gridManager.data;
	var gridObject = grids[0];
	if (gridObject.hasOwnProperty('instance')){
		gridObject.instance.reloadTable('POST', {apply_filter: 'N', clear_nav: 'N'});
	}

	// перезагрузить родительский грид из слайдера
	var gridObject = top.BX.Main.gridManager.getById('tinkoff_operations_list');
	if (gridObject.hasOwnProperty('instance')){
		gridObject.instance.reloadTable('POST', {apply_filter: 'N', clear_nav: 'N'});
	}

	// Перезагрузить грид после закрытия слайдера
	// Полный список событий слайдера здесь: https://dev.1c-bitrix.ru/api_help/js_lib/sidepanel/events/events.php
	BX.addCustomEvent("SidePanel.Slider:onCloseComplete", function(event) {
		var gridObject = BX.Main.gridManager.getById('sievert_deals_grid');
		if (gridObject.hasOwnProperty('instance')){
			gridObject.instance.reloadTable('POST', {apply_filter: 'N', clear_nav: 'N'});
		}
	});


	// Перезагрузка грида в табе карточки сущности 

	var grid = BX.Main.gridManager.getInstanceById('itachsoft_loyalitysystem_member_list');
	grid.reload(BX.Grid.Utils.addUrlParams('/local/components/itachsoft/loyalitysystem.member_list/lazyload.ajax.php', {
		[grid.getId()]: 'page-${page}'
	}))

</script>

