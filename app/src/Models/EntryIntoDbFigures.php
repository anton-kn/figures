<?php
/**
 * класс записывает в базу данных параметры фигуры
 */
class EntryIntoDbFigures
{
   private $x;
   private $y;
   // protected $lastPointId; //переменная для хранения последнего id из таблицы points

   private $dbSqlite;
   function __construct($dbSqlite)
   {
      $this->dbSqlite = $dbSqlite;
   }
   // устанавливаем координаты
   public function setCoordinats($x, $y)
   {
      $this->x = $x;
      $this->y = $y;
   }

   // проверяем наличие координат в таблице points
   public function checkDuplicatePoints ()
   {
      $sql = "SELECT x, y FROM points WHERE x = '".$this->x."' AND y = '".$this->y."' ";
      $results = $this->dbSqlite->query($sql);
      $row = $results->fetchArray();
      // $this->dbSqlite->close();
      if ($row === false){
         return false; //нет точек
      }
      else{//есть точки
         return true;
      }
   }

   //проверяем наличие параметров в таблице params
   public function checkDuplicateParams ($figure_id, $type, $point_id)
   {
      $sql = "SELECT id FROM params WHERE figure_id = '".$figure_id."' AND type = '".$type."' AND  point_id = '".$point_id."'";
      $results = $this->dbSqlite->query($sql);
      $row = $results->fetchArray();
      if ($row === false){
         return false; //нет парметров
      }
      else{ //есть параметры
         return $row[0];
      }
   }

    //записываем координаты в points
   public function insertTablePoint()
   {
      $sql = "INSERT INTO points (x, y) VALUES ( '".$this->x."' , '".$this->y."' )";
      //записываем в БД
      if ( $this->dbSqlite->exec($sql) ) {
         // возвращаем записанный points_id
         $lastPointId = $this->dbSqlite->lastInsertRowID();
         return $lastPointId;
      }
      else{
         return false;
      }
   }

   //записываем данные в таблицу params
   public function insertTableParams($figureId, $typeParam, $pointId)
   {
      $sql = "INSERT INTO params (figure_id, type, point_id) VALUES ('".$figureId."' , '".$typeParam."' , '".$pointId."' )";
      $this->dbSqlite->exec($sql);
      return true;
   }

   // возвращаем id точек с таблицы points
   public function getIdFromPointsTable()
   {
      $sql = "SELECT id FROM points WHERE x = '".$this->x."' AND y = '".$this->y."'";
      $results = $this->dbSqlite->query($sql);
      $getPointId = $results->fetchArray();
      // $this->dbSqlite->close();
      return $getPointId[0]; //возвращает id точки из таблицы points
   }

   public function closeDB()
   {
      $this->dbSqlite->close();
   }

}


?>
