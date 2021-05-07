<?php
// функция проверяет разницу между числами. Идут ли числа друг за другом.
// Пример - если 1, 2, 3, то выводим - true. Если 1, 3, 4,  то выводим - false
function checkPoints($point_1, $point_2, $point_3 = 0){
	//проверяем равенство point = false
	$result = true;
   // если перменных две
	if($point_3 === 0){
		if($point_1 === false || $point_2 === false){
			return false;
		}
		else{
			$diff = abs($point_1 - $point_2);
			if ( $diff === 1 ){
				return true;
			}
			else{
				return false;
			}
		}

	}else{
		if($point_1 === false || $point_2 === false || $point_3 === false){
			$result = false;
		}
		else{
			// если переменных три
			$arr = [$point_1, $point_2, $point_3];
			// сортировка
			array_multisort($arr);
			for ($i=0; $i < count($arr) - 1; $i++) {
				if(abs($arr[$i] - $arr[$i+1]) === 1){
					$result = true;
				}else{
					$result = false;
					break;
				}
			}
		}
		return $result;
	}
}
?>
