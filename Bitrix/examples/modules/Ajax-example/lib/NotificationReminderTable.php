<?php
namespace Itachsoft\Notifications;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\ORM\Fields\DatetimeField;

use Bitrix\Main\Entity;
use Bitrix\Main\Type;

/**
 * Class NotificationReminderTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> USER int mandatory
 * <li> TITLE string(255) mandatory
 * <li> NOTIFICATION text mandatory
 * </ul>
 *
 * @package Itachsoft\Notifications
 **/

class NotificationReminderTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'itachsoft_notification_reminder';
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
					'title' => Loc::getMessage('NOTIFICATION_REMINDER_ENTITY_ID_FIELD'),
				]
			),
			new IntegerField(
				'MESSAGE_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('NOTIFICATION_REMINDER_ENTITY_MESSAGE_FIELD'),
				]
			),
			new Entity\ReferenceField(
				'MESSAGE', \Bitrix\Im\Model\MessageUnreadTable::class, [
					'=this.MESSAGE_ID' => 'ref.MESSAGE_ID'
				],
			),
			new IntegerField(
				'USER',
				[
					'required' => true,
					'title' => Loc::getMessage('NOTIFICATION_REMINDER_ENTITY_USER_FIELD'),
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
					'title' => Loc::getMessage('NOTIFICATION_REMINDER_ENTITY_TITLE_FIELD'),
				]
			),
			new TextField(
				'NOTIFICATION',
				[
					'required' => true,
					'title' => Loc::getMessage('NOTIFICATION_REMINDER_ENTITY_NOTIFICATION_FIELD'),
				]
			),
			new DatetimeField(
				'REMINDER',
				[
					'title' => Loc::getMessage('CONTACT_BONUS_ENTITY_ACTIVE_TO_FIELD'),
				]
			),
		];
	}
}
