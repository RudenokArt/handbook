<?php
// кодировка страницы
header('Content-type: text/html; charset=utf-8');

// Показ ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// найти путь к файлу по названию класса
$reflector = new \ReflectionClass(\travelsoft\booking\Utils::class);
$filename = $reflector->getFileName();

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

// редирект
header('Location: ?page_number='.$_GET['page_number']);
echo '<meta http-equiv="refresh" content="2; url=index.php" />';
echo '<script>setTimeout(function(){document.location.href="index.php";},2000);</script>';

// JSON
$json=json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

// Разрешить кроссдоменный запрос
header('Access-Control-Allow-Origin:*');

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

function cUrlPost () { // cUrl - запрос методом POST
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
}


// Простая пагинация: на входе массив статей и количетво на странице
// на выходе - массив статей на странице и постраничное меню
function pagination ($arr, $page_size) {
 $current_page = 1;
 if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
}
$last_item = $current_page*$page_size-1;
$first_item = $last_item - $page_size+1;
$page = [];
for ($i=$first_item; $i <= $last_item ; $i++) { 
  array_push($page, $arr[$i]);
}
$nav = [];
for ($i=0; $i < count($arr)/$page_size; $i++) { 
  $n = $i+1;
  $page_nuber = $n;
  $page_link = '?page='.$n;
  array_push($nav, ['page_nuber' => $page_nuber, 'page_link' => $page_link]);
}
return ['page'=>$page, 'nav'=>$nav];
}

function date_interval () { // выбор интервала дат
  if (isset($_POST['filter'])) {
    if ($_POST['date_filter']=='month') {
      $interval = [
        strtotime(date('Y-m-01')),
        strtotime(date('Y-m-t')), 
      ];
    }
    if ($_POST['date_filter']=='prev_month') {
      $interval = [
        strtotime(date('Y-m-01', strtotime('-1 month'))),
        strtotime(date('Y-m-t', strtotime('-1 month'))),
      ];
    }
    if ($_POST['date_filter']=='week') {
      $interval = [strtotime('last monday'), strtotime('next monday')];
    }
    if ($_POST['date_filter']=='prev_week') {
      $interval = [strtotime('last monday -1 week'), strtotime('next monday -1 week')];
    }
    if ($_POST['date_filter']=='interval') {
      $interval = [strtotime($_POST['date_for']), strtotime($_POST['date_to'])];
    }
  }
  return $interval;
}

?>

<!-- Простой календарь на PHP -->
<a href="?year=<?php echo prevMon()['year'];?>&mon=<?php echo prevMon()['mon'];?>">previous</a>
<a href="?year=<?php echo nextMonth()['year'];?>&mon=<?php echo nextMonth()['mon'];?>">next</a>
<pre><?php print_r(getCurrentMonth()) ?></pre>
<?php 
function nextMonth () {
  $year = getCurrentMonth()[0]['year'];
  $mon = getCurrentMonth()[0]['mon'] + 1;
  if ($mon>12) {
    $mon = 1;
    $year = $year + 1;
  }
  return ['mon'=>$mon, 'year'=>$year];
}
function prevMon () {
  $year = getCurrentMonth()[0]['year'];
  $mon = getCurrentMonth()[0]['mon'] - 1;
  if ($mon < 1) {
    $mon = 12;
    $year = $year - 1;
  }
  return ['mon'=>$mon, 'year'=>$year];
}
function getCurrentMonth() {
  $current_date = getdate();
  $mon = $current_date['mon'];
  if (isset($_GET['mon'])) {
    $mon = $_GET['mon'];
  }
  $year = $current_date['year'];
  if (isset($_GET['year'])) {
    $year = $_GET['year'];
  }
  $last_day_month = getdate(strtotime(date($year.'-'.$mon.'-'.cal_days_in_month(CAL_GREGORIAN, $mon, $year))));
  $arr = [];
  for ($i=1; $i <= $last_day_month['mday']; $i++) { 
    array_push($arr, getdate(strtotime(date($year.'-'.$mon.'-'.$i))));
  }
  return $arr;
}
?>

