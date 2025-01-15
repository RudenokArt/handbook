<?php
namespace Itachsoft\Loyalitysystem;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;

// ===== !!!!! =====
use Bitrix\Main\Entity;
use Bitrix\Main\Type;
// ===== !!!!! =====

/**
 * Class ContactBonusTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> CONTACT_ID int mandatory
 * <li> QUANTITY int mandatory
 * <li> ACTIVE_FROM datetime optional
 * <li> ACTIVE_TO datetime optional
 * </ul>
 *
 * @package Itachsoft\Loyalitysystem
 **/

class ContactBonusTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'itachsoft_loyalitysystem_contact_bonus';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('CONTACT_BONUS_ENTITY_ID_FIELD'),
				]
			),
			new IntegerField(
				'CONTACT_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('CONTACT_BONUS_ENTITY_CONTACT_ID_FIELD'),
				]
			),
			new Entity\ReferenceField(
				'CONTACT', \Bitrix\Crm\ContactTable::class, [
					'=this.CONTACT_ID' => 'ref.ID'
				],
			),
			new IntegerField(
				'QUANTITY',
				[
					'required' => true,
					'title' => Loc::getMessage('CONTACT_BONUS_ENTITY_QUANTITY_FIELD'),
				]
			),
			new DatetimeField(
				'ACTIVE_FROM',
				[
					'title' => Loc::getMessage('CONTACT_BONUS_ENTITY_ACTIVE_FROM_FIELD'),
				]
			),
			new DatetimeField(
				'ACTIVE_TO',
				[
					'title' => Loc::getMessage('CONTACT_BONUS_ENTITY_ACTIVE_TO_FIELD'),
				]
			),
		];
	}
}