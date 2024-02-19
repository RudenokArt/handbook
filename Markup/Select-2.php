<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<select data-node="custom_crm_selector" name="<?php echo $arParams['NAME'] ?>" class="w-100 h-100" required>
	<option value=""></option>
	<?php foreach ($arParams['DATA'] as $key => $value): ?>
		<option <?php if ($arParams['VALUE'] and $arParams['VALUE'] == $value['ID']): ?>
		selected
		<?php endif ?> value="<?php echo $value['ID'];?>">
		<?php echo $value['TITLE'];?>
	</option>
<?php endforeach ?>
</select>

<script>
	$(document).ready(function() {
		$('select[data-node="custom_crm_selector"').select2();
	});
</script>


<!-- MULTIPLE -->
<select id="SnAvailability_userSelect" name="SnAvailability_userSelect[]" multiple="multiple">
	<?php foreach ($arResult['usersList'] as $key => $value): ?>
		<option value="<?php echo $value['ID'] ?>">
			<?php echo $value['NAME']; ?>
			<?php echo $value['LAST_NAME']; ?>
			<?php echo $value['SECOND_NAME']; ?>
		</option>
	<?php endforeach ?>
</select>

<script>
	$(document).ready(function() {
		$('#SnAvailability_userSelect').select2({
			width: '100%',
			placeholder: "Select a user",
		});

		$('#SnAvailability_userSelect').change(function () {
			var arr = [];
			for (var i = 0; i < this.options.length; i++) {
				if (this.options[i].selected) {
					arr.push(this.options[i].value);
				}
			}
			SnAvailability.usersFilter = arr;
			console.log(arr);
		});
	});
</script>