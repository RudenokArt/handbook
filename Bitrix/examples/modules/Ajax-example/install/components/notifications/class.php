<?php
\Bitrix\Main\Loader::includeModule('im');
\CJSCore::Init(array("jquery"));
\Bitrix\Main\UI\Extension::load("ui.notification");
class ItachSoftNotifications extends \CBitrixComponent {
	
	public function executeComponent()	{
		global $USER;
		$this->arResult['access'] = false;
		$this->userId = $USER->getId();
		$this->arResult['userGroups'] = $USER->GetUserGroupArray();
		$this->arResult['arUser'] = $this->getArUser();
		$this->arResult['arOptions'] = $this->arOptionsGet();
		
		if (
			(
				is_array($this->arResult['arOptions']['user'])
				and
				in_array($this->userId, $this->arResult['arOptions']['user'])
			)
			or
			(
				is_array($this->arResult['arOptions']['department'])
				and
				array_intersect($this->arResult['arUser']['UF_DEPARTMENT'], $this->arResult['arOptions']['department'])
			)
			or
			(
				is_array($this->arResult['arOptions']['group'])
				and
				array_intersect($this->arResult['userGroups'], $this->arResult['arOptions']['group'])
			)
		) {
			$this->arResult['access'] = true;
		}
		
		$this->includeComponentTemplate();
	}

	private function getArUser () {
		return \Bitrix\Main\UserTable::getList([
			'filter' => ['ID' => $this->userId,],
			'select' => ['ID', 'UF_DEPARTMENT'],
		])->fetch();
	}

	private function arOptionsGet () {
		$stringOptions = \COption::GetOptionString('itachsoft.notifications', 'NOTIFICATIONS_ACCESS');
		$arOptions = json_decode($stringOptions, true);
		foreach ($arOptions as $key => $value) {
			$re[$value['entityId']][] = $value['id'];
		}
		
		return $re;
	}

}