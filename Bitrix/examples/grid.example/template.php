<?php

$APPLICATION->IncludeComponent(
	'bitrix:main.ui.grid',
	'',
	[
		'GRID_ID' => $arResult['gridID'],
		'COLUMNS' => $arResult['columns'],
		'ROWS' => $arResult['rows'],
		'NAV_OBJECT' => $arResult['nav'],
		'AJAX_MODE' => 'Y',
		'AJAX_OPTION_JUMP' => 'N',
		'AJAX_OPTION_HISTORY' => 'N',
		'SHOW_NAVIGATION_PANEL' => true,
		'SHOW_PAGINATION' => true,
		'SHOW_PAGESIZE' => true,
		'PAGE_SIZES' => [
			['NAME' => 1, 'VALUE' => 1, ],
			['NAME' => 2, 'VALUE' => 2, ],
			['NAME' => 5, 'VALUE' => 5, ],
			['NAME' => 10, 'VALUE' => 10, ],
		],
		'SHOW_TOTAL_COUNTER' => true,
		'TOTAL_ROWS_COUNT' => $arResult['nav']->getRecordCount(),
	]
);