<?php 

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


// АВТОРИЗАЦИЯ

// Защита маршрутов 
// (в данном примере все неавторизованные пользователи с маршрута '/' будут переадресованы на маршрут /login/)
Route::match(['get','post'],'/', [OrderListController::class, 'orderList'])->middleware('auth');
Route::match(['get','post'],'/login/', [UserController::class, 'login'])->name('login');

// Текущий юзер
auth()->user();

// Авторизация
auth()->attempt([
 'email' => $request->email,
 'password' => $request->password,
]);

// Выход из аккаунта
auth()->logout();


?>