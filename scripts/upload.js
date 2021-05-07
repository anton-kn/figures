async function getData(url){
	let response = await fetch(url);
	return await response.text();
}

function upload(){
	const figures = document.querySelector('.table');
	let url = 'http:/app/upload.php';
   let header = `
   <tr>
      <th>№</th>
      <th>Тип фигуры</th>
      <th>Площадь</th>
   </tr>`;

   let getText = getData(url).then(
	data => {
		figures.innerHTML = header + data;
		}
	);
}

upload();
