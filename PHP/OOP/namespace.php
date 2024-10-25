<?php
namespace Transport\Auto;
class Cargo {
	
	function __toString () {
		return 'parent class Cargo';
	}
}
// При наследовании указывается имя родителя вместе с пространством имен.
class Track extends \Transport\Auto\Cargo {}
// Если оба класса принадлежат одному и тому же пространству имен,
// можно указывать имя родителя без указания пространства имен.
class Track extends Cargo {}


// Команду namespace можно писать не только в файлах с определениями классов, 
// но и вообще в любых других файлах.
echo (new Transport\Auto\Track);
// Эквивалентно:
namespace Transport\Auto;
echo (new Track);
// ИЛИ
namespace Transport;
echo (new Auto\Track);

// ===== КОМАНДА use =====

use Transport\Auto\Cargo;
echo (new Cargo);
// Эквивалентно:
echo (new Transport\Auto\Cargo);

// Псевдоним класса
// Используют во избежания конфликта имен
use Machine\Transport\Auto\Cargo as MTACargo;
echo (new MTACargo);

// ===== АВТОЗАГРУЗКА КЛАССОВ =====

// /core/lib/auto.php
namespace  Core\Lib;
class Auto {
	function __toString () {
		return 'class Auto';
	}
}
// /index.php
spl_autoload_register();
echo (new Core\Lib\Auto);

// СВОЯ АВТОЗАГРУЗКА КЛАССОВ
// /core/lib/auto.php
namespace  Machine\Transport;
class Auto {
	function __toString () {
		return 'class Auto';
	}
}
// /index.php
spl_autoload_register(function ($class) {
	$class = array_pop(explode('\\', $class));
	require 'core\lib\\'.$class.'.php';
});
echo (new Machine\Transport\Auto);