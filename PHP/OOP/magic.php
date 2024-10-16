<?php

// ========== __toString =========

// __toString вызывается при попытке приведения экземпляра класса к строке.
class Auto {
	function __construct($model) {
		$this->model = $model;
	}
	function __toString () {
		return json_encode($this);
	}
}
$car = new Auto('Renault megane');
echo $car;

// ========== __get ==========

// __get метод срабатывает при попытке прочитать значение приватного или защищенного свойства.
// Позволяет обращаться именно к свойствам, будто они публичные.
// Но записать в них не сможем, будто они приватные.
class Auto {
	private $model;
	function __construct($model) {
		$this->model = $model;
	}
	function __get ($property) {
		return $this->$property;
	}
}
$car = new Auto('Renault megane');
echo $car->model;
echo $car->__get('model');

// Несуществующее (виртуальное) свойство: в классе его нет, но прочитать его можно

class Auto {
	private $model;
	function __construct($model) {
		$this->model = $model;
	}
	function __get ($property) {
		if ($property == 'brand') {
			return 'brand: '.$this->model;
		}
		return $this->$property;
	}
}
$car = new Auto('Renault megane');
echo $car->brand;

// ========== __set =========

// метод __set вызывается при попытке изменить значение несуществующего или скрытого свойства. 
// В качестве параметров он принимает имя свойства и значение, которое ему пытаются присвоить.
class Auto {
	private $model;
	function __construct($model) {
		$this->model = $model;
	}
	function __set ($property, $value) {
		echo $property.' is disabled property';
	}
}
$car = new Auto('Renault megane');
$car->model = 'Renault symbol';

// Запись несуществующего свойства
class Auto {
	function __set ($property, $value) {
		$this->$property = $value;
	}
}
$car = new Auto();
$car->model = 'Renault symbol';
echo $car->model;