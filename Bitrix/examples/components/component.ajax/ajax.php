<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Engine\Controller;


class CustomAjaxController extends Controller {

	public static function testAjaxAction() {
		return 'testAjaxData';
	}

	
}