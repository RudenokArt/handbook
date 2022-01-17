<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <!-- <script src="https://unpkg.com/vue"></script> -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <title>Document</title>
</head>
<body>
  <?php 
  // Новости
  $url = 'http://lintest.fortest.org/local/php_interface/api/get-news.php';
  // Производители
  $url = 'http://lintest.fortest.org/local/php_interface/api/get-mfst.php';
  $postdata = http_build_query(['id' => '15']);
  // Удаление юзера
  $url = 'http://lintest.fortest.org/local/php_interface/api/user-delete.php';
  $postdata = http_build_query(['id' => '47']);
  // Получение рекламы
  $url = 'http://lintest.fortest.org/local/php_interface/api/get-ads.php';
  // Получение дистрибутива
  $url = 'http://lintest.fortest.org/local/php_interface/api/get-version.php';
  $postdata = http_build_query(['version' => '6']);
  // Добавление юзера
  $url = 'http://lintest.fortest.org/local/php_interface/api/user-add.php';
  $postdata = http_build_query([
    'name' => 'username',
    'email' => 'mail@mail.ru',
  ]);

  $opts = ['http' =>  [
    'method'  => 'POST',
    'header'  => 'Content-type: application/x-www-form-urlencoded',
    'content' => $postdata]
  ];
  $context  = stream_context_create($opts);

  $result = file_get_contents($url, false, $context);
  $apidata = json_decode($result);
  ?>
  <pre><?php print_r($apidata); ?></pre>
  <script src="js/main.js?<?php echo time();?>"></script>
</body>
</html>