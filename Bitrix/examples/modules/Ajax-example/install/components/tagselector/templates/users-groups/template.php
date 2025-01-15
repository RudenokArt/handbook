<?php if ($arParams['JS_VAR']): ?>
	<?php $uniqueVarPrefix = time(); ?>
	<div id="tagSelector-<?php echo $uniqueVarPrefix; ?>"></div>
	<script>
			var <?php echo $arParams['JS_VAR']; ?> = new BX.UI.EntitySelector.TagSelector({
				dialogOptions: {
					items: JSON.parse('<?php echo $arResult['groups'] ?>'),
					tabs: [
						{ id: 'groups', title: '<?php echo GetMessage('USERS_GROUPS') ?>' }
					],
					entities: [
						{
							id: 'user',
						},
						{
							id: 'department',
							options: {
								selectMode: 'usersAndDepartments',
							},
						},
					],
				}
			});
			<?php echo $arParams['JS_VAR']; ?>.renderTo(document.getElementById('tagSelector-<?php echo $uniqueVarPrefix;?>'));
	</script>
<?php else: ?>
	<div class="ui-alert ui-alert-danger">
		<span class="ui-alert-message">
			Parameter "JS_VAR" - required!
		</span>
	</div>
<?php endif ?>
