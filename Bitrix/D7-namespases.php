<?php 
// Подключить модуль
\Bitrix\Main\Loader::includeModule('crm');

// объект Request
\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQuery('id');

// Контакты
\Bitrix\Crm\ContactTable::getList();

// Статусы сделок
Bitrix\Crm\StatusTable::getList();

// Категории сделок
Bitrix\Crm\Category\DealCategory::getAll(true);

?>