<?php
/**
 * Тип фигуры круг
 */
include_once "Figure.php";

class Circle extends Figure
{
	private $radius;
	// координаты центра отверстия
	private $x1;
	private $y1;
	function __construct($radius, $x1, $y1)
	{
		$this->radius = $radius;
		$this->x1 = $x1;
		$this->y1 = $y1;
	}

	// проверяем корректность коодинат
	public function checkRadius()
	{
		if($this->radius == 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function getCenter()
	{
		$center =
		[
			'x' => (int)$this->x1,
			'y' => (int)$this->y1
		];
		return $center; //возващает массив [x1, y1, ... xN,yN]
	}

	public function getRadius()
	{
		$x2 = $this->radius + $this->x1; //вторая координата радиуса
		$radiusCoordinates =
		[
			'x' => (int) $x2,
			'y' => (int) $this->y1
		];
		return $radiusCoordinates; //возващает коодинаты радиуса
	}
}

?>
