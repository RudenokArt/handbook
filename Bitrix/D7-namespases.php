<?php 
// Подключить модуль
\Bitrix\Main\Loader::includeModule('disk');

// объект Request
\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQuery('id');

// ПОЛЬЗОВАТЕЛИ
\Bitrix\Main\GroupTable(); // группы пользователей
\Bitrix\Main\UserGroupTable(); // привязка пользователей к группам


// ИНФОБЛОКИ
\Bitrix\Iblock\TypeTable::getList(); // списки типов инфоблоков
\Bitrix\Iblock\IblockTable::getList(); // списки инфоблоков
\Bitrix\Iblock\PropertyTable::getList(); // списки свойств инфоблоков
\Bitrix\Iblock\PropertyEnumerationTable::getList(); // списки значений свойств, хранимых отдельно
\Bitrix\Iblock\SectionTable::getList(); // Списки разделы инфоблоков
\Bitrix\Iblock\ElementTable::getList(); // Списки элементов инфоблоков 
\Bitrix\Iblock\InheritedPropertyTable::getList(); // Списки наследуемых свойств (seo шаблоны) 

// ЗАДАЧИ
// Соисполнители и наблюдатели в задачах
\Bitrix\Tasks\Internals\Task\MemberTable::getList();
// Стадии (Фазы) задач
Bitrix\Tasks\Kanban\StagesTable::getList();
// Файлы задачи 
\Bitrix\Disk\Internals\AttachedObjectTable::getList();

// ДИСК
\Bitrix\Disk\Internals\ObjectTable::getList();


// ЧАТ 
Bitrix\Im\Model\RelationTable(); // Привязка чатов к юзерам
Bitrix\Im\Model\ChatTable(); // Список чатов
Bitrix\Im\Model\MessageTable(); // Сообщения

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
