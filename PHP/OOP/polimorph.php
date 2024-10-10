<?php

// ===== АБСТРАКТНЫЕ КЛАССЫ И МЕТОДЫ =====

// Абстрактные классы представляют собой классы, предназначенные для наследования от них. При этом объекты таких классов нельзя создать.
// Абстрактные классы также могут содержать абстрактные методы. Такие методы не должны иметь реализации, реализация таких методов - уже задача потомков.
// При наследовании от абстрактного класса, все методы, помеченные абстрактными в родительском классе, должны быть определены в дочернем классе.
// При этом область видимости этих методов должна совпадать или быть менее строгой.
// Объявления методов также должны совпадать: количество обязательных параметром должно быть одинаковым. Однако класс-потомок может добавлять необязательные параметры, которые не были указаны при объявлении метода в родителе.
abstract class Auto {
	abstract protected function capacityGet ($capacity);
};
class Cargo extends Auto {
	public function capacityGet ($capacity) {
		return $capacity;
	}
}
$track = new Cargo();
print_r($track->capacityGet('5 tons'));

// ===== ИНТЕРФЕЙСЫ =====

// Интерфейсы представляют собой классы, у которых все методы являются публичными и не имеющими реализации.
// Код методов должны реализовывать классы-потомки интерфейсов.
// Нельзя создать объект интерфейса. 
// Все методы интерфейса должны быть объявлены как public и не должны иметь реализации.
// У интерфейса могут быть только методы, но не свойства.
// Нельзя также сделать интерфейс и класс с одним и тем же названием.
interface iAuto {
	public function getBrand();
}
class Auto implements iAuto {
	function __construct($brand) {
		$this->brand = $brand;
	}
	public function getBrand () {
		return $this->brand;
	}
	public function printBrand () {
		echo $this->brand;
	}
}
$car = new Auto ('Renault');
echo $car->getBrand();

// Методы описанные в интерфейсах должны содержать принимаемые все параметры
interface iAuto {
	public function getBrand($brand);
}
class Auto implements iAuto {
	public function getBrand ($brand) {
		return $brand;
	}
}
$car = new Auto ();
echo $car->getBrand('Renault');

// Наследование интерфейсов + Конструктор интерфейса
interface iAuto {
	public function __construct($model, $brand);
}
interface iTrack extends iAuto {};
class Track implements iTrack {
	function __construct($model, $brand) {
		$this->model = $model;
		$this->brand = $brand;
	}
}
$car = new Track('Toyota', 'Tundra');
echo $car->brand;

// Проверка связи объектов с классами и интерфейсами
interface iAuto {
	public function __construct($model, $brand);
}
interface iTrack extends iAuto {};
class Track implements iTrack {
	function __construct($model, $brand) {
		$this->model = $model;
		$this->brand = $brand;
	}
}
$car = new Track('Toyota', 'Tundra');
var_dump($car instanceof Track);
var_dump($car instanceof iTrack);
var_dump($car instanceof iAuto);

// Наследование от нескольких интерфейсов
interface iAuto {
	public function __construct($model, $brand);
}
interface iTrack extends iAuto {
	public function getBrand();
};
interface iCargo extends iAuto {
	public function getModel();
}
class Car implements iTrack, iCargo {
	function __construct($model, $brand) {
		$this->model = $model;
		$this->brand = $brand;
	}
	public function getModel () {
		return $this->model;
	}
	public function getBrand () {
		return $this->brand;
	}
}
$carGo1 = new Car('Ram','Dodge');
echo $carGo1->getBrand().' '.$carGo1->getModel();

// Наследование от класса и интерфейса одновременно
interface iAuto {
	function __construct ($model);
}
abstract class Cargo {
	abstract protected function getModel ();
}
class Track extends Cargo implements iAuto {
	function __construct($model) {
		$this->model = $model;
	}
	public function getModel () {
		return $this->model;
	}
}
$car = new Track('Dodge Ram');
echo $car->getModel();

// Проверка интерфейса на существование
interface iAuto {
	const WHEELS = 4;
}
var_dump(interface_exists('iAuto'));

// Массив объявленных интерфейсов
interface iAuto {
	const WHEELS = 4;
}
print_r(get_declared_interfaces());



// ===== ТРЕЙТЫ =====
// Трейт представляет собой набор свойств и методов, которые можно включить в другой класс.
// Экземпляр трейта нельзя создать - трейты предназначены только для подключения к другим классам.
// В классе можно использовать не один, а несколько трейтов.
trait Auto {
	public function getModel () {
		return $this->model;
	}
}
trait Track {
	public function getCapacity () {
		return $this->capacity;
	}
}
class Cargo {
	use Auto, Track;
	function __construct($model, $capacity){
		$this->model = $model;
		$this->capacity = $capacity;
	}
}

$car = new Cargo ('Dodge Ram', 500);
echo $car->getModel();
echo $car->getCapacity();

// Разрешение конфликтов в трейтах, когда два трейта имеют одноименные методы.
// С помощью оператора insteadof указываем использовать метод одного трейта,
// метод второго трейта оказывается недоступным.
trait Auto {
	public function getModel () {
		return $this->model;
	}
}
trait Track {
	public function getModel () {
		return 'model: '.$this->model;
	}
}
class Cargo {
	use Auto, Track {
		Track::getModel insteadof Auto;
	}
	function __construct($model){
		$this->model = $model;
	}
}

$car = new Cargo ('Dodge Ram', 500);
echo $car->getModel();

// Можно использовать и метод второго трейта, переименовав его через ключевое слово as
// Использовать ключевое слово as без определения главного метода через insteadof нельзя

trait Auto {
	public function getModel () {
		return $this->model;
	}
}
trait Track {
	public function getModel () {
		return 'model: '.$this->model;
	}
}
class Cargo {
	use Auto, Track {
		Track::getModel insteadof Auto;
		Auto::getModel as getModel_A;
		Track::getModel as getModel_T;
	}
	function __construct($model){
		$this->model = $model;
	}
}
$car = new Cargo ('Dodge Ram', 500);
echo $car->getModel_A().PHP_EOL;
echo $car->getModel_T();

// В использующем трейт классе будут доступны как публичные, так и приватные методы и свойства трейта
// При необходимости, в самом классе можно этот модификатор поменять на другой.
// Для этого в теле use после ключевого слова as нужно указать новый модификатор.
trait Auto {
	private function getModel () {
		return $this->model;
	}
}
class Cargo {
	use Auto {
		Auto::getModel as public;
	}
	function __construct($model){
		$this->model = $model;
	}
}
$car = new Cargo ('Dodge Ram');
echo $car->getModel();

// Приоритет методов
// Если в классе и в трейте есть одноименный метод, то метод класса переопределит метод трейта
trait Auto {
	public function getModel () {
		return $this->model;
	}
}
class Cargo {
	use Auto;
	public function getModel () {
		return $this->model.' from class';
	}
	function __construct($model){
		$this->model = $model;
	}
}
$car = new Cargo ('Dodge Ram');
echo $car->getModel();

// Если имеется конфликт имен методов трейта и методов родительского класса,
// то методы трейта имеют приоритет
trait Auto {
	public function getModel () {
		return $this->model.' - trait';
	}
}
class Track {
	public function getModel () {
		return $this->model.' - parent';
	}
}
class Cargo extends Track {
	use Auto;
	function __construct($model){
		$this->model = $model;
	}
}
$car = new Cargo ('Dodge Ram');
echo $car->getModel();

// В трейтах можно некоторые методы объявлять абстрактными.
// В этом случае класс, использующий этот трейт, обязан будет реализовать такой метод.
trait Auto {
	abstract public function getModel();
}
class Track {
	use Auto;
	function __construct ($model) {
		$this->model = $model;
	}
	public function getModel () {
		return $this->model;
	}
}
$car = new Track ('Dodge Ram');
echo $car->getModel();

// Трейты в трейтах
trait Auto {
	public function getModel () {
		return $this->model;
	}
}
trait Cargo {
	use Auto;
	function __construct ($model) {
		$this->model = $model;
	}
}
class Track {
	use Cargo;
}
$car = new Track ('Dodge Ram');
echo $car->getModel();

// Проверка трейта на существование
var_dump(trait_exists('Cargo'));
// Получить объявленные трейты
print_r(get_declared_traits());