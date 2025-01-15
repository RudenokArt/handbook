<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Engine\Controller;
\Bitrix\Main\Loader::includeModule('im');
\Bitrix\Main\Loader::includeModule('itachsoft.notifications');


class ItachSoftNotificationsAjaxController extends Controller {

	public static function sendMessageAction($TITLE=false, $NOTIFICATION=false, $USERS=false, $GROUPS=false, $DEPARTMENTS=fasle) {
		global $USER;
		if (
			(!isset($USERS) or !is_array($USERS))
			and
			(!isset($GROUPS) or !is_array($GROUPS))
			and
			(!isset($DEPARTMENTS) or !is_array($DEPARTMENTS))
		) {
			return 'INVALID_NOTIFICATION_USERS';
		}
		if (!isset($TITLE) or empty($TITLE)) {
			return 'INVALID_TITLE';
		}
		if (!isset($NOTIFICATION) or empty($NOTIFICATION)) {
			return 'INVALID_NOTIFICATION';
		}

		$usersList = self::getUsersList($USERS, $GROUPS, $DEPARTMENTS);
		$fromUserId = (integer)$USER->getId();

		foreach ($usersList as $key => $value) {
			$messageId = CIMMessenger::Add([
				'NOTIFY_TITLE' => $TITLE,
				'MESSAGE' => $NOTIFICATION,
				'MESSAGE_TYPE' => IM_MESSAGE_SYSTEM,
				'TO_USER_ID' => $value,
				'FROM_USER_ID' => 0,
				'NOTIFY_TYPE' => IM_NOTIFY_SYSTEM,
				'NOTIFY_MODULE' => 'main',
				'NOTIFY_EVENT' => 'manage',
			]);
			$time = \COption::GetOptionInt('itachsoft.notifications', 'REMIND_IN');
			\Itachsoft\Notifications\NotificationReminderTable::add([
				'MESSAGE_ID' => $messageId,
				'USER' => $value,
				'TITLE' => $TITLE,
				'NOTIFICATION' => $NOTIFICATION,
				'REMINDER' => (new \Bitrix\Main\Type\DateTime())->add('PT'.$time.'S'),
			]);
		}

	return 'NOTIFICATION_SUCCESS';
}

private static function getUsersList ($USERS, $GROUPS, $DEPARTMENTS) {
	if (isset($USERS) and is_array($USERS) and count($USERS)) {
		$users = \Bitrix\Main\UserTable::getList([
			'filter' => ['ID' => $USERS],
			'select' => ['ID'],
		])->fetchAll();
	}
	if (isset($DEPARTMENTS) and is_array($DEPARTMENTS) and count($DEPARTMENTS)) {
		$usersD = \Bitrix\Main\UserTable::getList([
			'filter' => ['UF_DEPARTMENT' => $DEPARTMENTS],
			'select' => ['ID'],
		])->fetchAll();
	}
	if (isset($GROUPS) and is_array($GROUPS) and count($GROUPS)) {
		$usersG = \Bitrix\Main\UserTable::getList([
			'filter' => ['GROUP.GROUP_ID' => $GROUPS],
			'select' => ['ID'],
			'runtime' => [
				'GROUP' => [
					'data_type' => 'Bitrix\Main\UserGroupTable',
					'reference' => ['this.ID' => 'ref.USER_ID'],
				],
			],
		])->fetchAll();
	}
	$arr = [];
	if ($users) {
		$arr = array_merge($arr, $users);
	}
	if ($usersD) {
		$arr = array_merge($arr, $usersD);
	}
	if ($usersG) {
		$arr = array_merge($arr, $usersG);
	}
	$re = [];
	foreach ($arr as $key => $value) {
		$re[] = $value['ID'];
	}
	$re = array_unique($re);

	return $re;
}

}