<?php


$APPLICATION->IncludeComponent('exxagate:tagSelector', 'users', [
	'FILTER' => [
		'ID' => [1, 4, 5, 6, ],
	],
	'INPUT_NAME' => 'USERS[]',
	'REQUIRE' => true,
	'SELECTED' => [4, 5, ]
]);
