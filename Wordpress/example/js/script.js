jQuery(document).ready( function($){
	console.log('script.js');
	$.post('/wp-admin/admin-ajax.php', {
		action: 'testAjax',
		value: 'testValue',
	}, function (data) {
		console.log(data);
	});
});
