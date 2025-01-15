<?php $APPLICATION->SetTitle(GetMessage('NOTIFICATION')); ?>
<?php \Bitrix\Main\UI\Extension::load('ui.entity-selector'); ?>
<?php if ($arResult['access']): ?>
	<form action="" method="post" id="ItachSoftNotificationsForm">
		
		<?php $APPLICATION->IncludeComponent('itachsoft:tagselector', 'users-groups', [
			'JS_VAR' => 'ItachSoftNotificationsTagSelector',
		]); ?>
		<br>
		<?php echo GetMessage('TITLE'); ?>
		<div class="ui-ctl ui-ctl-textbox ui-ctl-block">
			<input type="text" name="TITLE" class="ui-ctl-element">
		</div>
		<br>
		<?php echo GetMessage('NOTIFICATION_TEXT'); ?>
		<div class="htmlEditor">
			<?php $LHE = new CLightHTMLEditor;
			$LHE->Show([
				'id' => "",
				'width' => '100%',
				'height' => '200px',
				'inputName' => 'NOTIFICATION',
				'content' => '',
				'BBCode' => true,
				'bUseFileDialogs' => false,
				'bFloatingToolbar' => false,
				'bArisingToolbar' => false,
				'toolbarConfig' => [
					'Bold',
					'Italic',
					'Underline',
					'CreateLink',
					'DeleteLink',
					'ForeColor',
				],
			]); ?>
		</div>


		<button id="ItachSoftNotificationsButton" class="ui-btn ui-btn-lg ui-btn-primary ui-btn-icon-done">
			<?php echo GetMessage('SEND'); ?>
		</button>
	</form>


	<script>
		BX.ready(function(){
			$('#ItachSoftNotificationsForm').submit(function (e) {
				e.preventDefault();
				var formdata = new FormData(e.target);
				var users = {};
				ItachSoftNotificationsTagSelector.getTags().forEach((tag) => {
					if (!users[tag.entityId]) {
						users[tag.entityId] = [];
					}
					users[tag.entityId].push(tag.id);
				})
				testAjaxRequest(formdata, users);
			});

			async function testAjaxRequest (formdata, users) {

				$('#ItachSoftNotificationsButton').toggleClass('ui-btn-wait');

				var re = await BX.ajax.runComponentAction(
					'itachsoft:notifications',
					'sendMessage',
					{
						mode: 'ajax',
						data: {
							TITLE: formdata.get('TITLE'),
							NOTIFICATION: formdata.get('NOTIFICATION'),
							USERS: users.user,
							GROUPS: users.group,
							DEPARTMENTS: users.department,
						},
					}
					).then(function (result) {
						return result.data;
					});
					var alertMessage = "<?php echo GetMessage('NOTIFICATION_SUCCESS'); ?>";
					if (re == 'INVALID_NOTIFICATION_USERS') {
						var alertMessage = "<?php echo GetMessage('INVALID_NOTIFICATION_USERS'); ?>";
					}
					if (re == 'INVALID_NOTIFICATION') {
						var alertMessage = "<?php echo GetMessage('INVALID_NOTIFICATION'); ?>";
					}
					if (re == 'INVALID_TITLE') {
						var alertMessage = "<?php echo GetMessage('INVALID_TITLE'); ?>";
					}
					$('#ItachSoftNotificationsButton').toggleClass('ui-btn-wait');
					BX.UI.Notification.Center.notify({
						content: alertMessage,
					});

				}
			});

		</script>
	<?php else: ?>
		<div class="ui-alert ui-alert-danger">
			<span class="ui-alert-message">
				<?php echo GetMessage('ACCESS_DENIED'); ?>
			</span>
		</div>
		<?php endif ?>