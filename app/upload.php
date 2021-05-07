<?php
include_once 'db/db.php';
include_once 'src/Models/SelectFromDb.php';
include_once 'src/Views/ListFigure.php';
include_once 'src/Models/ParallelogramCheck.php';

//получаем данные с БД
$listFigure = new SelectFromDb($db);

// переменная хранения суммы
$summ = 0;

// Массив для временного хранения данных
$tempArr = [];
foreach ($listFigure->getResult() as $key => $value) {
   // Удаляем из массива элементы, у которых ключи - string
   foreach ($value as $keyNum => $val) {
      if(is_numeric($keyNum)){
         unset($value[$keyNum]);
	  }
   }
   //перебираем круг
   if( $value['figure_id'] == 1 ){  //id номер типа фигуры с таблицы figures
      $summ = $summ + $value['figure_id']; //id номер типа фигур
      $tempArr['figure_id'] = $value['figure_id'];
      $name = $value['type'];
      $tempArr[$name] = $value;
      if($summ == 2){
         unset($tempArr['radius']['figure_id']);
         unset($tempArr['center']['figure_id']);
         $group[] = $tempArr;
         $summ = 0;
         $tempArr = [];
      }
   }
   // треугольник
   if( $value['figure_id'] == 2 ){  //id номер типа фигуры с таблицы figures
      $summ = $summ + $value['figure_id']; //id номер типа фигуры
      $tempArr['figure_id'] = $value['figure_id'];
      $name = $value['type'];
      $tempArr[$name] = $value;
      if($summ == 6){
         unset($tempArr['point1']['figure_id']);
         unset($tempArr['point2']['figure_id']);
         unset($tempArr['point3']['figure_id']);
         $group[] = $tempArr;
         $summ = 0;
         $tempArr = [];
      }
   }
   // параллелограмм
   if( $value['figure_id'] == 3 ){  //id номер типа фигуры с таблицы figures
      $summ = $summ + $value['figure_id']; //id номер типа фигуры
      $tempArr['figure_id'] = $value['figure_id'];
      $name = $value['type'];
      $tempArr[$name] = $value;
      if($summ == 9){
         unset($tempArr['point1']['figure_id']);
         unset($tempArr['point2']['figure_id']);
         unset($tempArr['point3']['figure_id']);
         $group[] = $tempArr;
         $summ = 0;
         $tempArr = [];
      }
   }
}
$listFigure->closeSqlite();

// создаем объект для выода данных в таблице
$showFigures = new ListFigure();

foreach ($group as $key => $value) {
   if ($value['figure_id'] == 1) {
      $figure = 'Круг';
      // Считаем площадь
      // S = pi*R^2;
      $r = $value['radius']['x'] - $value['center']['x'];
      // площадь круга
      $area = 3.14 * $r * $r;
      // выводим данные на страницу в таблице
      echo $showFigures->showFiguresInTable($figure, $area);
   }
   if ($value['figure_id'] == 2) {
      $figure = 'Треугольник';
      // Считаем площадь
      // S = |( x1 * ( y2-y3 ) + x2 * ( y3-y1 ) + x3 * ( y1-y2 ) ) / 2  |
      $numeraterA = $value['point1']['x'] * ( $value['point2']['y'] - $value['point3']['y'] );
      $numeraterB = $value['point2']['x'] * ( $value['point3']['y'] - $value['point1']['y'] );
      $numeraterC = $value['point3']['x'] * ( $value['point1']['y'] - $value['point2']['y'] );
      $area = abs( ($numeraterA + $numeraterB + $numeraterC) / 2 );
      // выводим данные на страницу в таблице
      echo $showFigures->showFiguresInTable($figure, $area);
   }
   if ($value['figure_id'] == 3) {
      $figure = 'Параллелограмм';
      // Считаем площадь ( Суммируем площади одинаковых треугольников ) -
      // S = |( x1 * ( y2-y3 ) + x2 * ( y3-y1 ) + x3 * ( y1-y2 ) ) / 2  | *2
      $numeraterA = $value['point1']['x'] * ( $value['point2']['y'] - $value['point3']['y'] );
      $numeraterB = $value['point2']['x'] * ( $value['point3']['y'] - $value['point1']['y'] );
      $numeraterC = $value['point3']['x'] * ( $value['point1']['y'] - $value['point2']['y'] );
      $area = abs( ($numeraterA + $numeraterB + $numeraterC) / 2 ) * 2;

      // проверка параллелограмма на принадлежность квадрату
      $square = new ParallelogramCheck();

      $sideParallelogramm = $square->lengthLine($value['point1']['x'], $value['point2']['x'], $value['point1']['y'], $value['point2']['y']);
      $diagonalParallelogramm = $square->lengthLine($value['point2']['x'], $value['point3']['x'], $value['point2']['y'], $value['point3']['y']);
      $result = $square->resultCheck($sideParallelogramm, $diagonalParallelogramm);
      if ($result){
         $figure = 'Квадрат';
      }
      else{
         $figure = 'Параллелограмм';
      }

      // выводим данные на страницу в таблице
      echo $showFigures->showFiguresInTable($figure, $area);
   }
}
?>
