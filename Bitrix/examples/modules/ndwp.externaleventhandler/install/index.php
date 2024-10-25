<?php
/**
 *
 */
class ndwp_externaleventhandler extends CModule
{
	function __construct () {
		$this->MODULE_ID = 'ndwp.externaleventhandler';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2024-10-18 12:00:00';
		$this->MODULE_NAME = 'ndwp.externaleventhandler';
		$this->MODULE_DESCRIPTION = '';
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}

	function DoInstall() {
		registerModuleDependences(
			'iblock', 'OnBeforeIBlockElementAdd', $this->MODULE_ID, 'Ndwp\Externaleventhandler\OnBeforeIBlockElementAddHandler', 'init'
		);
		RegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Installing the module', __DIR__ . '/step.php');
	}

	function DoUninstall() {
		UnRegisterModuleDependences(
			'iblock', 'OnBeforeIBlockElementAdd', $this->MODULE_ID, 'Ndwp\Externaleventhandler\OnBeforeIBlockElementAddHandler', 'init'
		);
		UnRegisterModule($this->MODULE_ID);
		$GLOBALS['APPLICATION']->IncludeAdminFile('Uninstalling the module', __DIR__ . '/unstep.php');
	}

}