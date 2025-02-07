<?php


$arResult['gridID'] = 'sn_worktime_users_list'; // идентификатор грида

$grid_options = new Bitrix\Main\Grid\Options($arResult['gridID']);
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$nav_params = $grid_options->GetNavParams();

$arResult['nav'] = new Bitrix\Main\UI\PageNavigation($arResult['gridID']);
$arResult['nav']->allowAllRecords(true)
->setPageSize($nav_params['nPageSize'])
->initFromUri();

$page = $arResult['nav']->getCurrentPage();
$limit = $arResult['nav']->getPageSize();
$offset = $arResult['nav']->getOffset();
$order = $grid_options->getSorting();
$filter = [];
$filterOption = new Bitrix\Main\UI\Filter\Options($arResult['gridID']);
$filterData = $filterOption->getFilter([]);
foreach ($filterData as $k => $v) {
	$filter[$k] = $v;            
}

// ForDebugOnly
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log.json', json_encode([
'page' => $page,
'limit' => $limit,
'offset' => $offset,
'order' => $order,
'filter' => $filter,
]));

$arResult['columns'] = [ // Колонки грида
	[
		'id' => 'ID',
		'name' => 'ID',
		'default' => true,
		'sort' => 'ID',
	],
	[
		'id' => 'EMPLOYEE',
		'name' => getMessage('EMPLOYEE'),
		'default' => true,
		'sort' => 'NAME',
	],
];

$arResult['rows'] = [ // Строки грида
	[
		'data' => [
			'ID' => 1, 'EMPLOYEE' => 'Ivanov'. $page,
		],
	],
	[
		'data' => [
			'ID' => 2, 'EMPLOYEE' => 'Petrow',
		],
	],
	[
		'data' => [
			'ID' => 3, 'EMPLOYEE' => 'Sidorov',
		],
	],
];

$arResult['nav']->setRecordCount(5); // $src->getCount() - элементов на всех страницах всего.

\Bitrix\UI\Toolbar\Facade\Toolbar::addFilter([
	'FILTER_ID' => $arResult['gridID'], 
	'GRID_ID' => $arResult['gridID'], 
	'FILTER' => [ 
		['id' => 'USER', 'name' => getMessage('EMPLOYEE'), 'type' => 'string'], 
	], 
	'ENABLE_LIVE_SEARCH' => true, 
	'ENABLE_LABEL' => true 
]);