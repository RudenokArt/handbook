<?php
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
