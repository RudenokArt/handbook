<?php
\Bitrix\Main\Loader::registerAutoLoadClasses(
	'itachsoft.notifications', [
		'\Itachsoft\Notifications\NotificationReminderTable' => 'lib/NotificationReminderTable.php',
		'\Itachsoft\Notifications\ExternalEventHandler' => 'lib/ExternalEventHandler.php',
		'\Itachsoft\Notifications\Api' => 'lib/Api.php',
	]
);


// https://bitrix24-dev/rest/1/w39a405o2pe5j2xj/itachsoft.notifications.api.notificationremind/