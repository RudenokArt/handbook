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

// Получение коллекции значений столбца
$posts = DB::table('posts')->where('id', '>', 2)->pluck('title');

// whereBetween 
$posts = DB::table('posts')->whereBetween('id', [1, 4])->get();
// whereNotBetween
$posts = DB::table('posts')->whereNotBetween('id', [3, 4])->get();

// whereIn
$posts = DB::table('posts')->whereIn('id', [3, 4, 5, ])->get();
// whereNotIn
$posts = DB::table('posts')->whereNotIn('id', [3, 4, 5, 6, ])->get();

// whereNull
$posts = DB::table('posts')->whereNull('id')->get();
// whereNotNull
$posts = DB::table('posts')->whereNotNull('id')->get();

// Динамическое условие
$posts = DB::table('posts')->whereId(5)->get();
$posts = DB::table('posts')->whereTitle('title 1')->get();

// Комбинация динамических условия (and, or)
$posts = DB::table('posts')->whereIdAndTitle(3, 'title 1')->get();
$posts = DB::table('posts')->whereIdOrTitle(1, 'title 1')->get();

// Сортировка
$posts = DB::table('posts')->orderBy('id', 'desc')->get();
// По дате (created_by) по возрастанию
$posts = DB::table('posts')->oldest()->get();
// По дате (created_by) по убыванию
$posts = DB::table('posts')->latest()->get();
// По дате (date) по возрастанию
$posts = DB::table('posts')->oldest('date')->get();
// сортировка в случайном порядке
$posts = DB::table('posts')->inRandomOrder()->get();
$posts = DB::table('posts')->inRandomOrder()->first();

// Количество записей (limit)
$posts = DB::table('posts')->take(5)->get();

// limit & offset - количество записей со сдвигом
$posts = DB::table('posts')->skip(2)->take(3)->get();

// Вставка данных
$posts = DB::table('posts')->insert([
	'title' => 'any title',
	'text' => 'any text',
	'created_by_id' => 1,
]);
// Вставить запись и получить id
$id = DB::table('posts')->insertGetId([
	'title' => 'any title',
	'text' => 'any text',
	'created_by_id' => 1,
]);
// Массовая вставка
DB::table('posts')->insert([
	'title' => 'any title1',
	'text' => 'any text',
	'created_by_id' => 1,
], [
	'title' => 'any title2',
	'text' => 'any text',
	'created_by_id' => 1,
]);

// UPDATE
DB::table('posts')->where('id', 3)->update([
	'title' => 'title-3',
]);
// Обновить несколько записей
DB::table('posts')->where('id', '>', 3)->update([
	'title' => 'title->3',
]);
// Обновить все записи
DB::table('posts')->update([
	'title' => 'title->3',
]);

// Инкремент и декремент данных
DB::table('posts')->where('id', 1)->increment('likes', 5);
DB::table('posts')->where('id', 1)->decrement('likes', 3);

// Удаление записи
DB::table('posts')->where('id', 1)->delete();
// Удаление записей
DB::table('posts')->where('id', '<', 5)->delete();
// Очистка таблицы
DB::table('posts')->delete();

// JOIN
$posts = DB::table('posts')
->leftJoin('users', 'posts.created_by_id', '=', 'users.id')
->get();