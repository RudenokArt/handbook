<?php 

// Простой роут
Route::get('/about/', function () {
    return 'about';
});
// Роут с параметрами
Route::get('/news/{p1}/{p2}', function ($p1, $p2) {
    return 'news-'.$p1.'|'.$p2;
});

// Роут с необязательным параметром
Route::get('/news/{p1?}/{p2?}', function ($p1=false, $p2=false) {
    return dump([$p1, $p2]);
});
// Ограничение параметров роутов регулярками
Route::get('/news/{p1}/', function ($p1) {
    return dump($p1);
})->where('p1', '[0-9]+');

// Шаблонные ограничения параметров роутов числа/буквы/буквочисла
Route::get('/news/{p1}/{p2}/{p3}', function ($p1, $p2, $p3) {
    return dump([$p1, $p2, $p3]);
})->whereNumber('p1')->whereAlpha('p2')->whereAlphaNumeric('p3');

// Глобальное ограничение параметра роутов (для всех одноименных параметров в одноименных маршрутах)
// App\Providers\RouteServiceProvider.php - добавить в метод boot()
Route::pattern('id', '[0-9]+');
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

// Группировка маршрутов 
// http://laravel-dev/public/news/detail/1/
// http://laravel-dev/public/news/list
Route::prefix('news')->group(function () {
    Route::get('/list/', function () {
        return 'all';
    });
    Route::get('/detail/{id}', function ($id) {
        return $id;
    });
});

// Именованный маршрут
Route::get('/news/{id}', function ($id) {
    return Route::currentRouteName();
})->name('news');

// Получение текущешго роута
$route = Route::current()->getName();
$name = Route::currentRouteName(); 
$action = Route::currentRouteAction();

?>