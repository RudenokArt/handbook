<?php
// Генерация контроллера
// php artisan make:controller AboutController

// Роут для контроллера
// routes/web.php
Route::get('/news', [NewsController::class, 'getList']);

// Контроллер 
// app/Http/Controllers/NewsController.php
namespace App\Http\Controllers;
class NewsController extends Controller {
	public function getList () {
		return 'hello Word';
	}
}