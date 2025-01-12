<?php
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
/**
 *
 */
class itachsoft_loyaltysystem extends CModule
{
	function __construct () {
		$this->MODULE_ID = 'itachsoft.loyaltysystem';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2024-12-30 12:00:00';
		$this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');
		$this->PARTNER_NAME = 'itach-soft';
		$this->PARTNER_URI = 'https://itach.by/';
	}

	function DoInstall() {

		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {

		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}



}