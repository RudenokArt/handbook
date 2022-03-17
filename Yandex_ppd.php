<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

  <?php 
  function cUrlGetList () { // получить список ящиков
    $url = 'https://pddimp.yandex.ru/api2/admin/email/list?domain=phpdev.org&on_page=200';
    $headers = ['PddToken: CRN2VNFX5ZZW4N75SO47VNVMND3LBIQKNLVYIINZL6RMVEYP6AMA'];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    return curl_exec($curl);
  }

  function post_delete () { // удалить почтовый ящик
    $url = 'https://pddimp.yandex.ru/api2/admin/email/del';
    $postdata = http_build_query([
      'domain' => 'phpdev.org',
      'uid' => '1130000057535569',
    ]);
    $opts = [
      'http' =>  [
        'method'  => 'POST',
        'header'  => 'PddToken: CRN2VNFX5ZZW4N75SO47VNVMND3LBIQKNLVYIINZL6RMVEYP6AMA',
        'content' => $postdata
      ]
    ];
    $context  = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    return json_decode($result);
  }

  function post_add () { // добавить почтовый ящик
    $url = 'https://pddimp.yandex.ru/api2/admin/email/add';
    $postdata = http_build_query([
      'domain' => 'phpdev.org',
      'login' => 'newlogin',
      'password' => 'asdaeefse45',
    ]);
    $opts = [
      'http' =>  [
        'method'  => 'POST',
        'header'  => 'PddToken: CRN2VNFX5ZZW4N75SO47VNVMND3LBIQKNLVYIINZL6RMVEYP6AMA',
        'content' => $postdata
      ]
    ];
    $context  = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    return json_decode($result);
  }
  ?>
  <hr>
  <pre><?php // print_r(post_add());?></pre>
  <pre><?php //print_r(post_delete());?></pre>
  <hr>
  <pre><?php print_r(json_decode(cUrlGetList($get_list),true)); ?></pre>
  
</body>
</html>