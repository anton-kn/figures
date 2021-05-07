<?php
/**
 * вид показывает сообщения о данных (координатах)
 */
class ViewLog
{

	// запись в БД прошала успешно
	public function successLog()
	{
		return '<p style="color: green">Фигура записана в базу' . '</p>';
	}
	// такая фигура есть в БД
	public function statement()
	{
		return '<p style="color: red">Такая фигура есть в базе' . '</p>';
	}

	// Возвращает ошибку, когда не все данные введены введены
	public function errorLog($arr)
	{
		// $arr - массив координат
		$string = null;
		foreach ($arr as $value) {
			$string .= " " . $value;
		}
		return '<p style="color: red">Ошибка: Введите недостающие данные в : '. "$string" . '</p>';
	}

	//Непредвиденная ошибка
	public function error()
	{
		return '<p style="color: red">Ошибка не определена </p>';
	}

	// возвращает ошибку, когда координаты не являются числами
	public function errorLogCoordinats($arr)
	{
		$string = null;
		foreach ($arr as $value) {
			$string .= " " . $value;
		}
		return '<p style="color: red">Ошибка: Введите число  в: '. "$string" . '</p>';
	}

	// возвращает ошибку, когда нет радиуса круга
	public function errorRadius()
	{
		return '<p style="color: red">Ошибка:' . "Радиус должен быть больше коодинаты Х" . '</p>';
	}

	public function errorPoints($stringLog)
	{
		return '<p style="color: red">' . $stringLog . '</p>';
	}
}

 ?>
