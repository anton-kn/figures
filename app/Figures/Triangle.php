<?php
/**
 * Тип фигуры треугольник
 */
include_once "Figure.php";

class Triangle extends Figure
{
	protected $arrCoordinates;
	private $log; // здесь будем хранить логи результата проверок координат
	function __construct($arrCoordinates)
	{
		$this->arrCoordinates = $arrCoordinates;
	}

	public function getLog()
	{
		return $this->log;
	}

	// проверка коодинат треугольника
	public function checkPoints()
	{
		if( $this->arrCoordinates['x1'] == $this->arrCoordinates['x2'] && $this->arrCoordinates['x1'] == $this->arrCoordinates['x3'] ){
			$this->log = 'Ошибка - Значения координат Х лежат на одной линии';
			return true; //ошибка - значения координат Х лежат на одной линии
		}
		elseif ( $this->arrCoordinates['y1'] == $this->arrCoordinates['y2'] && $this->arrCoordinates['y1'] == $this->arrCoordinates['y3'] ) {
			$this->log = 'Ошибка - Значения координат Y лежат на одной линии';
			return true; //ошибка - значения координат Y лежат на одной линии
		}
		elseif ( self::getPoints()['point1'] == self::getPoints()['point2'] ) {
			$this->log = 'Ошибка - точки совпадают';
			return true; //Ошибка - точки совпадают
		}
		elseif ( self::getPoints()['point1'] == self::getPoints()['point3'] ) {
			$this->log = 'Ошибка - точки совпадают';
			return true; //Ошибка - точки совпадают
		}
		elseif ( self::getPoints()['point3'] == self::getPoints()['point2'] ) {
			$this->log = 'Ошибка - точки совпадают';
			return true; //Ошибка - точки совпадают
		}
	}

	// проверка - не лежат ли точки на одной линии
	public function checkPointsOnLine()
	{
		// y = k*x + b - линейная функция
		// проверяем совпадение коэффициентов k и b, между точка (1,2) и (2,3)
		$x1 = self::getPoints()['point1']['x'];
		$y1 = self::getPoints()['point1']['y'];
		$x2 = self::getPoints()['point2']['x'];
		$y2 = self::getPoints()['point2']['y'];
		$x3 = self::getPoints()['point3']['x'];
		$y3 = self::getPoints()['point3']['y'];

		$denominatorOne = ( $x2 - $x1 );
		$denominatorTwo = ( $x3 - $x2 );

		if ($denominatorOne === 0 || $denominatorTwo === 0) {
			return false;
		}else{
			// первая и вторая точка
			$kOne = ( $y2 - $y1 ) / $denominatorOne;
			$mOne = $y1 - ( $kOne * $x1 );

			// вторая и третья точка
			$kTwo = ( $y3 - $y2 ) / $denominatorTwo;
		  	$mTwo = $y2 - ( $kTwo * $x2 );

			// сравниваем точки
			if( abs($kOne) === abs($kTwo) && abs($mOne) === abs($mTwo) ){
				$this->log = 'Ошибка - точки лежат на одной линии';
				return true;
			}
		}

	}

	// точки треугольника
	public function getPoints()
	{
		$points =
		[
			'point1'=>[ 'x' => $this->arrCoordinates['x1'], 'y' => $this->arrCoordinates['y1'] ],
			'point2'=>[ 'x' => $this->arrCoordinates['x2'], 'y' => $this->arrCoordinates['y2'] ],
			'point3'=>[ 'x' => $this->arrCoordinates['x3'], 'y' => $this->arrCoordinates['y3'] ]
		];
		return $points;
	}
}

 ?>
