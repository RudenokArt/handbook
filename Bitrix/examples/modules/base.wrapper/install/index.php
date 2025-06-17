<?php
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].'/local/modules/itachsoft.absentemployee/lang.php');
/**
 *
 */
class itachsoft_absentemployee extends CModule
{
	function __construct () {
		$this->MODULE_ID = 'itachsoft.absentemployee';
		$this->MODULE_VERSION = '1.0';
		$this->MODULE_VERSION_DATE = '2025-06-13 12:00:00';
		$this->MODULE_NAME = GetMessage('itachsoft_absentemployee');
		$this->MODULE_DESCRIPTION =  GetMessage('itachsoft_absentemployee_description');
		$this->PARTNER_NAME = 'Rudenok A.';
		$this->PARTNER_URI = '';
	}

	function DoInstall() {
		
		RegisterModule($this->MODULE_ID);
	}

	function DoUninstall() {
		
		UnRegisterModule($this->MODULE_ID);
	}

}