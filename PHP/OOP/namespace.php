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