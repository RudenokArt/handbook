<?php
// Простая замена
echo preg_replace('#a#', 'x', 'ababababa');
// . (точка) - любой символ 
// для кирилицы - две точки
echo preg_replace('#b.b#', 'x', 'ababababa');
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
