<?php
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
/**
 *
 */
class itachsoft_notifications extends CModule
{
	function __construct () {
		$this->MODULE_ID = 'itachsoft.notifications';
		$this->MODULE_VERSION = '1.0.0';
		$this->MODULE_VERSION_DATE = '2024-12-25 12:00:00';
		$this->MODULE_NAME = GetMessage('MODULE_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('MODULE_DESCRIPTION');
		$this->PARTNER_NAME = 'itach-soft';
		$this->PARTNER_URI = 'https://itach.by/';
	}

	function DoInstall() {

		// $this->installFiles();

		registerModuleDependences(
			'main',
			'OnBeforeProlog',
			$this->MODULE_ID,
			'\Itachsoft\Notifications\ExternalEventHandler',
			'OnBeforeProlog'
		);

		$this->installMenu();
		RegisterModule($this->MODULE_ID);
		$this->installDB();
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function installFiles () {

		CopyDirFiles(
			__DIR__.'/components',
			$_SERVER["DOCUMENT_ROOT"]."/local/components/itachsoft/",
			true,
			true
		);

		CopyDirFiles(
			__DIR__."/notifications",
			$_SERVER["DOCUMENT_ROOT"]."/notifications/",
			true,
			true
		);
	}

	function installMenu () {
		
		\Bitrix\Main\Config\Option::set('intranet', 'left_menu_preset', 'custom');
		$items = \Bitrix\Main\Config\Option::get('intranet', 'left_menu_custom_preset_items');
		if (!$items) {
			$items = [];
		} else {
			$items = unserialize($items);
		}
		if (!$items) {
			$items = [];
		}
		$items[] = [
			'LINK' => '/notifications/',
			'TEXT' => GetMessage('MODULE_NAME'),
			'ID' => 'itachsoft.notifications',
		];
		$items = serialize($items);
		\Bitrix\Main\Config\Option::set('intranet', 'left_menu_custom_preset_items', $items, 's1');
	}

	function unInstallMenu () {
		$items = \Bitrix\Main\Config\Option::get('intranet', 'left_menu_custom_preset_items');
		$items = unserialize($items);

		foreach ($items as $key => $value) {
			if ($value['ID'] == 'itachsoft.notifications') {
				unset($items[$key]);
			}
		}
		$items = serialize($items);
		\Bitrix\Main\Config\Option::set('intranet', 'left_menu_custom_preset_items', $items, 's1');
	}

	function installDB () {
		\Bitrix\Main\Loader::includeModule($this->MODULE_ID);
		if (
			!\Itachsoft\Notifications\NotificationReminderTable::getEntity()->getConnection()
			->isTableExists(\Itachsoft\Notifications\NotificationReminderTable::getTableName())
		) {
			\Itachsoft\Notifications\NotificationReminderTable::getEntity()->createDbTable();
		}
	}


	function DoUninstall() {
		unRegisterModuleDependences(
			'main',
			'OnBeforeProlog',
			$this->MODULE_ID,
			'\Itachsoft\Notifications\ExternalEventHandler',
			'OnBeforeProlog'
		);

		$this->unInstallMenu();
		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}



}