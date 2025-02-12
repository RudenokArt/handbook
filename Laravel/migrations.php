
<?php 
// Создание файла миграции:
// php artisan make:migration create_posts_table

// Добавление столбцов в таблицу
// php artisan make:migration add_column_to_posts --table=posts
$table->integer('priview');

// <Удаление столбцов
$table->dropColumn('priview');

// ИЗМЕНЕНИЯ СТОЛБЦОВ ТАБЛИЦ
// Установить пакет (без него не работает)
// composer require doctrine/dbal
// Создать миграцию
// php artisan make:migration change_posts_table --table=posts
// Описать изменения в миграции
Schema::table('posts', function (Blueprint $table) {
	$table->string('title', 500)->change();
});
// Если необходимо менять timestamp добавить в config/database.php:
use Illuminate\Database\DBAL\TimestampType;
'dbal' => [
	'types' => [
		'timestamp' => TimestampType::class,
	],
],

// Переименование столбца
Schema::table('posts', function (Blueprint $table) {
	$table->renameColumn('created_by', 'created_by_id');
});

// Значение по умолчанию
Schema::create('posts', function (Blueprint $table) {
	$table->string('desc')->default('some value');
});

// Удаление таблицы
Schema::table('posts', function (Blueprint $table) {
  // Schema::drop('posts');
	Schema::dropIfExists('posts');
});

// Переименование таблицы
Schema::table('posts', function (Blueprint $table) {
	Schema::rename('posts', 'articles');
});