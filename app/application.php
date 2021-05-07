<?php

include_once 'src/Controllers/Controller.php';
include_once 'src/Models/FigureModel.php';
include_once 'src/Models/EntryIntoDbFigures.php';
include_once 'src/Views/ViewLog.php';
include_once 'Figures/Circle.php';
include_once 'Figures/Triangle.php';
include_once 'Figures/Parallelogramm.php';
include_once 'checkParams.php';
// include_once 'src/Models/RecordCircleDb.php';
include_once ($_SERVER['DOCUMENT_ROOT'] . '/app/db/db.php');

//Данные с GET-запроса ( данные с координатами  )
$data = $_GET;
if (isset($data['btn']) && !empty($data['btn'])){

	$model = new FigureModel();
	$controller = new Controller($model);
	// передаем данные в модель
	$controller->setDataModel($data);
	$view = new ViewLog();

	// проверяем коррекность данных
	if( count($model->getArrayCoordinats()) > 0 ){
		// если введены не все координаты выводим лог-ошибку
		echo $view->errorLog($model->getArrayCoordinats());
	}else{
		// если введенные коодинаты не являются числами ( int )
		if ( count($model->checkCoordinats()) > 0 ) {
			echo $view->errorLogCoordinats( $model->checkCoordinats() );
		}
		else{
			// массив будет содержать id номера типов фигур,
			// т.е id = 1 -> circle, id = 2 -> triangle, id = 3 -> parallelogramm
			$figureID = [];
			// запросим данные с таблицы figures
			$sql = "SELECT * FROM figures";
			$results = $db->query($sql);
			while ($row = $results->fetchArray()) {
				$figureID[ $row['type'] ] = $row['id'];
			}

			if( $data['select'] == 'circle' ) {
				$circle = new Circle( $data['R'], $data['x1'], $data['y1'] );
				// проверка данных
				if( $circle->checkRadius() == true ){
					// если радиус и коодината x1 равны, выводим ошибку
					echo $view->errorRadius( $data['R'], $data['x1'] );
				}
				else{
					// ---формируем данные----
					$radius = $circle->getRadius(); // координаты радиуса
					$center = $circle->getCenter(); // коодинаты центра

					// ---- запись в БД ----
					$boxArr = []; // массив, в котором будут данные с БД

					// работаем с БД
					$circleFigure = new EntryIntoDbFigures($db);
					// Шаг 1 - устанавливаем, проверяем координаты центра
					$circleFigure->setCoordinats($center['x'], $center['y']);
					// Проверяем наличие коодинат
					if ($circleFigure->checkDuplicatePoints() === false) {	// нет повторяющихся коодинат
						$idFromTablePoints = $circleFigure->insertTablePoint(); // записываем координаты и возвращаем id
					}
					else{ //есть координаты в таблице points
						// забираем id координату с таблицы points_id
						$idFromTablePoints = $circleFigure->getIdFromPointsTable();
					}

					// проверяем наличие параметров с таблицы params
					$idFromTableParams = $circleFigure->checkDuplicateParams($figureID['circle'], 'center', $idFromTablePoints);

					$boxArr['center'] =
					[
						'params_id' => $idFromTableParams,
						'point_id' => $idFromTablePoints,
						'type_param' => 'center'
					];

					// Шаг 2 - устанавливаем, проверяем координаты радиуса
					// устанавливаем координаты
					$circleFigure->setCoordinats($radius['x'], $radius['y']);
					// Проверяем наличие коодинат
					if ($circleFigure->checkDuplicatePoints() === false) {	// нет повторяющихся коодинат
						$idFromTablePoints = $circleFigure->insertTablePoint(); // записываем координаты и возвращаем id
					}
					else{ //есть координаты в таблице points
						// забираем id координату с таблицы points_id
						$idFromTablePoints = $circleFigure->getIdFromPointsTable();
					}
					// проверяем наличие параметров с таблицы params
					$idFromTableParams = $circleFigure->checkDuplicateParams($figureID['circle'], 'radius', $idFromTablePoints);

					$boxArr['radius'] =
					[
						'params_id' => $idFromTableParams,
						'point_id' => $idFromTablePoints,
						'type_param' => 'radius'
					]; //запишем id, существующих параметров

					//производим проверку, нет ли такой фигуры с параметрами, которые мы ввели
					$checkID = checkPoints($boxArr['center']['params_id'], $boxArr['radius']['params_id']);
					if($checkID){
						echo $view->statement(); //выводим - фигура есть в базе
					}else{
						// записываем парметры в базу
						$circleFigure->insertTableParams($figureID['circle'], 'center', $boxArr['center']['point_id']);
						$circleFigure->insertTableParams($figureID['circle'], 'radius', $boxArr['radius']['point_id']);
						echo $view->successLog(); //запись удалась
					}
					// чистим массив
					$boxArr = [];

					// Закрываем БД
					$circleFigure->closeDB();
				}
			}
			// тип фигуры треугольник
			elseif ( $data['select'] == 'triangle' ) {
				$triangle = new Triangle($model->getCoordinates());
				// проверяем корректность введенных данных
				if ( $triangle->checkPoints() || $triangle->checkPointsOnLine() ){
					// Результат проверки
					$log = $triangle->getLog();
					echo $view->errorPoints($log);
				}
				else{
					// работаем с БД
					$triangleFigure = new EntryIntoDbFigures($db);
					for ($i=1; $i < 4; $i++) {
						// Шаг 1 - устанавливаем, проверяем координаты центра
						$x = $triangle->getPoints()['point'.$i]['x'];
						$y = $triangle->getPoints()['point'.$i]['y'];
						$triangleFigure->setCoordinats($x, $y);
						// $triangleFigure->setCoordinats($triangle->getPoints()['point'.$i]['x'], $triangle->getPoints()['point'.$i]['y']);
						// Проверяем наличие коодинат
						if ($triangleFigure->checkDuplicatePoints() === false) {	// нет повторяющихся коодинат
							$idFromTablePoints = $triangleFigure->insertTablePoint(); // записываем координаты и возвращаем id
						}
						else{
							// есть координаты в таблице points
							// забираем id координату с таблицы points_id
							$idFromTablePoints = $triangleFigure->getIdFromPointsTable();
						}
						// проверяем наличие параметров с таблицы params
						$idFromTableParams = $triangleFigure->checkDuplicateParams($figureID['triangle'], 'point'.$i, $idFromTablePoints);

						$boxArr['point'.$i] =
						[
							'params_id' => $idFromTableParams,
							'point_id' => $idFromTablePoints,
							'type_param' => 'point'.$i
						];
					}
					//производим проверку - идут ли точки друг за другом по id - номерам c таблицы points
					$checkID = checkPoints($boxArr['point1']['params_id'], $boxArr['point2']['params_id'], $boxArr['point3']['params_id']);
					if($checkID){
						echo $view->statement(); //выводим - фигура есть в базе
					}else{
						// записываем парметры в базу
						foreach ($boxArr as $key => $value) {
							$triangleFigure->insertTableParams($figureID['triangle'], $key, $value['point_id']);
						}
						echo $view->successLog(); //запись удалась
					}
					// чистим массив
					$boxArr = [];

					// Закрываем БД
					$triangleFigure->closeDB();
				}
			}
			// тип фигуры параллелограмм
			elseif ($data['select'] == 'parallelogramm') {
				$parallelogramm = new Parallelogramm($model->getCoordinates());
				// проверяем корректность введенных данных
				if ($parallelogramm->checkPoints() || $parallelogramm->checkPointsOnLine() ){
					$log = $parallelogramm->getLog();
					echo $view->errorPoints($log);
				}
				else{
					// работаем с БД
					$parallelogrammFigure = new EntryIntoDbFigures($db);
					for ($i=1; $i < 4; $i++) {
						// Шаг 1 - устанавливаем, проверяем координаты центра
						$x = $parallelogramm->getPoints()['point'.$i]['x'];
						$y = $parallelogramm->getPoints()['point'.$i]['y'];
						$parallelogrammFigure->setCoordinats($x, $y);
						// $parallelogrammFigure->setCoordinats($parallelogramm->getPoints()['point'.$i]['x'], $parallelogramm->getPoints()['point'.$i]['y']);
						// Проверяем наличие коодинат
						if ($parallelogrammFigure->checkDuplicatePoints() === false) {	// нет повторяющихся коодинат
							$idFromTablePoints = $parallelogrammFigure->insertTablePoint(); // записываем координаты и возвращаем id
						}
						else{ //есть координаты в таблице points
							// забираем id координату с таблицы points_id
							$idFromTablePoints = $parallelogrammFigure->getIdFromPointsTable();
						}
						// проверяем наличие параметров с таблицы params
						$idFromTableParams = $parallelogrammFigure->checkDuplicateParams($figureID['parallelogramm'], 'point'.$i, $idFromTablePoints);

						$boxArr['point'.$i] =
						[
							'params_id' => $idFromTableParams,
							'point_id' => $idFromTablePoints,
							'type_param' => 'point'.$i
						]; //запишем id, существующих параметров
					}
					//производим проверку, нет ли такой фигуры с параметрами, которые ввели
					$checkID = checkPoints($boxArr['point1']['params_id'], $boxArr['point2']['params_id'], $boxArr['point3']['params_id']);
					if($checkID){
						echo $view->statement(); //выводим - фигура есть в базе
					}else{
						// записываем парметры в базу
						foreach ($boxArr as $key => $value) {
							$parallelogrammFigure->insertTableParams($figureID['parallelogramm'], $key, $value['point_id']);
						}
						echo $view->successLog(); //запись удалась
					}
					// чистим массив
					$boxArr = [];

					// Закрываем БД
					$parallelogrammFigure->closeDB();
				}
			}
		}
	}
}
?>
