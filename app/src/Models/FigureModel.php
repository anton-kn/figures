<?php
/**
 * Класс предназначен для обработки коодинат фигур 
 */
class FigureModel
{
	public $arrFromController;

	// Возвращает координаты фигуры
	public function getCoordinates(){
		// отрезаем начало и конец массива
		return array_slice($this->arrFromController, 1, - 1);
	}

	// Проверяем являются ли введенные координаты числами
	// возвращает массив имена координат не являющимися числами int
	public function checkCoordinats()
	{
		// имена координат не являющимися числами int
		$itemNum = array();
		foreach ( self::getCoordinates() as $key => $value ) {
			if ( is_numeric($value) === false ) { // если введеннные данные является string (не int)
				$itemNum[] = $key;
			}
		}
		return $itemNum; // имена координат не являющимися числами int
	}

	// возвращает массив c именами координат, которые не введены
	public function getArrayCoordinats()
	{
		// массив, куда записываем отсутствующие элементы
		$itemArr = array();
		foreach ( self::getCoordinates() as $key => $value ) {
			if ( empty(self::getCoordinates()[$key]) ) {
				// Отсутствующие ключи координат
				$itemArr[] = $key;
			}
		}
		return $itemArr;
	}
}
 ?>
