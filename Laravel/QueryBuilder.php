<?php

// Запрос в контроллере
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
class NewsController extends Controller
{
	public function getList () {
		return view('news.list', [
			'list' => DB::table('posts')->get(),
		]);
	}
}

// ====== Просмотр SQL запросов =====
// Через QueryLog
DB::enableQueryLog();
$posts = DB::table('posts')->get();
dump(DB::getQueryLog());
// Через toSql()
$posts = DB::table('posts')->where('id', '>', 1);
dump($posts->toSql());
// Через dump() или dd()
$posts = DB::table('posts')->where('id', '>', 1);
$posts->dump();

// Поля выборки через QB в Laravel
$posts = DB::table('posts')->select('title', 'text')->get();

// Переименование столбцов при выборке
$posts = DB::table('posts')->select('title', 'text as detailText')->get();

// Условия where при выборке через QB (=, <, >, ,!=)
$posts = DB::table('posts')->select('title')->where('id', '>', 1)->get();

// Логическое AND
$posts = DB::table('posts')->select('id', 'title')
->where('id', '<', 8)->where('id', '>', 1)->get();

// Логическое ИЛИ
$posts = DB::table('posts')->select('id', 'title')
->where('id', '=', 8)->orWhere('id', '=', 1)->get();

// Сложное условие
$posts = DB::table('posts')->select('id', 'title')
->where('id', '=', 8)->orWhere(function($query){
	$query->where('id', '<', 3)->where('id', '>', 1);
})->get();

// Получение одной строки
$posts = DB::table('posts')->where('id', '>', 2)->first();

// Получение одного столбца в одной колонке
$posts = DB::table('posts')->where('id', 2)->value('title');