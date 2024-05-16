<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<select name="" id="productSelector" class="w-100"></select>

<script>

	$(document).ready(function () {

		$('body').delegate('input[aria-controls="select2-productSelector-results"]', 'input', function () {
			productSelectorRendering(this.value);
		});


		var productSelector = $('#productSelector');
		productSelector.select2();
		productSelectorRendering();


		async function productSelectorRendering (ELEMENT_NAME='') {
			$(productSelector).html('');
			var list = await BX.ajax.runComponentAction(
				'docbrown:plants.deal_tab',
				'getProductsList',
				{
					mode: 'ajax',
					data: {
						'ELEMENT_NAME': ELEMENT_NAME,
					},
				}
				).then(function (result) {
					return result.data;
				});
				if (list) {
					for (var i = 0; i < list.length; i++) {
						var option = $('<option>').html(list[i].ELEMENT_NAME).attr('value', list[i].ID);
						$(productSelector).append(option);
					}
				}
			}

		});
	</script>