<!-- ===== ШАБЛОН САЙТА ===== -->
<!-- resoures/views/components/layout.blade.php -->
<title>{{$title}}</title>
</head>
<body class="bg-secondary text-white">
	<div class="container">
		{{$slot}}
	</div>	
</body>
<!-- Представление  -->
<!-- resoures/views/news/list.blade.php -->
<x-layout>
	<x-slot:title>news-title</x-slot:title>
	news page layout
</x-layout>

{{-- Вывод переменных, атрибутов и произвольного кода --}}
<x-layout>
	<x-slot:title>news-title</x-slot:title>
	<h4 style="color:{{$textColor}}">{{$text}}</h4>
	{{time();}}
</x-layout>

{{-- Вывод неэкранированных данных содержащих html тэги --}}
{!!$text!!}

{{-- Блок php кода --}}
@php
echo 'php block'
@endphp

{{-- ===== УСЛОИВИЯ ===== --}}

@if ($text)
{{$text}}
@elseif($text != null)
empty
@else
no data
@endif

{{-- Unless аналогично if(!) --}}
@unless ($text)
empty
@endunless

{{-- ===== ЦИКЛЫ ===== --}}

@for ($i = 0; $i < 10; $i++)
<p>значение счетчика: {{ $i }}</p>
@endfor

@foreach ($arr as $key => $value)
<p>{{$key}} - {{$value}}</p>
@endforeach

{{-- @forelse работает образом: если в массиве есть элементы,
то цикл их переберет, а если элементов нет,
то выведет сообщение из блока @empty --}}
@forelse ($arr as $key => $value)
<p>{{$key}} - {{$value}}</p>
@empty
empty arr
@endforelse

{{-- При переборе массива с помощью foreach
внутри цикла доступна специальная переменная $loop --}}
@foreach ($arr as $key => $value)
<ul>
	<li>{{$key}} - {{$value}}</li>
	<li>{{$loop->first}} - Первая итерация</li>
	<li>{{$loop->last}} - Последняя итерация</li>
	<li>{{$loop->odd}} - Четная итерация</li>
	<li>{{$loop->even}} - Нечетная итерация</li>
	<li>{{$loop->index}} - Индекс итерации</li>
	<li>{{$loop->iteration}} - Номер итерации (нач. с 1)</li>
	<li>{{$loop->remaining}} - Итераций осталось</li>
	<li>{{$loop->count}} - Кол-во элементов массива</li>
</ul>
@endforeach

{{-- Завершение работы цикла с помощью директивы @break --}}
@foreach ($arr as $key => $value)
<p>{{$key}} - {{$value}}</p>
@if($loop->iteration == 2)
@break
@endif
@endforeach

{{-- Переход к следующей итерации цикла с помощью директивы @continue --}}
@foreach ($arr as $key => $value)
@if($loop->iteration == 2)
@continue
@endif
<p>{{$key}} - {{$value}}</p>
@endforeach