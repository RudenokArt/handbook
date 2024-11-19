<?php

$APPLICATION->IncludeComponent('exxagate:tagSelector', 'user', [
	'FILTER' => [
		'ID' => [1, 4, 5, ],
	],
	'INPUT_NAME' => 'USER',
	'REQUIRE' => true,
	'SELECTED' => 4,
]);