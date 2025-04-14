<?php

// Создание модели для таблицы posts:
// php artisan make:model Post

// Подключение модели в котроллере
use App\Models\Post;

// Получение записей:
$dbRes = Post::all();
foreach ($dbRes as $key => $value) {
	$posts[] = [
		'id' => $value->id,
		'title' => $value->title,
		'text' => $value->text,
	];
}

// ===== QUERY BUILDER в моделях =====
$dbRes = Post::where('id', '>', 10)->get();
$posts[] = [
	'id' => $value->id,
	'title' => $value->title,
	'text' => $value->text,
];
// получение одной записи
$dbRes = Post::where('id', '>', 10)->first();
$post = [
	'id' => $dbRes->id,
	'title' => $dbRes->title,
	'text' => $dbRes->text,
];
// Получение записей по id
$dbRes = Post::find([11, 12, 13]);
$dbRes = Post::find(10)->first();

// Добавление записи
$post = new Post;
$post->title = 'newtitle';
$post->text = 'newtext';
$post->save();

// Изменение записи
$post = Post::find(10);
$post->title = 'anyTitle10';
$post->save();

// Удаление записи
$post = Post::find(5);
$post->delete();
// или
$post = Post::destroy(11);


// Групповое удаление
$post = Post::where('id', '<', 10)->delete();
// или
$post = Post::destroy(11, 12, 13);
// или
$post = Post::destroy([11, 12, 13]);

