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