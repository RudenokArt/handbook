<?php

class ModalAgreement extends \CBitrixComponent {
	
	public function executeComponent()	{
		$this->arResult['test'] = 'test1';
		$this->includeComponentTemplate();
	}
		
}