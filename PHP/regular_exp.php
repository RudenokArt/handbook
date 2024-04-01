<?php


// Проверка строки на наличе подстроки
echo preg_match('#ab#', 'aaaaaaabbbbbbbbb');
// Количество всех совпадений
echo preg_match_all('#a.b#', 'acbadbaebafb');

// Простая замена
echo preg_replace('#a#', 'x', 'ababababa');

// Группировка символов
echo preg_replace('#a(ba)+#', 'x', 'ababa');

// Ограничение жадности. 
// По умолчанию регулярки закхватывают максимум символов от a до c
// Для ограничения жадности нужно добавить знак "?"
echo preg_replace('#a.*?c#', 'x', 'abcabcabc');

// ИЛИ
echo preg_replace('#(te)|(bo)#', 'x', 'ten green bottles');

// Экранирование ограничителя
echo preg_replace('#al \##', 'al N', 'deal # 10');
// Экранирование обратного слэша
echo preg_replace('#\\\#', 'X', 'aaa\bbb');
// Экранирование символа (спецсимвола)
echo preg_replace('#b\.#', 'x', 'abab.a');
// Являются спецсимволами: $ ^ . * + ? \ / {} [] () |
// Не являются спецсимволами: @ : , ' " ; - _ = < > % # ~ ` & !


// ===== КАРМАНЫ =====
// Поиск с карманами - каждой группе в круглых скобках соответствуюет отдельный карман.
// В указанную переменную попадет массив с найденными карманами.
// При этом в нулевом элементе массива будет лежать найденная строка,
// в первом элементе - первый карман,
// во втором элементе - второй карман
preg_match('#(a.c)(b.d)#', 'aaaaaaaabcbcdbbbb', $pocket);
print_r($pocket);
// Именованные карманы (в виде ассоциативного массива)
preg_match('#(?<hours>\d\d):(?<minutes>\d\d)#', '17:20', $arTime);
print_r($arTime);

// Все совпадения на карманы
preg_match_all('#a.b#', 'acbadbaebafb', $pocket);
print_r($pocket);

// Скобки () выполняют две функции - группировка символов и функцию кармана.
preg_match_all('#(abc)+#', 'abcabcabcd', $pocket);
print_r($pocket);

// Группировка без карманов (?:)
preg_match_all('#(?:abc)+#', 'abcabcabcd', $pocket);
print_r($pocket);

// Замена вместо карманов ($1 - индекс кармана)
echo preg_replace('#(abc)(def)#', '$1_replacement_', 'abcdefg');

// Использование результатов кармана в этой же регулярке (\1 - индекс кармана)
echo preg_replace('#(.)\1#', 'XXX', 'abccdeefg');
// Использование результатов именованного кармана в этой же регулярке (k<sumbol> - индекс кармана)
//  Варианты синтаксиса: \k{name}  \k'name'
echo preg_replace('#(?<sumbol>.)\k<sumbol>#', 'XXX', 'abccdeefg');

preg_match_all('#(?|19(..)|20(..))#', '1990-2024', $pocket);
print_r($pocket);

// Общий номер карманов
preg_match_all('#(?|19(..)|20(..))#', '1990-2024', $pocket);
print_r($pocket);


// ===== ЗАМЕНЫ =====
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
// Конец строки
echo preg_replace('#abc$#', 'x', 'abcabcabc');
// Начало строки
echo preg_replace('#^abc#', 'x', 'abcabcabc');

// ===== НАБОРЫ СИМОЛОВ =====
// Наборы [] символов. ИЛИ (b или c или d)
echo preg_replace('#a[bcd]#', 'x', 'abacadae');
// Группы символов внутри наборов []
echo preg_replace('#a[bcd\d]#', 'x', 'abacadaea5');
// Набор сиволов от b до d
echo preg_replace('#a[b-d]#', 'x', 'abacadae');
// Экранирование дефиса для набора символов
echo preg_replace('#a[b\-d]#', 'x', 'aba-ca-dae');
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

// ===== ПОВТОРЫ =====
// Повтор один или более раз
echo preg_replace('#ab+#', 'x', 'ababababa');
// Повтор ноль один или более раз 
echo preg_replace('#ab*#', 'x', 'ababababa');
// Повтор ноль или более раз
echo preg_replace('#ab?#', 'x', 'ababababa');
// Повтор указанное количество (2) раз
echo preg_replace('#(ab){2}#', 'x', 'ababa');




