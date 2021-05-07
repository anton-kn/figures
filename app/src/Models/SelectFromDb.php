<?php
/**
 * Класс выполняет запрос в БД
 */
class SelectFromDb
{
   private $dbSqlite;
   function __construct($dbSqlite)
   {
      $this->dbSqlite = $dbSqlite;
   }

   private function queryInDb()
   {
      $sql = "SELECT params.figure_id, params.type, points.x, points.y
      FROM params INNER JOIN points ON params.point_id = points.id";
      return $this->dbSqlite->query($sql);
   }

   // выводим данные с БД
   public function getResult()
   {
      $results = self::queryInDb();
      $arrayJoint = [];
      while($row = $results->fetchArray()){
         $arrayJoint[] = $row;
      }
      return $arrayJoint;
   }
   // закрываем БД
   public function closeSqlite(){
      $this->dbSqlite->close();
   }

}

?>
