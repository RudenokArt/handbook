<?php 
// Запуск сервера
// php artisan serve

// PHPMailer
// composer require phpmailer/phpmailer - установка
use PHPMailer\PHPMailer\PHPMailer; // Подключение

// Генерация пароля
use Illuminate\Support\Str;
$new_password = Str::random(8);
dump($new_password);


// ХРАНЕНИЕ КОНСТАНТ
// в хранилище - config/constants.php
return [
 'order_statuses' => [
  'opet' => 'открыт',
  'booked' => 'забронирован',
  'in_work' => 'в работе',
  'completed' => 'выполнен',
],
];
// в шаблоне или контроллере:
print_r(Config::get('constants.user_roles'));


