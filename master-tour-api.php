<?php 
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