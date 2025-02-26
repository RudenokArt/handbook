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