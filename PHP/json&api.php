<?php
// Правильно отдать json (для api)
header('Content-Type: application/json');
echo $json;

// создать JSON
$json = addslashes(
  json_encode(
    $arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
  )
);
// Отловить ошибку JSON парсинга
switch (json_last_error()) {
  case JSON_ERROR_NONE:
  echo 'ошибок нет';
  break;
  case JSON_ERROR_DEPTH:
  echo 'достигнута максимальная глубина стека';
  break;
  case JSON_ERROR_STATE_MISMATCH:
  echo 'некорректные разряды или несоответствие режимов';
  break;
  case JSON_ERROR_CTRL_CHAR:
  echo 'некорректный управляющий символ';
  break;
  case JSON_ERROR_SYNTAX:
  echo 'синтаксическая ошибка, некорректный JSON';
  break;
  case JSON_ERROR_UTF8:
  echo 'некорректные символы UTF-8, возможно неверно закодирован';
  break;
  default:
  echo 'неизвестная ошибка';
  break;
}

// PHP-IMAP
// yum install php-imap - установка библиотеки
$mail_login    = "hotel@vetliva.com";
$mail_password = "eoe()^72ghc";
$mail_imap     = "{imap.yandex.ru:993/imap/ssl}";
$connection = imap_open($mail_imap, $mail_login, $mail_password);
$arr = imap_search($connection, 'SINCE "7 June 2022"');
foreach ($arr as $key => $value) {
  $arr[$key] = imap_headerinfo($connection, $value);
}
imap_close($connection);

// SOAP запрос
$client = new SoapClient('http://api-tt.belavia.by/TimeTable/Service.asmx?WSDL');
print_r($client->GetAirportsList()); 

// HTTP запрос через file_get_contents()
function restApiRequest () {
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
}

// Простой curl-парсер
function curlParser () { 
  $ch = curl_init('https://ya.ru');
  $html = curl_exec($ch);
  curl_close($ch); 
  return $html;
}

function cUrlGet () { // cUrl - запрос методом GET
  $url = 'https://pddimp.yandex.ru/api2/admin/email/list?domain=phpdev.org';
  $headers = ['PddToken: CRN2VNFX5ZZW4N75SO47VNVMND3LBIQKNLVYIINZL6RMVEYP6AMA'];
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_VERBOSE, 1);
  curl_setopt($curl, CURLOPT_POST, false);
  curl_setopt($curl, CURLOPT_URL, $url);
  return curl_exec($curl);
}

  // cUrl - запрос методом POST
  $url = "https://online.vetliva.ru/Vetliva/json_handler.ashx";
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $headers = array(
   "Accept: application/json",
   "Content-Type: text/plain",
 );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data = '{"method":"get_course","id":"1","params":{"date":"01.06.2022"}}';
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $resp = curl_exec($curl);
  curl_close($curl);
  var_dump($resp);

// Асинхронный СURL запрос (без ожидания ответа)
$url = "https://demo.doc-brown.de/local/test/";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 1);
$headers = array(
   "Accept: application/json",
   "Content-Type: application/json",
   "Content-Length: 0",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);