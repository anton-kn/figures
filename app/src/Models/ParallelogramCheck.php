<?php
/**
 * Проверка параллелограмма на квадрат. Не является ли параллелограмм квадратом
 */
class ParallelogramCheck
{
   // длина линии по координатамм
   public function lengthLine ($x1, $x2, $y1, $y2)
   {
      // L = ( (| y2-y1 |)^2 + (| x2-x1 |)^2 ) * 1/2 - длина
      $len1 = pow( abs( $y2 - $y1 ), 2 );
      $len2 = pow( abs( $x2 - $x1 ), 2 );
      $L = sqrt( $len1 + $len2 );
      return $L;
   }

   public function resultCheck($side, $diagonal)
   {
      // Сравниваем значение длин диагоналей.
      // Первую диагональ мы получаем из переменной - $diagonal.
      // Вторую из следующей формулы d = 1.4142 * a, где a - длина стороны квадрата равная
      // значению переменной - $side

      $res = 1.4142 * $side;
      // сравниваем диагональ с диагональю, предварительно округяем
      if ( ceil($diagonal) == ceil($res) ) {
         return true;
      }else{
         return false;
      }
   }
}

?>
