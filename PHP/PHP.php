<?php
// кодировка страницы
header('Content-type: text/html; charset=utf-8');

// Разрешить кроссдоменный запрос
header('Access-Control-Allow-Origin:*');

// Показ ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// редирект
header('Location: ?page_number='.$_GET['page_number']);
echo '<meta http-equiv="refresh" content="2; url=index.php" />';
echo '<script>setTimeout(function(){document.location.href="index.php";},2000);</script>';

// JSON
$json=json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

// перенос строки в txt
PHP_EOL.date('H:i:s-d.m.Y');

// image to base64
$base64imageTinkoffLogo = base64_encode(file_get_contents(__DIR__.'/img/tink-logo.jpg'));
$TinkoffLogoimageSize = getimagesize(__DIR__.'/img/tink-logo.jpg');
$TinkoffLogoimageData = base64_encode(file_get_contents(__DIR__.'/img/tink-logo.jpg'));
$TinkoffLogoimageHTML = "<img width='250' src='data:{$TinkoffLogoimageSize['mime']};base64,{$TinkoffLogoimageData}'/>";

// найти путь к файлу по названию класса
$reflector = new \ReflectionClass(\travelsoft\booking\Utils::class);
$filename = $reflector->getFileName();
// найти путь к файлу по названию функции
$test = new ReflectionFunction('includeFileModifier');
print_r($test->getFileName());


// ГЕНЕРАТОР ПАРОЛЕЙ
function passwordGenerator(){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < 10; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}

  // PHPMailer
  // composer require phpmailer/phpmailer - установка


  // MySQL

$host = 'localhost';
$log = 'root';
$pas = 'root';
$db = 'php_test';
$link = mysqli_connect($host, $log, $pas, $db);
$arr = mysqli_query($link,'SELECT * FROM `pages` ');
while ($row = mysqli_fetch_assoc($arr)) {
  print_r($row);
}

