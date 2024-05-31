<?php

// Парсинг и вывод на страницу
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://ya.ru');
curl_exec($curl);

// Парсинг и запись в переменную
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://ya.ru');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$re = curl_exec($curl);
print_r(strip_tags($re));

// Обработка ошибок
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://code.mu');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$re = curl_exec($curl);
if ($re) {
	print_r(strip_tags($re));
} else {
	echo curl_error($curl);
}

// Парсинг с обработкой ошибок и с переходом по редиректам
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);


// POST параметры запроса
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'fortest/test.php');
curl_setopt($curl, CURLOPT_POST, 1);
$data = ['name1'=>'value1', 'name2'=>'value2'];
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$re = curl_exec($curl);
if ($re) {
	print_r(json_decode($re, true));
} else {
	echo curl_error($curl);
}

// Отключить проверку SSL
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);