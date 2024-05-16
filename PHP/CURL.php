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
