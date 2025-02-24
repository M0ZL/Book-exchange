<?php
session_start();
$c = $_GET['c'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Главная страница</title>
	<style type="text/css">
		body {
			display: flex;
			flex-direction:  column;
		}
		TABLE.tbl {
		border: 1px solid;
		margin: auto;
		border-spacing: 7px 7px;
	}
		table.tbl TD {
		text-align: center;
		border: 1px solid;
	}
	table.tbl TR {
		text-align: center;
		border: 1px solid;
	}
	</style>
</head>
<body background="images/background.jpg">
	<p align=center><img width="600" height="340" src="images/logobooks.png" /></p>
	<?php
	$digits = 6;
	$filelocation="entercounter.txt";
	if (!file_exists($filelocation)) {
	$newfile = fopen($filelocation,"w+");
	$content=1;
	fwrite($newfile, $content);
	fclose($newfile);
	}
	$newfile = fopen($filelocation,"r");
	$content = fread($newfile, filesize($filelocation));
	fclose($newfile);
	$newfile = fopen($filelocation,"w+");
	if (!$c){
	$content++;
	}
	fwrite($newfile, $content);
	fclose($newfile);
?>

	<div class="container" align = "center">
		
			<div class= "btn-group">
				<div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Новости</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Обратная связь</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">О нас</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Вакансии</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Схема проезда к магазину</button>
				</div><div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Справочная информация</button>
				</div></div>
			
			<div class= "btn-group">
				<div class="btn-group">	
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Доставка</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Сертификаты на продукцию магазина</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Прайс-лист</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Политика конфиденциальности</button>
				</div> <div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">История фирмы</button>
				</div> </div>
		</div>
		
	</div>
	</br></br>

<div id="myCarousel" class="carousel slide" data-ride="carousel" align = "center">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
	<li data-target="#myCarousel" data-slide-to="3"></li>
	<li data-target="#myCarousel" data-slide-to="4"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner ">
    <div class="item active">
      <img src="images/books1.jpg" class='img-rounded' style = "max-height: 480px ; width : 100% ; object-fit: cover; ">
    </div>

    <div class="item">
      <img src="images/books2.jpg" class='img-rounded' style = "max-height: 480px ; width : 100% ; object-fit: cover; " >
    </div>

    <div class="item">
      <img src="images/books3.jpg" class='img-rounded' style = "max-height: 480px ; width : 100% ; object-fit: cover; ">
    </div>

	<div class="item">
      <img src="images/books4.jpg" class='img-rounded' style = "max-height: 480px ; width : 100% ; object-fit: cover; ">
    </div>

	<div class="item">
      <img src="images/books5.jpg" class='img-rounded' style = "max-height: 480px ; width : 100% ; object-fit: cover; ">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div></br>

	<?php
	if(isset($_SESSION['logged_user'])){
		echo '

<div align= "right"> 
		<div class= "btn-group">
		<a href = "Profile.php">
			<button type="button" class="btn btn-primary" >Личный аккаунт</button>
		</a>
		<a href = "Logout.php">
			<button type="button" class="btn btn-link" >Выйти из аккаунта</button>
		</a>
</div>
		</div>
		</br>';
	} else{
		echo '
		<div align= "right"> 
		<div class= "btn-group">
		<a href = "Entry.php">
			<button type="button" class="btn btn-primary" >Вход</button>
		</a>
		<a href = "Registration.php">
			<button type="button" class="btn btn-link" >Регистрация</button>
		</a>
		</div>
		</div>
		</br>';
	}
	?>
	<h2 align=center>Книги для обмена:</br></h2>
	<table class="tbl">
	<?php
	$dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = '';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
	or die ('Ошибка ' . mysqli_error($mysql));
	$query1 = mysqli_query($mysql, "SELECT Name, Image, Image2, Price FROM products LIMIT 0, 3");
	while($row=mysqli_fetch_array($query1))
	{
		echo "<td><b>" .  $row['Name'], "</b></br><br><a href='{$row['Image2']}'><img width='350'  class='img-rounded' height='300' src='{$row['Image']}' /></a></br> Цена: ",
		 $row['Price'], " руб.</br>" . "<br />" . "</td>";
	}
	mysqli_close($mysql);
	?>
	</table><br>

		<button type="button" class="btn btn-primary" onclick="window.location.href = 'Books.php';">Полный список книг для обмена</button>

	<h2 align=center>Последние новости:</br></h2>

	<?php
	$dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = '';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
	or die ('Ошибка ' . mysqli_error($mysql));
	$query1 = mysqli_query($mysql, "SELECT Name_news, Description, Date_news FROM news Order by Date_news desc LIMIT 0, 3");
	while($row=mysqli_fetch_array($query1))
	{
		echo " 
	   <div class='container'>
		<div class='jumbotron'><h2 align = center>

	   " .  $row['Name_news'],"</h2><p>", $row['Description'],"</p><h5 align = right> Дата публикации: ", $row['Date_news'],"</h5>  
	  
</div>
</div>
	   ";
	}
	mysqli_close($mysql);
	?>
<br>


	<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Все новости</button>
	</br>
	<p align=center>Контактная информация:</br>
	Телефон: +7 (928) 2088745 (звонок бесплатный по всей России!)</br>
	Наш режим работы:</br>
	Понедельник:
	10:00 – 18:00</br>
	Вторник:
	10:00 – 18:00</br>
	Среда:
	10:00 – 18:00</br>
	Четверг:
	10:00 – 18:00</br>
	Пятница:
	10:00 – 18:00</br>
	Суббота:
	10:00 – 18:00</br>
	Воскресенье:
	10:00 – 18:00</br>
	<a href = 'index.php'><button type='button' class='btn btn-link' >Вакансии</button></a></br>
	<a href = 'index.php'><button type='button' class='btn btn-link' >Политика конфиденциальности</button></a></br>
	Электронная почта:

    <a href="mailto:BooksForExchange@gmail.com"><span class="glyphicon glyphicon-envelope"></span> Напишите нам!</a>

	</p>
	 <footer><? echo "Сайт посетили уже ".sprintf ("%0"."$digits"."d",$content)." человек!";?></footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>