<?php
/**
 * Класс фигуры
 * Структура компонета - тип фигуры, координаты фигуры
 */
class Figure
{
	public $type; //принимает GET (POST) данные о фигуре
	
	public function getType() //тип фигуры
	{
		return $this->type;
	}
}
