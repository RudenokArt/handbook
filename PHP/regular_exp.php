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
// группировка символов
echo preg_replace('#a(ba)+#', 'x', 'ababa');