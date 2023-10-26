<?php 

$arResult['limit'] = 10;
if (isset($_GET['pageN']) and $_GET['pageN'] > 0) {
	$arResult['pageN'] = $_GET['pageN'];
	$arResult['offset'] = ($arResult['pageN']-1) * $arResult['limit'];
} else {
	$arResult['pageN'] = 1;
	$arResult['offset'] = 0;
}


$arResult['task_src'] = \Bitrix\Tasks\TaskTable::getList([
	'filter' => $arResult['task_list_filter'],
	'select' => [
		'ID',
		'TITLE',
		'DESCRIPTION',
	],
	'order' => ['ID' => 'DESC', ],
	'limit' => $arResult['limit'],
	'count_total' => true,
	'offset' => $arResult['offset'],
]);

$arResult['count_total'] =  $arResult['task_src']->getCount();
$arResult['task_list'] = $arResult['task_src']->fetchAll();
$arResult['count_page'] = ceil($arResult['count_total'] / $arResult['limit']);

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

<form action="" method="get" class="row">
		<?php if ($arResult['count_page'] > 1): ?>
			<div class="col-12 text-center">
				<span>Siten:</span>
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