<?php
// Простая замена
echo preg_replace('#a#', 'x', 'ababababa');
// . (точка) - любой символ 
// для кирилицы - две точки
echo preg_replace('#b.b#', 'x', 'ababababa');
// Любая цифра \d
echo preg_replace('#\d#', 'x', 'a1b2c3e4');
// Любая НЕ цифра \D
echo preg_replace('#\D#', 'x', 'a1b2c3e4');
// Любая цифра, латинская буква или знак подчеркивания
echo preg_replace('#\w#', 'x', 'a1_b2-c3_e4');
// Любвая НЕ цифра, НЕ латинская буква, НЕ знак подчеркивания
echo preg_replace('#\W#', 'x', 'a1_b2-c3_e4');
// Пробел, перевод строки, табуляция \s
echo preg_replace('#\s#', 'x', 'a1 b2	c3e4');
// НЕ пробел, НЕ перевод строки, НЕ табуляция \S
echo preg_replace('#\S#', 'x', 'a1 b2	c3e4');
// Наборы [] символов. ИЛИ (b или c или d)
echo preg_replace('#a[bcd]#', 'x', 'abacadae');
// Группы символов внутри наборов []
echo preg_replace('#a[bcd\d]#', 'x', 'abacadaea5');
// Группа сиволов от b до d
echo preg_replace('#a[b-d]#', 'x', 'abacadae');
// Инверсирование символов (все символы кроме группы от a до b)
echo preg_replace('#a[^b-d]#', 'x', 'abacadae');
// Вся кирилица без ё
echo preg_replace('#[а-я]#u', 'x', 'Лёлик и Болек');
//вся кирилица с ё
echo preg_replace('#[а-яё]#u', 'x', 'Лёлик и Болек');
// Вся кирилица с заглавными и ё
echo preg_replace('#[аА-яЯё]#u', 'x', 'Лёлик и Болек');
// Спецсимволы внутри [] становятся обычными символами 
// Кроме "[]" (их надо экранировать) и "^" на первом месте внутри []
echo preg_replace('#[x/y]#u', 'z', 'text/type');
// Повтор один или более раз
echo preg_replace('#ab+#', 'x', 'ababababa');
// Повтор ноль один или более раз 
echo preg_replace('#ab*#', 'x', 'ababababa');
// Повтор ноль или более раз
echo preg_replace('#ab?#', 'x', 'ababababa');
// Повтор указанное количество (2) раз
echo preg_replace('#(ab){2}#', 'x', 'ababa');
// Группировка символов
echo preg_replace('#a(ba)+#', 'x', 'ababa');
// Экранирование символа
echo preg_replace('#b\.#', 'x', 'abab.a');

// Являются спецсимволами: $ ^ . * + ? \ / {} [] () |
// Не являются спецсимволами: @ : , ' " ; - _ = < > % # ~ ` & !

// Ограничение жадности. 
// По умолчанию регулярки закхватывают максимум символов от a до c
// Для ограничения жадности нужно добавить знак "?"
echo preg_replace('#a.*?c#', 'x', 'abcabcabc');


