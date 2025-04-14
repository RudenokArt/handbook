<?php

// Один к одному
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