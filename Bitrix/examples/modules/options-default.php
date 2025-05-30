<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].'/local/modules/itachsoft.elastic/lang.php');
$module_id = 'itachsoft.elastic';


$aTabs = [
	[
		'DIV' => 'settings',
		'TAB' => GetMessage('SETTINGS'),
		"TITLE" => GetMessage('SETTINGS'),
		'OPTIONS' => [
			[
				'serviceName',
				GetMessage('SERVICE_NAME'),
				'',
				['text', 50],
			],
		]
	],
];

#Сохранение
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if ($request->isPost() && $request['Update'] && check_bitrix_sessid()) {
	foreach ($aTabs as $aTab) {
		foreach ($aTab['OPTIONS'] as $arOption) {
			if (!is_array($arOption)) {
				continue;
			}

			if ($arOption['note']) {
				continue;
			};
			$optionName = $arOption[0];
			if (!empty($optionName)) {
				if ($arOption[4] !== 'Y') {
					$optionValue = $request->getPost($optionName);

					Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
				}
			}else {
				COption::SetOptionString($module_id, "access_to_menu_my_course", serialize($_POST["access_to_menu_my_course"] ?? ''));
			}
		}
	}
	LocalRedirect("/bitrix/admin/settings.php?lang=".LANGUAGE_ID."&amp;mid=".$module_id);
}


$tabControl = new CAdminTabControl('tabControl', $aTabs);

?>
<?
$tabControl->Begin(); ?>
<form method='post'
action='<?
echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialcharsbx($request['mid']) ?>&amp;lang=<?= $request['lang'] ?>'
name='CORUS_YEAR_PLAN_settings'>
<?
foreach ($aTabs as $aTab):
	if ($aTab['OPTIONS']):?>
		<?
		$tabControl->BeginNextTab(); ?>
		<?
		__AdmSettingsDrawList($module_id, $aTab['OPTIONS']); ?>
		<?
	endif;
endforeach; ?>

<?
$tabControl->Buttons(); ?>
<input type="submit" name="Update" value="<?
echo GetMessage('MAIN_SAVE') ?>">
<input type="reset" name="reset" value="<?
echo GetMessage('MAIN_RESET') ?>">
<?= bitrix_sessid_post(); ?>
</form>

<?
$tabControl->End(); ?>