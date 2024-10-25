<?php
namespace Ndwp\Externaleventhandler;
/**
 * 
 */
class OnBeforeIBlockElementAddHandler {
	
	public static function init ($arFields) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/local/log.json', json_encode([
			$arFields,
		]));
		// global $APPLICATION;
		// $APPLICATION->throwException("Введите символьный код44.");
		// return false;
	}
}