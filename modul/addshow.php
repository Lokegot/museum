<html>
    <head>
        <title>Museum</title>
    </head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css.css">
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
    background: url(IMG/4.png);
    background-size: 100%;
}

.container {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
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
	background-color: rgba(255,255,255,0.2);
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
			background-color: rgba(255,255,255,0.2);
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
				background-color: rgba(255,255,255,0.1);
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
.some-input {
  border: none;
  border-bottom: 1px solid white;
  background-color: transparent;
  color: inherit;
  outline: none;
  width: 350px;
}
.some-input1 {
  border: none;
  border-bottom: 1px solid white;
  background-color: transparent;
  color: inherit;
  outline: none;
  width: 350px;
  height: 30px;
  border: none;
}

option{
	color:#fff;
	background: #7171716E;
    border-radius: none;
  height: 30px;
}
</style>
<body>
<div style='margin-top: 9px;'><header>
        <form method='post'><center><div id="menu" align='center' style="color:Black;font-size: 24px;"><a href="index.php" style="font-weight: 300;color: white; text-decoration: none;font-family: Jost; margin-left:10px">главная</a>
			<a href="Application.php" style="color: white;font-family: Jost; margin-left:10px; text-decoration: none;font-weight: 300; ">оставить заявку</a>
            <?
                if(isset($_POST['exit']) && empty($_SESSION['login'])) { setcookie(session_name(), " ", time()-3600, "/");
                    session_destroy();
                    header('Location: index.php');}
				if(isset($_COOKIE[session_name()])){
				session_start();
				}
                if($_SESSION['login'] == 'admin'){
                    echo "<a href='expectation.php' style='color: white; text-decoration: none;font-family: Jost; margin-left:10px;font-weight: 300;'>ожидают подтверждения</a>";
                    echo "<a href='history.php' style='color: white; text-decoration: none;font-family: Jost; margin-left:10px; font-weight: 300;'>история заявок</a>";
                    echo "<a href='adminpanel.php' style='color: white; text-decoration: none;font-family: Jost; margin-left:10px; font-weight: 300;'>административная панель</a>";
                    echo "<input type='submit'  class='btn-flip' name='exit' value='выход' style='background-color: #4D4D4D85; color:white; text-decoration: none;font-weight: 300;font-family: Jost; margin-left:10px'></form>";
                }
				elseif($_SESSION['login'] == 'user'){
					echo "<a href='history.php' style='color: white; text-decoration: none;font-family: Jost; font-weight: 300;margin-left:10px'>история заявок</a>";
                    echo "<form method='post'><input class='btn-flip' type='submit' name='exit' value='выход' style='background-color: #4D4D4D85; font-weight: 300;color:white; text-decoration: none;font-family: Jost; margin-left:10px'></form>";
				}
                else{
                    echo "<a href='entry.php' style='color: white;font-family: Jost; margin-left:10px; text-decoration: none; font-weight: 300;'>вход</a></form>";
                }
            ?>
        </header></div>
        <center><img style="transform: scale(0.4);margin-top:-70px"src="IMG/logo.png"></center>
        <div class='container' style='margin-top:50px;background-color:#7171716E;color:white; padding: 15px 50px 5px; font-size: 20px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'><center>
            <form method="post">
                <big>Добавить Мероприятие</big>
                 <p style="line-height:0px;margin-left:-230px;margin-top:25px">Мероприятие</p> 
                 <br><input type='text'  name = 'Action' class="some-input" value="Введите название выставки" style="margin: -15px 5px 10px">
		         <br> 
            <p style="line-height:0px;margin-left:-150px;">Количество билетов</p><br> <input pattern='^[0-9\s]+$' type="text" name="Ticket" value=1 class="some-input" required="required" style="margin:-15px 0 10px;"> <br>
            <p style="line-height:0px;margin-left:-305px;">Цена</p><br><input type="text" pattern='^[0-9\s]+$' name="Price" class="some-input"  value="100" required="required" style="margin: -15px 0 10px;"> <br><br>
            <input type="submit" name="commit" style="border-radius: 5px;font-size: 15px;height:35px;width:310px;background-color: #184A5F; color:#F6FCFF; text-decoration: none;font-family: MONTSERRAT;  border: none;" value="Добавить Мероприятие">
            <?
            if(isset($_POST['commit'])) echo setApplication()?>
        </form><center></div>
    </body>
</html>
<?
function setApplication(){
    include "connect.php";
    $action = $_POST['Action'];
    $price = $_POST['Price'];
    $ticket = $_POST['Ticket'];
    $q = "insert into tbAction(Name, Price, NumberTicket) values ('$action', $price, $ticket)";
    mysqli_query($link, $q);
    return "Мероприятие добавлено";
}
?>