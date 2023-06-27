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

// Все сделки по контакту: 
\Bitrix\Crm\Binding\DealContactTable::getContactDealIDs($contact_id);

// ИНФОБЛОКИ
\Bitrix\Iblock\TypeTable::getList(); // списки типов инфоблоков
\Bitrix\Iblock\IblockTable::getList(); // списки инфоблоков
\Bitrix\Iblock\PropertyTable::getList(); // списки свойств инфоблоков
\Bitrix\Iblock\PropertyEnumerationTable::getList(); // списки значений свойств, хранимых отдельно
\Bitrix\Iblock\SectionTable::getList(); // Списки разделы инфоблоков
\Bitrix\Iblock\ElementTable::getList(); // Списки элементов инфоблоков 
\Bitrix\Iblock\InheritedPropertyTable::getList(); // Списки наследуемых свойств (seo шаблоны) 