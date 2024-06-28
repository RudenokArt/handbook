<!-- Кодировка в HTML -->
<meta charset="utf-8">
<?php
mb_internal_encoding('UTF-8');
echo 'моя первая программа';

// continue, break
$arr = [1, 2, 3, 4, 5, ];
foreach ($arr as $key => $value) {
  if ($value == 4) {
    break;
  } elseif ($value == 2) {
    continue;
  }
  echo $key.'-'.$value.PHP_EOL;
}

// Тернарный оператор
$var = ($argv[1] > 18) ? 'wellcome' : 'denied';
echo $var;

// Перенос строки:
echo $value.PHP_EOL;

// Мгновенная установка cookie
setcookie('test', 'test2');
$_COOKIE['test'] = 'test2';

// Установка cookie на час
setcookie('test', 'test2', time()+3600);
var_dump($_COOKIE);

// Мгновенное удаление cookie
setcookie('test', '', time());
unset($_COOKIE['test']);
var_dump($_COOKIE);

// Принудительное преобразование типа: 
$var = (string) true; // выведет "1" (строку)
// кодировка страницы
header('Content-type: text/html; charset=utf-8');

mb_internal_encoding('UTF-8');

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
$json = addslashes(
  json_encode(
    $arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
  )
);

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
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ123456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < 10; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}


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

// Рекурсивный перебор многомерного массива
var_dump(recursive($arr));
function recursive ($arr) {
  foreach ($arr as $key => $value) {
    if (is_array($value)) {
      recursive($value);
    } else {
      echo $value;
    }
  }
  return $arr;
}