<?php

// Событие перед сохранением корзины, 
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'sale',
	'OnSaleBasketBeforeSaved',
	function (\Bitrix\Main\Event $event) {
		$basket = $event->getParameter("ENTITY");
		// \Bitrix\Main\Diag\Debug::writeToFile($arr, 'arr', 'local/tests/test.log');
	}
);

// Получение корзины текущего пользователя 
$fuser = \Bitrix\Sale\Fuser::getId();
$basket = \Bitrix\Sale\Basket::loadItemsForFUser($fuser, SITE_ID);

// получение позиций корзины
$basketItems = $basket->getBasketItems();
foreach ($basketItems as $basketItem) {
	$arr[] = [
		'NAME' => $basketItem->getField('NAME'),
		'PRICE' => $basketItem->getPrice(),
		'QUANTITY' =>  $basketItem->getQuantity(),
	];
}

// установка кастомной цены в корзине
$basketItem->setFields([
	'PRICE' => 500, 
	'CUSTOM_PRICE' => 'Y',
]);

// Получить все поля элемента корзины
$arFields = $basketItem->getAllFields();
foreach ($arFields as $fieldkey => $fieldname) {
	$arr[$fieldkey] = $basketItem->getField($fieldname);
}