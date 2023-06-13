<?php 
// Подключить модуль
\Bitrix\Main\Loader::includeModule('crm');

// Контакты
\Bitrix\Crm\ContactTable::getList();

?>