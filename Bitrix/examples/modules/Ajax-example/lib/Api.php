<?php
namespace Itachsoft\Notifications;
\Bitrix\Main\Loader::includeModule('im');
\Bitrix\Main\Loader::includeModule('itachsoft.notifications');

use Bitrix\Main\Engine; 

class Api extends Engine\Controller { 
	
	public function notificationRemindAction() {
		global $USER;

		if ($USER->IsAuthorized()) {

			$time = new \Bitrix\Main\Type\DateTime();
			$arMes = \Itachsoft\Notifications\NotificationReminderTable::getList([
				'filter' => [
					'USER' => $USER->getId(),
					'<REMINDER' => $time,
				],
				'select' => [
					'*',
					'MESSAGE_UNREAD' => 'MESSAGE.MESSAGE_ID',
				],

			])->fetchAll();

			foreach ($arMes as $key => $value) {
				\Itachsoft\Notifications\NotificationReminderTable::delete($value['ID']);	
			}

			return $arMes;

		} else {
			return false;
		}
		
	} 
	
} 