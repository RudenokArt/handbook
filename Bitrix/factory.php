<?php
// Статья:
// https://vc.ru/services/1657053-rabota-s-d7-factory-fabrikoi-v-bitriks24?ysclid=m6i2r2vcd4245847837

\Bitrix\Main\Loader::IncludeModule('crm');
use Bitrix\Crm\Service;
use Bitrix\Crm\Item;
use Bitrix\Main\Type\DateTime;
$factory = Service\Container::getInstance()->getFactory(CCrmOwnerType::Contact);
$item = $factory->getItem(1);

$item->set('SECOND_NAME', 'Иванович');
$operation = $factory->getUpdateOperation($item);
$res = $operation->launch();

if (!$res->isSuccess()) {
    print_r($res->getErrorMessages());
}