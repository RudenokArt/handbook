<?php

// ===== Один к одному =====
use App\Models\Comment;
class Post extends Model
{
	use HasFactory;
	public function comment () {
		return $this->hasOne(Comment::class);
	}
}

$dbRes = Post::all();
foreach ($dbRes as $key => $value) {
	if ($value->comment) {
		$comment = $value->comment->text;
	} else {
		$comment = false;
	}
	$posts[] = [
		'id' => $value->id,
		'title' => $value->title,
		'text' => $value->text,
		'comment' => $comment,
	];
}

// ===== Обратная связь один к одному =====
use App\Models\Posts;
class Comment extends Model
{
	use HasFactory;
	public function post () {
		return $this->belongsTo(Post::class);
	}
}

$dbRes = Comment::all();
foreach ($dbRes as $key => $value) {
	if ($value->post) {
		$post = [
			'title' => $value->post->title,
			'text' => $value->post->text,
		];
	} else {
		$post = false;
	}
	$comments[] = [
		'id' => $value->id,
		'title' => $value->title,
		'text' => $value->text,
		'post' => $post,
	];
}

// ===== Один ко многим =====
use App\Models\Post;
class Category extends Model
{
	use HasFactory;
	protected $table = 'category';
	public function posts()
	{
		return $this->hasMany(Post::class);
	}
}
// Двухэтажный join (категории-посты-комменты) с селектом по постам
foreach ($dbRes as $key => $value) {
	$posts = false;
	if ($value->posts) {
		$dbPosts = $value->posts()->where('id', '>', 13)->get();
		foreach ($dbPosts as $postkey => $postvalue) {
			$comment = false;
			if ($postvalue->comment) {
				$comment = [
					'id' => $postvalue->comment->id,
					'text' => $postvalue->comment->text,
				];
			}
			$posts[] = [
				'id' => $postvalue->id,
				'title' => $postvalue->title,
				'text' => $postvalue->text,
				'comment' => $comment,
			];
		}
	}
	$categories[] = [
		'id' => $value->id,
		'name' => $value->name,
		'posts' => $posts,
	];
}


// Многие ко многим
use App\Models\Post;
class Tag extends Model
{
	use HasFactory;
	public function posts()
	{
		return $this->belongsToMany(Post::class);
	}
}
$dbRes = Tag::all();
foreach ($dbRes as $key => $value) {
	$tags[] = [
		'id' => $value->id,
		'name' => $value->name,
		'posts' => $value->posts,
	];
}

// ЖАДНАЯ ЗАГРУЗКА
$dbRes = Tag::where('id', '>', 0)->with(['posts'])->get();
// ЖАДНАЯ ЗАГРУЗКА множественных отношений
$dbRes = Post::with(['category', 'comment'])->get();

// ЖАДНАЯ ЗАГРУЗКА ПО УМОЛЧАНИЮ В МОДЕЛИ
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Category;
class Post extends Model
{
    protected $with = ['comment'];
    use HasFactory;
    public function comment () {
        return $this->hasOne(Comment::class);
    }
    public function category () {
        return $this->belongsTo(Category::class);
    }
}