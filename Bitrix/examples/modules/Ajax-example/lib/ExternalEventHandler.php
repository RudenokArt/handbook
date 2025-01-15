<?php
namespace Itachsoft\Notifications;
\Bitrix\Main\Loader::includeModule('im');
\Bitrix\Main\Loader::includeModule('itachsoft.notifications');
/**
 * 
 */
class ExternalEventHandler {
	
	public static function OnBeforeProlog () {
		global $USER;

		if ($USER->IsAuthorized()) {
			\Bitrix\Main\UI\Extension::load("ui.notification");
			\CJSCore::RegisterExt('ItachSoftNotifications', array(
				'js' => '/local/modules/itachsoft.notifications/lib/script.js',
			));
			\CUtil::InitJSCore(array('ItachSoftNotifications'));

		}
	}

}
