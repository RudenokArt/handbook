<?php
// Генерация контроллера
// php artisan make:controller AboutController

// Роут для контроллера: routes/web.php
Route::get('/news', [NewsController::class, 'getList']);
// Контроллер: app/Http/Controllers/NewsController.php
namespace App\Http\Controllers;
class NewsController extends Controller {
	public function getList () {
		return 'hello Word';
	}
}

// Роут c параметром для контроллера: routes/web.php
Route::get('/news/{id}', [NewsController::class, 'detail']);
// Контроллер: app/Http/Controllers/NewsController.php
public function detail ($id) {
	return 'Article # '.$id;
}

// Вывод представления(view) в контроллере
// resources/views/news/list.blade.php
public function getList () {
	return view('news.list');
}

// Передача данных из контроллера в представление
public function detail ($id) {
	return view('news.detail', ['id' => $id]);
}