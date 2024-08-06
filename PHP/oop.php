<?php

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