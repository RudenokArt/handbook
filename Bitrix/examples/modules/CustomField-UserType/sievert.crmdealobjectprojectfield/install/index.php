<?php
/**
 *
 */
class sievert_crmdealobjectprojectfield extends CModule
{
	function __construct () {
		$this->MODULE_ID = 'sievert.crmdealobjectprojectfield';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2024-10-03 12:00:00';
		$this->MODULE_NAME = 'sievert.crmdealobjectprojectfield';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}

	function DoInstall() {

		\Bitrix\Main\EventManager::getInstance()->registerEventHandlerCompatible(
			'main',
			'onUserTypeBuildList',
			$this->MODULE_ID,
			'Bitrix\Sievert\CrmDealObjectProjectField',
			'getUserTypeDescription'
		);

		RegisterModule($this->MODULE_ID);

		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {

		\Bitrix\Main\EventManager::getInstance()->unRegisterEventHandler(
			'main',
			'onUserTypeBuildList',
			$this->MODULE_ID,
			'Bitrix\Sievert\CrmDealObjectProjectField',
			'getUserTypeDescription'
		);

		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');

	}

}