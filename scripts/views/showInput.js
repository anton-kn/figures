// Скрипт показывает и скрывает поля ввода параметров фигур

let circle = document.querySelector('.circle');
// input-ы с параметрами круга
let coordinateCircle = document.querySelectorAll('.coordinate-circle');

// Параллелограмм и треугольник
let parallelogramTriangle = document.querySelector('.parallelogram-triangle');
// input-ы с параметрами араллелограмма и треугольника
let coordinateParaltring  = document.querySelectorAll('.coordinate-paraltring ');

// переводим на иходное состояние select - круг
let select = document.querySelector('#select');
select.value = 'circle';

// Функция показывает круг
function showFigure(figure, coordinatsFigure, bool){
	if (bool == true) {
		figure.style.display = 'block';

		for ( let item of coordinatsFigure ){
			// отключаем аттрибут disabled, чтобы передавлось в GET
			item.removeAttribute('disabled');
		}
	}
	else if(bool == false){
		figure.style.display = 'none';
		// включаем аттрибут disabled, чтобы НЕ передавлось в GET
		for (let item of coordinatsFigure){
			item.setAttribute('disabled', 'true');
		}
	}
}

// событие на выбор select
// выбираем форму фигуры
select.onchange = function(){
	if (this.value == 'circle') {
		showFigure(circle, coordinateCircle, true);
		showFigure(parallelogramTriangle, coordinateParaltring, false)
	}
	else {
		showFigure(circle, coordinateCircle, false);
		showFigure(parallelogramTriangle, coordinateParaltring, true)
	}
}
