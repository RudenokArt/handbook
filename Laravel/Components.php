{{-- Создание компонента с классом из консоли --}}
php artisan make:component Banner

<!-- \resources\views\components\layout.blade.php -->
<x-footer/>
<!-- resources\views\components\footer.blade.php -->
<footer class="container">&#169 copyright</footer>

<!-- \resources\views\components\layout.blade.php -->
<x-header.menu/>
<!-- resources\views\components\header\menu.blade.php -->
<button class="btn">&#8801</button>

<!-- Слоты компонентов позволяют передавать значение в компонент -->
<!-- resources\views\about\company.blade.php на странице-->
<x-banner>advertisement</x-banner>
<!-- \resources\views\components\banner.blade.php (в компоненте)-->
<div class="alert alert-primary">{{$slot}}</div>

<!-- Дополнительный именованный слот -->
<!-- resources\views\about\company.blade.php на странице-->
<div class="alert alert-primary">{{$adv}}</div>
<!-- \resources\views\components\banner.blade.php (в компоненте)-->
<x-banner>
	<x-slot:adv>
		advertisement
	</x-slot>
</x-banner>

Передача данных из класса компонента в представление:
<div>{{$text}}</div> в представлении
<?php // в Классе:
	// public function render(): View|Closure|string{
		return view('components.banner', [
			'text' => 'some text',
		]);
	// }
?>