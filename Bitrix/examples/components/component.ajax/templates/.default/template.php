<?php
$APPLICATION->ShowHead();
print_r($arResult);
?>

<script>
	testAjaxRequest();
	async function testAjaxRequest () {
		var res = await BX.ajax.runComponentAction(
			'docbrown:example-ajax',
			'testAjax',
			{
				mode: 'ajax',
				data: {},
			}
			).then(function (result) {
				return result.data;
			});
			console.log(res);
		}

	</script>