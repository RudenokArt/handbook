<?php 

// Простой роут
Route::get('/about/', function () {
    return 'about';
});
// Роут с параметрами
Route::get('/news/{p1}/{p2}', function ($p1, $p2) {
    return 'news-'.$p1.'|'.$p2;
});

// Получение текущешго роута
$route = Route::current()->getName();
$name = Route::currentRouteName(); 
$action = Route::currentRouteAction();

?>