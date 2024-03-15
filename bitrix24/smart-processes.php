<?php
// Получить элемент смарт-процесса ( 168 - тип смартпроцесса)

$type = \Bitrix\Crm\Service\Container::getInstance()->getFactory(168);

$item = $type->getItem(30)->getData();



// Получить ORM смарт-процесса ( 168 - тип смартпроцесса)

$orm = \Bitrix\Crm\Service\Container::getInstance()->getFactory(168)->getDataClass();

$arr = $orm::getList()->fetchAll();



// Получить смарт-процесс (родителя сделки)

$itemIdentifier = new Bitrix\Crm\ItemIdentifier(CCrmOwnerType::Deal, 28); // 28 - id сделки

$parentRelations = Bitrix\Crm\Service\Container::getInstance()->getRelationManager()->getParentElements($itemIdentifier);

foreach ($parentRelations as $relation) {

if ($relation->getEntityTypeId() === 168) { // 168 - id смарт-процесса

$arr[] =  $relation->getEntityId(); // id элемента смарт-процесса

 }

}



// Получить сделки смартпроцесса

$idf = new Bitrix\Crm\ItemIdentifier(168, 30); // 168 - тип смартпроцесса, 30 - id смартпроцесса

$rel =  Bitrix\Crm\Service\Container::getInstance()->getRelationManager()->getChildElements($idf);

foreach ($rel as $key => $value) {

$arr[] = $value->getEntityId();

}

//  Привязать сделку к смартпроцессу

$idfSmart = new Bitrix\Crm\ItemIdentifier(168, 30); // 168 - тип смартпроцесса, 30 - id смартпроцесса

$idfDdeal = new Bitrix\Crm\ItemIdentifier(2, 3);  // 2 -тип сделки, 3 - id сделки

$bindItems = Bitrix\Crm\Service\Container::getInstance()

->getRelationManager()

->bindItems($idfSmart, $idfDdeal);