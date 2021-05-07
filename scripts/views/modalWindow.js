// скрипт для отображения модального окна

//Отрабатывает событие кнопки
let createModal = document.querySelector('.create-modal');

let modal = document.querySelector('.modal');

// открываем модальное окно
createModal.onclick = function(){
	modal.style.display = 'block';
}

// закрываем модальное окно
modal.onclick = function(event){
	if (event.target.className == 'modal'){
		modal.style.display = 'none';
	}
}