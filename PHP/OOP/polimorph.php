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