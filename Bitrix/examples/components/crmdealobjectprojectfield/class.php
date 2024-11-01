<?php
class CrmDealObjectProjectFieldUfComponent extends Bitrix\Main\Component\BaseUfComponent {
	protected static function getUserTypeId(): string {
		return Bitrix\Sievert\CrmDealObjectProjectField::USER_TYPE_ID;
	}
	protected function prepareResult(): void {
		if ($this->additionalParameters['mode'] == 'main.view' or $this->additionalParameters == 'main.edit') {
			$this->additionalParameters['mode'] = '.default';
		} else {
			$this->additionalParameters['mode'] = '.default';
		}
	}
}