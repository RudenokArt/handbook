<?php


// Получить данные формы
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class FeedbackController extends Controller
{
	public function getFormData (Request $request) {
		dump($request->input('message'));
		return view('about.feedback', []);
	}
}
// Если роут с параметром, то принять его можно после $request: 
public function getFormData (Request $request, $id){}

// Получить данные формы в види массива:
dump($request->all());
// Получить выбранные поля
dump($request->only(['message', '_token']));
// Исключить выбранные поля
dump($request->except(['_token']));
//Получение сложных полей (типа name="message[text]")
dump($request->input('message.text'));

// Получить метод запроса
dump($request->method());
// проверка метода запроса
dump($request->isMethod('post'));
// uri запроса (без домена)
dump($request->path());
// url запроса без GET-параметров
dump($request->url());
// Полный запроса url с GET-параметрами
dump($request->fullUrl());
// Проверка url запроса на соответствие маске
dump($request->is('*feedback*'));

// Для для получения данных формы (method="post") - роут должен быть определён методом post :
Route::post('/about/feedback', [FeedbackController::class, 'getFormData']);
// Для того чтобы разместить форму (method="post") 
// и обработчик одновременно - роут должен быть определен методом match :
Route::match(['get', 'post'], '/about/feedback', [FeedbackController::class, 'getFormData']);
// А форма должна содержать токен @csrf:
// <form action="" method="post" ...
// @csrf
