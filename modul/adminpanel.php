<html>
    <head>
        <title>Museum</title>
    </head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<style>
    html,
body {
	height: 100%;
}

body {
	margin: 0;
	background: linear-gradient(45deg, #49a09d, #5f2c82);
	font-family: sans-serif;
	font-weight: 100;
    background: url(IMG/2.png);
    background-size: 100%;
}



table {
	width: 800px;
	border-collapse: collapse;
	overflow: hidden;
	box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

th,
td {
	padding: 15px;
	background-color: rgba(0,0,0,0.2);
	color: #fff;
}

th {
	text-align: left;
}

thead {
	th {
		background-color: #55608f;
	}
}

tbody {
	tr {
		&:hover {
			background-color: rgba(0,0,0,0.2);
		}
	}
	td {
		position: relative;
		&:hover {
			&:before {
				content: "";
				position: absolute;
				left: 0;
				right: 0;
				top: -9999px;
				bottom: -9999px;
				background-color: rgba(0,0,0,0.1);
				z-index: -1;
			}
		}
	}
}
.btn-flip
{
  opacity: 1;
  outline: 0;
  /*background-color:#3B3B3B;*/
  color: #3B3B3B;
  line-height: 40px;
  position: relative;
  text-align: center;
  letter-spacing: 1px;
  display: inline-block;
  text-decoration: none;
  font-family: 'Open Sans';
  text-transform: uppercase;
}
</style>
<body>
    <div style='margin-top: 20px;'><header>
        <form method='post'><center><div id="menu" align='center' style="color:Black;font-size: 20px;"><a href="index.php" style="color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px">главная</a>
			<a href="Application.php" style="color: white;font-family: MONTSERRAT; margin-left:10px; text-decoration: none; ">оставить заявку</a>
            <?
                if(isset($_POST['exit']) && empty($_SESSION['login'])) { setcookie(session_name(), " ", time()-3600, "/");
                    session_destroy();
                    header('Location: index.php');}
				if(isset($_COOKIE[session_name()])){
				session_start();
				}
                if($_SESSION['login'] == 'admin'){
                    echo "<a href='expectation.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>ожидают подтверждения</a>";
                   # echo "<a href='history.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>история заявок</a>
				   echo "<a href='addshow.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px;padding: 50px;'>добавить мероприятие</a>";
					echo "<a href='historyshow.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>история заказов</a><br>";
					echo "<a href='history.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>история заявок</a> ";
					echo "<a href='adminpanel.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>административная панель</a>";
                    echo "<input type='submit'  class='btn-flip' name='exit' value='Выход' style='background-color: #4D4D4D85; color:white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'></form>";
                }
				elseif($_SESSION['login'] == 'user'){
					#echo "<a href='history.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>история заявок</a>";
					echo "<a href='historyshow.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>история заказов</a>";
					echo "<a href='history.php' style='color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'>история заявок</a>";
					echo "<form method='post'><input class='btn-flip' type='submit' name='exit' value='Выход' style='background-color: #4D4D4D85; color:white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'></form>";
				}
                else{
					echo "<a href='entry.php' style='color: white;font-family: Jost; margin-left:10px; text-decoration: none; font-weight: 300;'>вход</a>";
                }
            ?>
        </header>
	</div>
	<form method="post">
	<div>
		
		<div>
			
			<?
				include "connect.php";
				if(mysqli_connect_errno()){
					echo "Error: Ошибка подключения к бд";
					exit();
				}
				else{
					if($result=$link->query("select name, price, numberTicket, Status, idAction from tbAction")){
						$id[10];
						$i = 0;
						echo "<div class='container'><center><form method='post'><table style='font-size: 19px;margin-top:10px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'>
							<tr>
								<th>Название</th>
								<th>Цена</th>
								<th>Количество билетов</th>
								<th>Статус</th>
								<th> </th>
							</tr><center></div>";
							$table = "<tr>";
							while($row = $result->fetch_assoc()){
								$j = 0;
								foreach($row as $key => $value){
									if($key == "idAction"){
										$table .= "<td><input type='submit' class='btn-flip' style='background-color: #3B5567; color:white;border-radius: 4px; border-width: 1px;font-family: Jost;' name='edit".$value."' value='Изменить'></td>";
										$table .= "<td><input type='submit' class='btn-flip' style='background-color: #3B5567; color:white;border-radius: 4px; border-width: 1px;font-family: Jost;' name='del".$value."' value='Удалить'></td>";
										$table .= "<td><input type='submit' class='btn-flip' style='background-color: #3B5567; color:white;border-radius: 4px; border-width: 1px;font-family: Jost;' name='res".$value."' value='Восстановить'></td>";
										$id[$i] = $value;
										$i++;
									} 
									else{
										
										if($j == 0){
											$table .= "<td>";
											$table .= "<input type='text' name='name-".$i."' style ='padding: 15px; background-color: rgba(0,0,0,0.2); color: #fff;'value='".$value."'>";
											$table .= "</td>";
											$j++;
										}
										elseif($j == 1){
											$table .= "<td>";
											$table .= "<input type='text' name='price-".$i."' style ='padding: 15px; background-color: rgba(0,0,0,0.2); color: #fff;'value='".$value."'>";
											$table .= "</td>";
											$j++;
										}
										elseif($j == 2){
											$table .= "<td>";
											$table .= "<input type='text' name='tikcets-".$i."' style ='padding: 15px; background-color: rgba(0,0,0,0.2); color: #fff;'value='".$value."'>";
											$table .= "</td>";
											$j++;
										}
										elseif($j == 3){
											if($value == 1){
												$table .= "<td>";
												$table .= "Активен";
												$table .= "</td>";
											}
											else{
												$table .= "<td>";
												$table .= "Неактивен";
												$table .= "</td>";
											}
											$j=0;
										}
									}
								} 
								
								$table .= "</tr>";
							}
							$table .= "</table></form>";
							echo $table;
							
							$result->free();
							foreach($id as $key => $value){
								if(isset($_POST["edit".$value])){
									$ind = array_search($value, $id);
									$name = $_POST['name-'.$ind];
									$price = $_POST["price-".$ind];
									$ticket = $_POST["tikcets-".$ind];
									$q = "update tbAction set name = '$name', price=$price, numberTicket=$ticket  where idAction = $value";
									$result = mysqli_query($link,$q);
									echo $value;
									#header( 'Refresh:1' );
								}
								elseif(isset($_POST["del".$value])){
									$q = "update tbAction set Status = 0 where idAction = $value";
									$result = mysqli_query($link,$q);
									#header( 'Refresh:1' );
								}
								elseif(isset($_POST["res".$value])){
									$q = "update tbAction set Status = 1 where idAction = $value";
									$result = mysqli_query($link,$q);
									#header( 'Refresh:1' );
								}
							}
					}
				
				}
			?>
		</div>
	</div>

	<div>
		<center><span style='font-size:20px; color: white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px'><b>Справочник ролей<b></span></center>
		<div>
		<?
			if($result=$link->query("select FIO, mail, role, idClient from tbClient")){
						$id[10];
						$i = 0;
						echo "<div class='container'><center><form method='post'><table style='font-size: 19px;margin-top:10px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'>
							<tr>
								<th>ФИО</th>
								<th>Mail</th>
								<th>Роль</th>
								<th> </th>
							</tr><center></div>";
							$table = "<tr>";
							while($row = $result->fetch_assoc()){
								foreach($row as $key => $value){
									if($key == "idClient"){
										$table .= "<td><input type='submit' class='btn-flip' style='background-color: #3B5567; color:white;border-radius: 4px; border-width: 1px;font-family: Jost;' name='user".$value."' value='Изменить роль'></td>";
										$id[$i] = $value;
										$i++;
									} 
									else{										
										$table .= "<td>";
                    					$table .= $value;
                    					$table .= "</td>";
										}
									} 
								$table .= "</tr>";
							}
					}
							$table .= "</table></form>";
							echo $table;
							
							$result->free();
							foreach($id as $key => $value){
								if(isset($_POST["user".$value])){
									$q = "update tbClient set role = 'admin' where idClient = $value";
									$result = mysqli_query($link,$q);
								}
							}				
				?>
		</div>
	</div>
	</form>
    </body>
</html>