<?php 
// Подключить модуль
\Bitrix\Main\Loader::includeModule('crm');

// объект Request
\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQuery('id');

// Статусы сделок
Bitrix\Crm\StatusTable::getList();
// Категории сделок
Bitrix\Crm\Category\DealCategory::getAll(true);
// Все сделки по контакту: 
\Bitrix\Crm\Binding\DealContactTable::getContactDealIDs($contact_id);
// Телефоны и email контактов
Bitrix\Crm\FieldMultiTable::getList();
// Адреса контактов
\Bitrix\Crm\AddressTable::getList();
// Контакты
\Bitrix\Crm\ContactTable::getList();

// ИНФОБЛОКИ
\Bitrix\Iblock\TypeTable::getList(); // списки типов инфоблоков
\Bitrix\Iblock\IblockTable::getList(); // списки инфоблоков
\Bitrix\Iblock\PropertyTable::getList(); // списки свойств инфоблоков
\Bitrix\Iblock\PropertyEnumerationTable::getList(); // списки значений свойств, хранимых отдельно
\Bitrix\Iblock\SectionTable::getList(); // Списки разделы инфоблоков
\Bitrix\Iblock\ElementTable::getList(); // Списки элементов инфоблоков 
\Bitrix\Iblock\InheritedPropertyTable::getList(); // Списки наследуемых свойств (seo шаблоны) 


// МОДУЛЬ DOCUMENTGENERATOR
\Bitrix\Main\Loader::includeModule('documentgenerator');
// классы для таблицы b_documentgenerator_template
print_r(get_class_methods('Bitrix\DocumentGenerator\Model\TemplateTable'));
print_r(get_class_methods('Bitrix\DocumentGenerator\Template'));
// Класс для работы с таблицей b_documentgenerator_file
Bitrix\DocumentGenerator\Model\FileTable();
// Класс для работы с таблицей b_documentgenerator_document
Bitrix\DocumentGenerator\Model\DocumentTable();
// Получить элемент таблицы b_file по полю FILE_ID таблицы b_documentgenerator_template
Bitrix\DocumentGenerator\Model\FileTable::getBFileId($file_id);
