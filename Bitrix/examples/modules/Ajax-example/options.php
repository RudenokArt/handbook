<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\UI\Extension::load('ui.entity-selector');
\Bitrix\Main\UI\Extension::load("ui.forms");
Loc::loadMessages(__FILE__);
\CJSCore::Init(array("jquery"));
$module_id = 'itachsoft.notifications';
\Bitrix\Main\Loader::includeModule($module_id);
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module_id.'/options.php');
#Описание опций
$aTabs = [
  // ===============================================
  [
    'DIV' => 'NOTIFICATIONS',
    'TAB' => GetMessage('NOTIFICATIONS'),
    "TITLE" => GetMessage('NOTIFICATIONS'),
    'OPTIONS' => [
      [
        'NOTIFICATIONS_ACCESS',
        'NOTIFICATIONS_ACCESS',
        '',
        ['statichtml', ],
      ],
      [
        'REMIND_IN',
        'REMIND_IN',
        '',
        ['statichtml', ],
      ],
    ],
  ], 
  // ================================================
];



// multiselectbox
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

      $optionValue = $request->getPost($optionName);
      Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
    }
  }
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);

if (isset($_POST['NOTIFICATIONS_ACCESS']) ) {
  LocalRedirect('settings.php?mid='.$module_id);
}

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
    
    $notificationsAccessOptions = \COption::GetOptionString($module_id, 'NOTIFICATIONS_ACCESS');
    if (!$notificationsAccessOptions) {
      $notificationsAccessOptions = json_encode([]);
    }

    $remindIn = \COption::GetOptionInt($module_id, 'REMIND_IN');

    if ($aTab['DIV'] == 'NOTIFICATIONS') {
      echo GetMessage('NOTIFICATIONS_ACCESS');
      $APPLICATION->IncludeComponent('itachsoft:tagselector', 'users-groups', [
        'JS_VAR' => 'ItachSoftNotificationsTagSelector',
      ]);
      ?>
      <input type="hidden" name="NOTIFICATIONS_ACCESS">
      <br>
      <?php echo GetMessage('REMIND_IN') ?>
      <div class="ui-ctl ui-ctl-textbox ui-ctl-inline">
        <input type="number" step="1" min="1" value="<?php echo $remindIn; ?>" name="REMIND_IN" class="ui-ctl-element">
      </div>


      <script>

        BX.ready(function () {
          var notificationsAccessOptionsArr = JSON.parse('<?php echo $notificationsAccessOptions; ?>')
          console.log(notificationsAccessOptionsArr);
          notificationsAccessOptionsArr.forEach(function (tag) {
            ItachSoftNotificationsTagSelector.addTag(tag);
          });
          $('div#NOTIFICATIONS').closest('form').bind('submit', function (e) {
            e.preventDefault();
            $(this).off('submit');
            var arrTags = [];
            ItachSoftNotificationsTagSelector.getTags().forEach(function (tag) {
              var tagItem = {
                id: tag.id,
                avatar: tag.avatar,
                entityId: tag.entityId,
                entityType: tag.entityType,
                link: tag.link,
                title: tag.title,
              };
              arrTags.push(tagItem);
            });
            $('input[name="NOTIFICATIONS_ACCESS"]').prop('value', JSON.stringify(arrTags));
            setTimeout(function () {
              $('input[name="Update"]').trigger('click');
            }, 100);
            
          })
        });
      </script>

      <?php 
    } else {
      __AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
    }
    
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

<? $tabControl->End(); ?>

