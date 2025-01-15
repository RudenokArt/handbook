BX.ready(function(){
  BX.ajax.runAction('itachsoft:notifications.rest.api.notificationremind', {
    data: {
      folderId: 1 
    },
    analyticsLabel: {
      viewMode: 'grid',
      filterState: 'closed' 
    }
  }).then(function (response) {
    var arr = response.data;
    for (var i = 0; i < arr.length; i++) {
      if (arr[i].MESSAGE_UNREAD) {
        BX.UI.Notification.Center.notify({
          content: '<b>'+arr[i].TITLE+'</b><br>'+arr[i].NOTIFICATION
        });
      }
    }
    console.log(arr);
  }, function (response) {
    console.log(response); 
  });
});
