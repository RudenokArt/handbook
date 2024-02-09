// Битриксовый алерт
BX.UI.Dialogs.MessageBox.alert('Access denied!');

// Принять пулл 
BX.ready(function(){
	BX.addCustomEvent("onPullEvent", function(module_id, command, params) {
		console.log(module_id, command, params);
	});
	BX.PULL.extendWatch('PULL_TEST');
});


// !!!!!!! подключить библиотеку рабоыты со слайдером (в слайдере например)
// CJSCore::Init(['sidepanel']);

// Открыть слайдер
BX.SidePanel.Instance.open('add_faq_form.php?update='+item_id, {
	allowChangeHistory: false,
});
// Перезагрузить слайдер
BX.SidePanel.Instance.reload(); 