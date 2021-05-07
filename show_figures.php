<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="css/index.css">
      <title>Список фигур</title>
   </head>
   <body>
      <div class="home" style="padding:5px;">
      	<a class="button" href="/">Домой</a>
      </div>
      <div class="update" style="padding:5px;">
         <!-- <a class="button" onclick="clickMy();" href="">Обновить</a> -->
         <button class="update" onclick="upload();" type="button" name="update">Обновить</button>
      </div>
      <div class="figures">
         <table class="table">
            <!-- здесь булет выводиться список фигур в таблице с помощью ajax-запроса -->
         </table>
      </div>
      <script type="text/javascript" src="scripts/upload.js"></script>

   </body>
</html>
