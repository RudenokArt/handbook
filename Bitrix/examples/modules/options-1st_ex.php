<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

CJSCore::Init(array('access'));
Loc::loadMessages(__FILE__);
$module_id = 'itach.teachbase';

//region Доступ к пункту меню "Мои курсы"\

$panel = "
<script>

function InsertAccess(arRights, divId, hiddenName)
{
	var div = BX(divId);
	for(var provider in arRights)
	{
		for(var id in arRights[provider])
		{
			var pr = BX.Access.GetProviderPrefix(provider, id);
			var newDiv = document.createElement('DIV');
			newDiv.style.marginBottom = '4px';
			newDiv.innerHTML = '<input type=\"hidden\" name=\"'+hiddenName+'\" value=\"'+id+'\">' + (pr? pr+': ':'') + BX.util.htmlspecialchars(arRights[provider][id].name) + '&nbsp;<a href=\"javascript:void(0);\" onclick=\"DeleteAccess(this, \\''+id+'\\')\" class=\"access-delete\"></a>';
			div.appendChild(newDiv);
		}
	}
}

function DeleteAccess(ob, id)
{
	var div = BX.findParent(ob, {'tag':'div'});
	div.parentNode.removeChild(div);
}

function ShowPanelFor()
{
	BX.Access.Init({
		other: {disabled:true}
	});
	BX.Access.SetSelected({});
	BX.Access.ShowForm({
		callback: function(obSelected)
		{
			InsertAccess(obSelected, 'bx_access_div', 'access_to_menu_my_course[]');
		}
	});
}

</script>

<div id=\"bx_access_div\">
";
$arCodes = unserialize(COption::GetOptionString($module_id, "access_to_menu_my_course"), ['allowed_classes' => false]);

if(!is_array($arCodes))
    $arCodes = array();


$access = new CAccess();
$arNames = $access->GetNames($arCodes);

foreach($arCodes as $code)
    $panel .= '<div style="margin-bottom:4px"><input type="hidden" name="access_to_menu_my_course[]" value="'.$code.'">'.($arNames[$code]["provider"] <> ''? $arNames[$code]["provider"].': ':'').htmlspecialcharsbx($arNames[$code]["name"]).'&nbsp;<a href="javascript:void(0);" onclick="DeleteAccess(this, \''.$code.'\')" class="access-delete"></a></div>';

$panel .= '</div><a href="javascript:void(0)" class="bx-action-href" onclick="ShowPanelFor()">Добавить пользователя</a>';

$options[] = [
    '',
    'Доступ к пункту меню "Мои курсы"',
    $panel,
    Array("statichtml")
];

//endregion


$aTabs = [
    [
        'DIV' => 'settings',
        'TAB' => 'Настройки',
        "TITLE" => 'Настройки',
        'OPTIONS' => [
            [
                'client_id',
                'API публичный ключ',
                '',
                ['password', 50],
            ],
            [
                'client_secret',
                'API секретный ключ',
                '',
                ['password', 50],
            ],
            [
                'url',
                'URI',
                '',
                ['text', 50],
            ],
        ]
    ],
    [
        'DIV' => 'access',
        'TAB' => 'Доступы',
        "TITLE" => 'Доступы',
        'OPTIONS' => $options,
    ]
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
