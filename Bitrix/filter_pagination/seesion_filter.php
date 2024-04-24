<?php 

// Компонент фильтра для списков
$APPLICATION->IncludeComponent(
  'happe:filter_select',
  'get_method_form', [
    'NAME' => 'CONTACT_ID',
    'LIST' => $arResult['contactsFilterItems'],
  ]
);

// Компонент для сортировки списков
$APPLICATION->IncludeComponent(
  'happe:sort_button',
  'get_method_form', [
    'ORDER' => 'CONTACT_ID'
  ]
);
// Компонент пагинации списков
$APPLICATION->IncludeComponent(
  'happe:pagination',
  'bootstrap4', [
    'PAGES_QUANTITY' => 10,
  ]
);

if ($_GET['order']) {
	$_SESSION['happe_filter']['projects']['order'] = $_GET['order'];
}
if (isset($_SESSION['happe_filter']['projects']['order'])) {
	$order = $_SESSION['happe_filter']['projects']['order'];
} else {
	$order = ['CONTACT_ID' => 'DESC'];
}

if (isset($_GET['filter'])) {
	$_SESSION['happe_filter']['projects']['filter'] = $_GET['filter'];
}
if (isset($_SESSION['happe_filter']['projects']['filter']) and !empty($_SESSION['happe_filter']['projects']['filter'])) {
	$filter = array_merge($filter, $_SESSION['happe_filter']['projects']['filter']);
}
$_GET['order'] = $order;
$_GET['filter'] = $filter;

$limit = 10;
$offset = 0;
if (isset($_GET['page'])) {
	$offset = $_GET['page']-1;
}


$src = \Bitrix\Crm\DealTable::getList([
	'select' => [
		'UF_HAPPE_DEAL_SERVICEPROVIDER',
		'ID',
		'TITLE',
		'CATEGORY_ID',
		'STAGE_ID',
		'DATE_CREATE',
	],
	'filter' => $filter,
	'order' => $order,
	'limit' => $limit,
	'count_total' => true,
	'offset' => $offset,
]);
$arResult['count_total'] =  $src->getCount();
$arResult['pages_quantity'] = ceil( $arResult['count_total'] / $limit );
$arResult['projects_list'] = $src->fetchAll();

$arResult['status_list'] = Bitrix\Crm\StatusTable::getList([
	'filter' => [
		'ENTITY_ID' => 'DEAL_STAGE',
		'CATEGORY_ID' => 0,
	],
	'order' => ['SORT' => 'ASC', ], 
])->fetchAll();

