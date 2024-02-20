<?php

// Конвертировать UNIX из чч, мм, сс, дд, ММ, гггг
echo mktime(12, 00, 00, 01, 01, 2024);

// Конвертировать UNIX в строку
echo date('Y-m-d H:i:s');
echo date('Y-m-d H:i:s', time());

// Конвертировать строку в UNIX
echo strtotime('2024-02-20 09:33:40');

// Создать объект DateTime
print_r(date_create());

// Добавление и отнимание времени от объекта DateTime
$dateTime = date_create();
$dateTime = date_modify($dateTime, '-1 year');
print_r($dateTime);

// Дата по указанному формату из объекта DateTime
$dateTime = date_create();
$dateTime = date_format($dateTime, 'Y/m/d-H:i:s');
print_r($dateTime);