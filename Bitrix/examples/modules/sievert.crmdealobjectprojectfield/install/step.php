<?php 
if(!check_bitrix_sessid()) return;
echo CAdminMessage::ShowNote("The module has been installed successfully");

$field = CUserTypeEntity::GetList([], [
	'ENTITY_ID' => 'CRM_DEAL',
	'FIELD_NAME' => 'UF_CRM_DEAL_OBJECT_PROJECT_FIELD',
])->Fetch();
if (!$field) {
	$oUserTypeEntity = new CUserTypeEntity();
	$aUserFields_bind = array(
		'ENTITY_ID' => 'CRM_DEAL',
		'FIELD_NAME' => 'UF_CRM_DEAL_OBJECT_PROJECT_FIELD',
		'USER_TYPE_ID' => 'CrmDealObjectProjectField',
		'MULTIPLE'=> 'N',
		'SHOW_FILTER' => 'I',
		'EDIT_FORM_LABEL' => array(
			'ru' => 'Проект',
			'en' => 'Project',
			'de' => 'Projekt',
		),
		'LIST_COLUMN_LABEL' => array(
			'ru' => 'Проект',
			'en' => 'Project',
			'de' => 'Projekt',
		),
	);
	$oUserTypeEntity->Add($aUserFields_bind);
}