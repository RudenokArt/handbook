<?php

\Bitrix\Main\Loader::includeModule('socialnetwork');

// ДОБАВИТЬ ПРОЕКТ (ГРУППУ)
$arFields = array(
	"SITE_ID" => SITE_ID,
	"NAME" => $TITLE,
	"DESCRIPTION" => $DESCRIPTION,
	"SUBJECT_ID" => 2,
	"KEYWORDS" => $TITLE,
	"INITIATE_PERMS" => SONET_ROLES_OWNER,
	"SPAM_PERMS" => SONET_ROLES_OWNER,
	"PROJECT" => "Y",
);
$groupId = \CSocNetGroup::CreateGroup($USER_ID, $arFields);
if (!$groupId) {
	if ($e = $GLOBALS["APPLICATION"]->GetException()) {
		$errorMessage .= $e->GetString();
		return ['result' => 'error', 'text' => $errorMessage];
	}
}

// ПОЛУЧИТЬ СПИСОК ПРОЕКТОВ
$src = \CSocNetGroup::GetList(['ID' => 'DESC'], [
	'ID' => $projectIds,
], false, false, ['ID', 'NAME', 'DATE_CREATE',]);
while ($item = $src->Fetch()) {
	$arr[] = $item;
}