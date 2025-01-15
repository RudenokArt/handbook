<?php
namespace Itachsoft\Loyalitysystem\Entity;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

/**
 * Class HistoryTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string(255) mandatory
 * <li> TYPE string(8) mandatory
 * <li> BONUS_ID int mandatory
 * <li> QUANTITY int mandatory
 * </ul>
 *
 * @package Itachsoft\Loyalitysystem\Entity
 **/

class HistoryTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'itachsoft_loyalitysystem_history';
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
					'title' => Loc::getMessage('HISTORY_ENTITY_ID_FIELD'),
				]
			),
			new StringField(
				'TITLE',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 255),
						];
					},
					'title' => Loc::getMessage('HISTORY_ENTITY_TITLE_FIELD'),
				]
			),
			new StringField(
				'TYPE',
				[
					'required' => true,
					'validation' => function()
					{
						return[
							new LengthValidator(null, 8),
							function ($value) {
								if ($value == 'inc' or $value == 'dec') {
									return true;
								} else {
									return 'Invalid TYPE';
								}
							},
						];
					},
					'title' => Loc::getMessage('HISTORY_ENTITY_TYPE_FIELD'),
				]
			),
			new IntegerField(
				'QUANTITY',
				[
					'required' => true,
					'title' => Loc::getMessage('HISTORY_ENTITY_QUANTITY_FIELD'),
				]
			),
			new IntegerField(
				'CONTACT_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('HISTORY_ENTITY_CONTACT_ID_FIELD'),
				]
			),
			new Entity\ReferenceField(
				'CONTACT', \Bitrix\Crm\ContactTable::class, [
					'=this.CONTACT_ID' => 'ref.ID'
				],
			),
		];
	}
}