<?php
namespace Bitrix\Sievert;
/**
 * 
 */
class CrmDealObjectProjectField extends \Bitrix\Main\UserField\Types\BaseType {
	public const  USER_TYPE_ID = 'CrmDealObjectProjectField';
	public const RENDER_COMPONENT = 'sievert:crmdealobjectprojectfield';
	public static function getDescription(): array {
		return [
			'DESCRIPTION' => 'CrmDealObjectProjectField',
			'BASE_TYPE' => \CUserTypeManager::BASE_TYPE_STRING
		];

	}
	public static function getDbColumnType(): string {
		return 'text';
	}
}