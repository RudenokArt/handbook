<?php 

function curlParser () { // Простой curl-парсер
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