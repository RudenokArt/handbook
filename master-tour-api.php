<?php 
$vetliva_order_list = new MasterTourApi_OrderList();
$arResult['LIST'] = $vetliva_order_list->order_list['result']['List'];

/**
 * 
 */
class MasterTourApi_OrderList {

  function __construct()  {
    if (isset($_GET['PAGEN_1'])) {
      $this->pageN = $_GET['PAGEN_1'];
    } else {
      $this->pageN = 1;
    }
    if (isset($_GET['search']['turist']) and !empty($_GET['search']['turist'])) {
      $this->filter = '{"turist":"'.$_GET['search']['turist'].'"}';
    } else {
      $this->filter = 'null';
    }

    if (isset($_GET['sort']['status'])) {
      $this->sort = '{"status":"'.$_GET['sort']['status'].'"}';
    }  elseif (isset($_GET['sort']['tourdate'])) {
      $this->sort = '{"tourdate":"'.$_GET['sort']['tourdate'].'"}';
    } else {
      $this->sort = '{"createdate":"desc"}';
    }

    $this->token = $_SESSION["__TRAVELSOFT"]["TOKEN"];
    $this->url = \Bitrix\Main\Config\Option::get("travelsoft.booking.dev.tools", "tsmo_url");
    $this->order_list = $this->RestApiRequest(); 
    $this->nav_string = $this->getNavString();
    $this->pagination_query_string = $this->getPaginationQueryString();
    $this->sorting_query_string = $this->getSortingQueryString();
  }

  function getSortingQueryString () {
    $arr = $_GET;
    unset($arr['sort']);
    unset($arr['filter']);
    return http_build_query($arr);
  }

  function getPaginationQueryString () {
    $arr = $_GET;
    unset($arr['PAGEN_1']);
    unset($arr['filter']);
    return http_build_query($arr);
  }

  function getNavString () {
    $arr = [];
    for ($i=1; $i <= $this->order_list['result']['pageCount']; $i++) { 
      $arr[$i] = $i;
    }
    return $arr;
  }

  function RestApiRequest () {
    $url = $this->url;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
     "Accept: application/json",
     "Content-Type: text/plain",
   );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $data = '{"id":1, "method":"get_dogovors_by_user", 
    "params":{
      "token" : "'.$this->token.'",
      "paging" : {"page":"'.$this->pageN.'", "size":"10"},
      "filter" : '.$this->filter.',
      "sort" : '.$this->sort.',
      "setting" : null
    }}';
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($curl);
    curl_close($curl);
    return json_decode($resp, true);

  }
}

/**
 * 
 */
class MasterRestApi {

  function __construct($method, $params) {
    $this->method = $method;
    $this->params = json_encode($params);
    $this->serverResponse = $this->getServerResponse();
    $this->token = $this->getUserToken();
  }

  function getUserToken () {
    if ($this->serverResponse['token']) {
      $_SESSION['MT_user_token'] = $this->serverResponse['token'];
    }
    return $_SESSION['MT_user_token'];
  }

  function getServerResponse () {
    if (!isset($this->method) or !isset($this->params) or empty($this->method) or empty($this->params) ) {
      return [];
    }
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
    $data = '{"id":'.time().', "method":"'.$this->method.'", "params":'.$this->params.'}';
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($curl);
    curl_close($curl);
    return json_decode($resp, true)['result'];
  }

}

?>

<pre>
  <?php
  // получить токен
  // print_r((new MasterRestApi('Connect', [
  //   'login' => 'dima.antonovich.1999@gmail.com',
  //   'password' => 'w7L9eAH0',
  // ]))->serverResponse); 

  // print_r((new MasterRestApi('get_course', [
  //   'date' => '01.07.2022',
  // ]))->serverResponse); 

  print_r((new MasterRestApi('get_dogovors_by_user', [
    'token' => $_SESSION['MT_user_token'],
  ]))->serverResponse); 

  ?>
</pre>

<hr>

<pre><?php print_r($_SESSION['MT_user_token']); ?></pre>