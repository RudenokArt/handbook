<?php


// ===== ИСПОЛЬЗОВАНИЕ КЛАССОВ ВНУТРИ ДРУГИХ КЛАССОВ =====
class Auto {
	public function getFuelLevel () {
		return '50 liters';
	}
}
class Peugeot {
	public function __construct() {
		$this->auto = new Auto;
	}
	public function showFuelLevel () {
		return $this->auto->getFuelLevel();
	}
}
$myCar = new Peugeot;
echo $myCar->showFuelLevel();

// ===== ПЕРЕДАЧА ОБЪЕКТА ПАРАМЕТРОМ =====
class Auto {
	public function __construct ($brand, $model) {
		$this->brand = $brand;
		$this->model = $model;
	}
}
class Car {
	function getFullTitle ($object) {
		return $object->brand . ' '. $object->model;
	}
}
$auto1 = new Auto('Renault', 'Clio');
$car1 = new Car();
echo $car1->getFullTitle($auto1);

// ===== ПЕРЕДАЧ ОБЪЕКТА ПО ССЫЛКЕ =====
// Объекты не копируются а передаются по ссылке. 
// Обе переменные ссылаются на один и тот же объект
class Auto {
	public $model = 'Lada Kalina 1118'.PHP_EOL;
}
$car1 = new Auto;
$car2 = $car1;
echo $car1->model;
echo $car2->model;
$car1->model = 'Lada Kalina 1119'.PHP_EOL;
echo $car1->model;
echo $car2->model;

// ===== ПЕРЕОПРЕДЕЛЕНИЕ МЕТОДА РОДИТЕЛЬСКОГО КЛАССА =====
class Auto {
	protected function getModel () {
		return 'Lada Kalina';
	}
}
class Car extends Auto {
	public function getModel () {
		return parent::getModel(). ' - 1119';
	}
}

// ===== ПЕРЕОПРЕДЕЛЕНИЕ КОНСТРУКТОРА РОДИТЕЛЬСКОГО КЛАССА =====
class Auto {
	protected $brand;
	function __construct () {
		$this->brand = 'Lada';
	}
	public function getBrand () {return $this->brand;}
}
class Car extends Auto {
	function __construct () {
		parent::__construct();
		$this->model = 'Kalina';
	}
	public function getModel () {return $this->model;}
}

$myCar = new Car();
echo $myCar->getModel();
echo $myCar->getBrand();

// ===== МОДИФИКАТОРЫ ДОСТУПА =====
public // наследуется не инкапсулируется
private // не наследуется инкапсулируется
protected // наследуется инкапсулируется

// ===== ПЕРЕМЕННЫЕ НАЗВАНИЯ СВОЙСТВ =====
class Auto {
	function __construct() {
		$this->brand = 'Lada';
		$this->model = 'Kalina';
	}
	public function getBrand () {
		return $this->brand;
	}
}
$auto1 = new Auto();

// Название свойства в переменной:
$property = 'brand';
echo $auto1->$property;

// Название свойства как элемент индексного массива:
$props = ['brand', 'model'];
echo $auto1->{$props[0]};

// Название свойства как элемент ассоциативного массива:
$props = [
	'prop1' => 'brand',
	'prop2' => 'model',
];
echo $auto1->{$props['prop1']};

// Название свойства из функции (или метода другого объекта)
function getProp () {
	return 'model';
}
echo $auto1->{getProp()};

// Название свойства из свойства другого объекта
$auto2 = new Auto();
$auto2->currentProp = 'brand';
echo $auto1->{$auto2->currentProp};

// ===== ПЕРЕМЕННЫЕ НАЗВАНИЯ МЕТОДОВ ===

$currentMethod = 'getBrand';
$auto1 = new Auto();
echo $auto1->$currentMethod();

// Название метода как элемент индексного массива:
$methods = ['getModel', 'getBrand'];
$auto1 = new Auto();
echo $auto1->{$methods[1]}();

// Название метода как элемент ассоциативного массива:
$methods = ['m1'=>'getModel', 'm2'=>'getBrand'];
$auto1 = new Auto();
echo $auto1->{$methods['m2']}();


// ===== ЦЕПОЧКА МЕТОДОВ =====
// метод должен возвращать $this
class Auto {
	function __construct() {
		$this->model = 'Kalina';
	}
	public function getModel () {
		return $this->model;
	}
	public function setModelIndex ($index) {
		$this->model = $this->model.'-'.$index;
		return $this;
	}
	public function setModelGeneration ($generation) {
		$this->model = $this->model.'_'.$generation;
		return $this;
	}
}
$auto1 = new Auto();
echo $auto1->setModelGeneration(1)->setModelIndex(1119)->model;

// ===== СРАВНЕНИЕ ОБЪЕКТОВ =====
// При использовании оператора == для сравнения двух объектов выполняется сравнение свойств объектов: два объекта равны, если они имеют одинаковые свойства и их значения (значения свойств сравниваются через ==) и являются экземплярами одного и того же класса.
// При сравнении через ===, переменные, содержащие объекты, считаются равными только тогда, когда они ссылаются на один и тот же экземпляр одного и того же класса.
class Auto {
	public function __construct ($brand, $model) {
		$this->brand = $brand;
		$this->model = $model;
	}
}
$auto1 = new Auto('Renault', 'Clio');
$car1 = new Auto('Renault', 'Clio');
$car2 = $car1;
var_dump($auto1 == $car1);
var_dump($auto1 === $car1);
var_dump($car1 === $car2);

// ===== ПРОВЕРКА НА ПРИНАДЛЕЖНОСТЬ КЛАССУ =====
class Auto {};
class Track {};
$car = new Auto();
$cargo = new Track();
var_dump($car instanceof Auto);
var_dump($cargo instanceof Auto);
// для объектов дочерних классов будет выполняться проверка 
// по отношению к родительским с положительным результатом (но не наоборот!)
class Auto {};
class Track extends Auto {};
$car = new Auto();
$cargo = new Track();
var_dump($car instanceof Auto);
var_dump($cargo instanceof Auto);
var_dump($car instanceof Track);

// Контроль типов (классов) при работе с объектами
class Auto {
	public $model = 'Ford F150';
};
class Track {
	public function getModel (Auto $auto) {
		return $auto->model;
	}
};
$car = new Auto();
$cargo = new Track();
echo $cargo->getModel($car);

// ===== СТАТИЧЕСКИЕ СВОЙСТВА И МЕТОДЫ =====
// Статические свойства у объектов одного класса общие
class Auto {
	public static $brend;
	public $model;
};
$car1 = new Auto();
$car2 = new Auto();
$car1::$brend = 'Renault';
echo $car1::$brend.' - ';
echo $car2::$brend;

// Статические методы могут использовать только статические свойства
// Обычные методы могу использовать как статические так и обычные свойства
class Auto {
	public static $brend;
	public $model;
	public static function getBrend () {
		return self::$brend;
	}
	public function getModel () {
		return self::$brend.'-'.$this->model;
	}
};
$car = new Auto();
$car::$brend = 'Renault';
$car->model = 'Clio';
echo $car::getBrend().' / ';
echo $car->getModel();

