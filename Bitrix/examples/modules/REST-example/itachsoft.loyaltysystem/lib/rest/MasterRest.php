<?php
namespace Itachsoft\Loyaltysystem; 

use Bitrix\Main\Engine; 

class MasterRest extends Engine\Controller { 
	
	public function helloAction(string $name) { 
		
		return 'Hello ' . $name . '!'; 
		
	} 
	
} 