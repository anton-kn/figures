<?php
/**
 *
 */
class Controller
{
	// Весь массив с GET
	// private $data;
	private $model;
	public function __construct($model)
	{
		$this->model = $model;
	}
	// Отправляем массив данных в модель
	public function setDataModel($data)
	{
		$this->model->arrFromController = $data;
	}
}

 ?>
