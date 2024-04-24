<?php 

$deals_filter = [
	'CATEGORY_ID' => $arResult['support_funnel'],
	'ID' => $deals_ids,
];

if (isset($_GET['search']) and $_GET['search']) {
	$deals_filter[] = [
		"LOGIC" => "OR",
		["TITLE" => '%'.$_GET['search'].'%'],
		["COMMENTS" => '%'.$_GET['search'].'%'],
	];
}

if (isset($_GET['date_from']) and $_GET['date_from']) {
	$deals_filter['>=DATE_CREATE'] = new \Bitrix\Main\Type\DateTime($_GET['date_from'], 'Y-m-d');
}
if (isset($_GET['date_to']) and $_GET['date_to']) {
	$deals_filter['<=DATE_CREATE'] = (new \Bitrix\Main\Type\DateTime($_GET['date_to'], 'Y-m-d'))
	->add('1D');
}

$deals_order = ['DATE_CREATE' => 'DESC', ];
if (isset($_GET['order']) and $_GET['order']) {
	$deals_order = $_GET['order'];
}

$limit = 10;
if (isset($_GET['pageN']) and $_GET['pageN'] > 0) {
	$arResult['pageN'] = $_GET['pageN'];
	$offset = ($arResult['pageN']-1) * $limit;
} else {
	$arResult['pageN'] = 1;
	$offset = 0;
}

$deals_src = \Bitrix\Crm\DealTable::getList([
	'filter' => $deals_filter,
	'order' => $deals_order,
	'select' => [
		'ID',
		'DATE_CREATE',
		'TITLE',
		'ASSIGNED_BY_ID',
		'STAGE_ID',
		'ASSIGNED_NAME' => 'ASSIGNED.NAME',
		'ASSIGNED_SECOND_NAME' => 'ASSIGNED.SECOND_NAME',
		'ASSIGNED_LAST_NAME' => 'ASSIGNED.LAST_NAME',
		'STAGE_NAME' => 'STAGE.NAME',
		'STAGE_COLOR' => 'STAGE.COLOR', 
	],
	'runtime' => [
		'ASSIGNED' => [
			'data_type' => 'Bitrix\Main\UserTable',
			'reference' => ['this.ASSIGNED_BY_ID' => 'ref.ID'],
		],
		'STAGE' => [
			'data_type' => 'Bitrix\Crm\StatusTable',
			'reference' => ['this.STAGE_ID' => 'ref.STATUS_ID'],
		],
	],
	'limit' => $limit,
	'count_total' => true,
	'offset' => $offset,
]);

$deals_src->addFetchDataModifier(function (&$data) {
	$data['DATE_CREATE'] = $data['DATE_CREATE']->format('Y-m-d');
});
$arResult['count_total'] =  $deals_src->getCount();
$arResult['deals_list'] = $deals_src->fetchAll();


$arResult['count_page'] = ceil($arResult['count_total'] / $limit);

$arResult['page_int'] = 2;

$arResult['min_page'] = $arResult['pageN'] - $arResult['page_int'];
if ($arResult['min_page'] < 1) {
	$arResult['min_page'] = 1;
} 

$arResult['max_page'] = $arResult['pageN'] + $arResult['page_int'];
if ($arResult['max_page'] > $arResult['count_page']) {
	$arResult['max_page'] = $arResult['count_page'];
}

?>

<form action="" method="get" class="mt-5 pt-3 pb-3 container-fluid bg-white">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-2">
			<input <?php if (isset($_GET['search'])): ?>
			value="<?php echo $_GET['search'] ?>"
			<?php endif ?> type="search" name="search" class="form-control" placeholder="<?php echo GetMessage('SEARCH') ?>">		
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-2">
			<div class="row">
				<div class="col-2 text-secondary text-end pt-2">
					<i class="fa fa-calendar" aria-hidden="true"></i>
				</div>
				<div class="col-5">
					<input <?php if (isset($_GET['date_from'])): ?>
					value="<?php echo $_GET['date_from'] ?>"
					<?php endif ?> type="text" name="date_from" class="form-control" readonly>
				</div>
				<div class="col-5">
					<input <?php if (isset($_GET['date_to'])): ?>
					value="<?php echo $_GET['date_to'] ?>"
					<?php endif ?> type="text" name="date_to" class="form-control" readonly>
				</div>	
			</div>			
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-2">
			<select name="order[DATE_CREATE]" class="form-select">
				<option <?php if ($_GET['order']['DATE_CREATE']=='DESC'): ?>
				selected
				<?php endif ?> value="DESC">
				<?php echo GetMessage('DATE_DESC'); ?>
			</option>
			<option <?php if ($_GET['order']['DATE_CREATE']=='ASC'): ?>
			selected
			<?php endif ?> value="ASC">
			<?php echo GetMessage('DATE_ASC'); ?>
		</option>
	</select>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-2">
	<div class="row">
		<div class="col-6">
			<button class="btn btn-info w-100">
				<i class="fa fa-check" aria-hidden="true"></i>
			</button>
		</div>
		<div class="col-6">
			<a href="?" class="btn btn-warning w-100">
				<i class="fa fa-times" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</div>
</div>

<?php if ($arResult['count_page'] > 1): ?>
	<div class="col-12 pt-5 text-center">
		<?php if ($arResult['pageN'] > $arResult['page_int']+1): ?>
			<button class="btn btn-sm btn-outline-secondary" value="1" name="pageN">1</button>
		<?php endif ?>
		<?php if ($arResult['pageN'] > $arResult['page_int']+2): ?>
			<span>...</span>
		<?php endif ?>
		<?php for ($i = $arResult['min_page']; $i <= $arResult['max_page']; $i++):?>
			<button value="<?php echo $i; ?>" <?php if ($arResult['pageN'] == $i): ?>
			class="btn btn-sm btn-outline-danger"
		<?php else: ?>
			class="btn btn-sm btn-outline-secondary"
			<?php endif ?> name="pageN">
			<?php echo $i; ?>
		</button>
	<?php endfor; ?>
	<?php if ($arResult['pageN'] < ($arResult['count_page'] - 1 - $arResult['page_int'])): ?>
		<span>...</span>
	<?php endif ?>
	<?php if ($arResult['pageN'] < ($arResult['count_page'] - $arResult['page_int'])): ?>
		<button class="btn btn-sm btn-outline-secondary" value="<?php echo $arResult['count_page'] ?>" name="pageN">
			<?php echo $arResult['count_page'] ?>
		</button>
	<?php endif ?>
</div>
<?php endif ?>
</form>