<script src="//api.bitrix24.com/api/v1/"></script> подключить BX24
<script>

    $(function(){ // создать пользовательское поле
      BX24.callMethod('userfieldtype.add', {
        USER_TYPE_ID: 'test',
        HANDLER: 'https://b24.phpdev.org/test/b24uf.php',
        TITLE: 'Test type',
        DESCRIPTION: 'Test userfield type for documentation'
      });

      $('#slider-show').click(function () { 
        BX24.openApplication({ // Открыть серверное приложение в слайдере
          'opened': true,
        },
        function() {
          console.log('Application closed!');
        });
      });

      $('#slider-show').click(function () {
        BX24.init( // Открыть страницу в слайдере
          function() {
            BX24.openPath(
              '/crm/deal/details/5/',
              function(result) {
                console.log(result);
              });
          });
      });

    });
  </script>