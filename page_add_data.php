<!DOCTYPE html>
<html>
<head>
	<title>Страница добавления данных фигуры</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">

</head>
<body>
<!--Окно  для добавления фигуры -->
<div class="home">
	<a class="button" href="/">Домой</a>
</div>
<div class="windows">
	<form action="" method="GET">
		<h4>Выберите фигуру</h4>
		<select name="select" id="select">
			<option value="circle">Круг</option>
			<option value="triangle">Треугольник</option>
			<option value="parallelogramm">Параллелограмм</option>
		</select><br>
	<h4>Введите координаты</h4>
	<!-- координаты круга-->
	<div class="circle" style="display: block;">
		<p>
			<label for = "x1">Центр
				<input id="x1" class="coordinate-circle" type="text" name="x1" placeholder="X1" style="width: 60px;">
				<input id="y1" class="coordinate-circle" type="text" name="y1" placeholder="Y1"style="width: 60px;">
			</label>
		</p>
		<p>
			<label for = "x2">Радиус
				<input id="radius" class="coordinate-circle" type="text" name="R" placeholder="R" style="width: 60px; ">
				<!-- <input id="y2" class="coordinate-circle" type="text" name="y2" placeholder="Y2" style="width: 60px;"> -->
			</label>
		</p>
	</div>
	<!-- координаты треугольника и параллелограмма-->
	<div class="parallelogram-triangle" style="display: none;">
		<p class="point1">
			<label for = "x1">Точка 1
				<input id="x1" class="coordinate-paraltring" type="text" name="x1" placeholder="X1" disabled="" style="width: 60px;">
				<input id="y1" class="coordinate-paraltring" type="text" name="y1" placeholder="Y1" disabled="" style="width: 60px;">
			</label>
		</p>
		<p class="point1">
			<label for = "x2">Точка 2
				<input id="x2" class="coordinate-paraltring" type="text" name="x2" placeholder="X2" disabled="" style="width: 60px;">
				<input id="y2" class="coordinate-paraltring" type="text" name="y2" placeholder="Y2" disabled="" style="width: 60px;">
			</label>
		</p>
		<p class="point3">
			<label for = "x3">Точка 3
				<input id="x3" class="coordinate-paraltring" type="text" name="x3" placeholder="X3" disabled="" style="width: 60px;">
				<input id="y3" class="coordinate-paraltring" type="text" name="y3" placeholder="Y3" disabled="" style="width: 60px;">
			</label>
		</p>
	</div>
		<input class="button" type="submit" value="Добавить" name="btn">
		<?php include_once "app/application.php"; ?>
	</form>
</div>
  	<script type="text/javascript" src="scripts/views/showInput.js"></script>
</body>
</html>
