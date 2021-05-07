<?php
/**
 * Класс для вывода таблицы
 */
class ListFigure
{
   function __construct()
   {
      $this->i = 0;
   }

   private function getIncrement()
   {
      return ++$this->i;
   }

   public function showFiguresInTable($typeFigure, $area)
   {
      $increm = self::getIncrement();
      $out =
      "<tr>
         <td>{$increm}</td>
         <td>{$typeFigure}</td>
         <td>{$area}</td>
      </tr>";
      return $out;
   }
}
 ?>
