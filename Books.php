<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html;
charset=utf-8">
<title>Полный список книг для обмена</title>
<style type="text/css">
    TABLE.tbl {
    border: 1px solid;
    margin-left: 50px;
    border-spacing: 7px 7px;
   }
    table.tbl TD {
      text-align: center;
      border: 1px solid;
   }
   div.g {
	float:left;
   }
  </style>
</head>
<body background="images/background.jpg">
<p align=center><img width="600" height="340" src="images/logobooks.png" /></p>
<h2 align=center>
<?php
if($_POST['buy']) {
	unset($_SESSION['count_p']);
	echo "<p align='center'><span style='font-size: 20px; color: black; border: 1px solid red;'>Спасибо за покупку!</span></p>";
	}
?>
Полный список книг для обмена:</br></h2>
 <div class="g">
<form action='' method='POST'>
    <table class="tbl">
	<?php
	$dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = '';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
	or die ('Ошибка ' . mysqli_error($mysql));
	$query1 = mysqli_query($mysql, "SELECT id_product, Name, Image, Image2, Price, Count FROM products");
	while($row=mysqli_fetch_array($query1))
	{
		if($row['Image'] == '/images/banan.jpg'){
			$i++;
			if($row['Count'] > 0){
			echo "<td><b>" . $row['Name'], "</b></br><br><img width='350' class='img-rounded' height='300' src='{$row['Image']}' alt='Бананы' title='Бананы'/></br> Цена: ", 
			$row['Price'], " руб.</br>", "<label for='counp'>Укажите количество товара:</label><br ><input type='number' value='' name='counp[]' min='0' max='{$row['Count']}' size='20' step='any'></br></br>", "<input  value='{$row['id_product']}' type='checkbox' name='id[]' >"."<input type='hidden' name='tex[]' value='{$row['Name']}'>" . "</br>В наличии: есть" . "</td>";
			}else{
				echo "<td><b>" . $row['Name'], "</b></br><br><img width='350' class='img-rounded' height='300' src='{$row['Image']}' alt='Бананы' title='Бананы'/></br> Цена: ", 
			$row['Price'], " руб.</br>", "<input  value='{$row['id_product']}' type='checkbox' name='id[]' >" ."<input type='hidden' name='tex[]' value='{$row['Name']}'>". "</br>В наличии: нет" . "</td>";
			}
			if ($i%3==0)
            echo '</tr><tr>';
		} else{
			$i++;
			if($row['Count'] > 0){
			echo "<td><b>" . $row['Name'], "</b></br><br><a href='{$row['Image2']}'><img width='350' class='img-rounded' height='300' src='{$row['Image']}' /></a></br> Цена: ", 
			$row['Price'], " руб.</br>", "<label for='counp'>Укажите количество товара:</label><br><input type='number' value='' name='counp[]' min='0' max='{$row['Count']}' size='20' step='any'></br></br>", "<input  value='{$row['id_product']}' type='checkbox' name='id[]' >" ."<input type='hidden' name='tex[]' value='{$row['Name']}'>". "</br>В наличии: есть" . "</td>";
			}else{
				echo "<td><b>" . $row['Name'], "</b></br><br><a href='{$row['Image2']}'><img width='350' class='img-rounded' height='300' src='{$row['Image']}' /></a></br> Цена: ", 
			$row['Price'], " руб.</br>", "<input  value='{$row['id_product']}' type='checkbox' name='id[]' >" ."<input type='hidden' name='tex[]' value='{$row['Name']}'>". "</br>В наличии: нет" . "</td>";
			} 
			if ($i%3==0)
            echo '</tr><tr>';
		}
    }
	mysqli_close($mysql);
	?>
	<div align="center">
	<a href = "SubmitRequest.php">
			<button type="button" class="btn btn-link" >Оформление заявки</button>
		</a>
	</div>
	<?php if(!$_POST['add']) { ?>
 <div class="g" style='background: grey;  width: 200px; position: absolute; right: 1%; color: white;'>Оформление заказа</div>
 <?php }?>
 <?php

	$dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = '';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
	or die ('Ошибка ' . mysqli_error($mysql));
	
	if($_POST['clear']) {
	}

	if($_POST['add']) {
	$all = count ($_POST['id']);
	echo "<div class='g' style='background: grey;  width: 200px; position: absolute; right: 1%; color: white;'>Оформление заказа. Количество выбранных продуктов: 
	</br></br><span style=' color: blue;'>";
	
	if(isset($_SESSION['logged_user'])){

	$result= "<p><a href='#'>".$_POST['id'][$i]."</a></p>"; 
		//$str='INSERT INTO `orders`( `id_product`, `Count`, `id_visitor`, `Date_order`) VALUES ';
		$add_card='INSERT INTO `card`(`id`, `id_visitor`, `id_product`, `countp`) VALUES ';
		$i=0;
	//	while($i<count($_POST['id'])){
			//$str.='(`'.$_POST['id'][$i].'`,`5`,'. $_SESSION['acc_id'] . ',`'.date("d-m-Y").'`),';
			for($i1=0;$i1<count($_POST['counp']);$i1++){
				if($_POST['counp'][$i1]!=""){
					$add_card.='(NULL,' . $_SESSION['acc_id'] . ','.$_POST['id'][$i].',' . $_POST['counp'][$i1]. '),';
				$i++;
				}
			}
			
			
	//	}
		//$str=trim($str,',');
		$add_card=trim($add_card, ',');
		//print_r($str);
		//print_r($add_card);

	$query = mysqli_query($mysql, $add_card);
	mysqli_close($mysql);

	echo $all;
	
	
}
	echo "</br></br><form method='POST'><div class='g' style='background: grey;  width: 200px; position: absolute; right: 0%; color: white;'>
	Виды доставки (если необходимо):</br></br>
	<input type='radio' name='d' ><label>Курьером по городу</label>
	<label>Адрес:</label>
	<input type = 'text' class='form-control' name='address' size='20' step='any'></br>
	<input type='radio' name='d1' ><label>Доставка почтой</label></br>
	<label>Адрес:</label>
	<input type = 'text' class='form-control' name='address' size='20' step='any'></br></br>
	<input type='submit' class= 'btn btn-primary' name='buy' value='Оформить заказ'> </br>(оплата наличными или картой при получении товара или онлайн по карте)
	</div></form>";
	echo "</span></div>";
}
 ?>
	</table><br><br>

	<?php if(isset($_SESSION['logged_user'])){ ?>
	<div align="center">
	
	<input type='submit' class= 'btn btn-primary' name='add' value='Добавить книги в заказ'><br><br>
	<input type='submit' class= 'btn btn-primary' name='clear' value='Удалить книги из заказа'><br><br><br></div>
	<?php } ?>
	</p>
	<div align=center>
	<?php
	$dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = '';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
	or die ('Ошибка ' . mysqli_error($mysql));
		if(!empty($_SESSION['acc_user'])){
			echo "<p align=center><a href = 'AddProduct.php'>Добавить новую книгу</a><br><br>
			<a href = 'EditProduct.php'>Редактировать данные о книгах</a><br>";
			echo "<form action='Products.php'  method='post'><div align=center> 
			<table>
			<tr>
			<td >Список:<br><select class='form-control' name='list' size='1'>";
			
			$stmt = mysqli_query($mysql, "SELECT * FROM products");
			while ($row = mysqli_fetch_array($stmt))
				echo '<option value="' . $row["id_product"] . '">' . $row["id_product"] ." ". $row["Name"] ." ". $row["Price"] ." ". $row["Count"] . '</option>';
			echo "</select><br><br>";
			
			$list =$_POST["list"];
			if (isset($_POST['delete'])) {
				$strSQL2 = mysqli_query($mysql, "DELETE FROM `products` WHERE id_product = $list") 
				or die (mysqli_error($mysql));
			}
			
			echo "</td>
			</tr>
			</table>
			<div align='center'><input type='submit' class= 'btn btn-primary' style='width:210px' name='delete'
			value='Удалить данные о книге'></div>
			</div></form>";
		}
	mysqli_close($mysql);
	?>
	
	<a href = 'index.php'><button type='button' class='btn btn-link' >На главную страницу</button></a>
	</p></div>
	</form><br>
	<div align="center">
    <p>Контактная информация:</br>
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
	Электронная почта: 
	<a href="mailto:BooksForExchange@gmail.com"><span class="glyphicon glyphicon-envelope"></span> Напишите нам!</a>
	</p>
	</div>
</body>
</html>