<?php
namespace Itachsoft\Loyalitysystem\Entity;
use \Bitrix\Main\ORM\Fields\Validators\UniqueValidator;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].'/local/modules/itachsoft.loyalitysystem/lang.php');

use Bitrix\Main\Entity;
use Bitrix\Main\Config\Option;

class ShopTable extends Entity\DataManager
{
	public static function getTableName()
	{
		return 'itachsoft_loyalitysystem_shop';
	}

	public static function getMap()
	{
		return [
			new Entity\IntegerField('ID', [
				'primary' => true,
				'autocomplete' => true,
			]),
			new Entity\IntegerField('WEBHOOK', [
				'required' => true,
				'validation' => function() {
					return array(
						new UniqueValidator(GetMessage('WEBHOOK_IN_USE')),
					);
				}
			]),
			new Entity\IntegerField('DEPARTMENT', [
				'required' => true,
				'validation' => function() {
					return array(
						new UniqueValidator(GetMessage('DEPARTMENT_IN_USE')),
					);
				}
			]),
			new Entity\ReferenceField('DEPARTMENT_REF',
				\Bitrix\Iblock\SectionTable::class,
				['=this.DEPARTMENT' => 'ref.ID']
			),
		];
	}
}
