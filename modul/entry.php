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
    background: url(IMG/3.png);
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
</style>
<body>
<div style='margin-top: 9px;'><header>
        <form method='post'><center><div id="menu" align='center' style="color:Black;font-size: 24px;"><a href="index.php" style="font-weight: 300;color: white; text-decoration: none;font-family: Jost; margin-left:10px">главная</a>
			<a href="Application.php" style="color: white;font-family: Jost; margin-left:10px; text-decoration: none;font-weight: 300; ">оставить заявку</a>
			<a href="entry.php" style="color: white;font-family: Jost; margin-left:10px; text-decoration: none; font-weight: 300;">вход</a>
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
                    echo "<input type='submit'  class='btn-flip' name='exit' value='выход' style='background-color: #4D4D4D85; color:white; text-decoration: none;font-weight: 300;font-family: Jost; margin-left:10px'></form>";
                }
				elseif($_SESSION['login'] == 'user'){
					echo "<a href='history.php' style='color: white; text-decoration: none;font-family: Jost; font-weight: 300;margin-left:10px'>история заявок</a>";
                    echo "<form method='post'><input class='btn-flip' type='submit' name='exit' value='выход' style='background-color: #4D4D4D85; font-weight: 300;color:white; text-decoration: none;font-family: Jost; margin-left:10px'></form>";
				}
            ?>
        </header></div>
		<center><img style="transform: scale(0.4);margin-top:-70px"src="IMG/logo.png"></center>
        <div class='container' style='margin-top:60px;background-color:#7171716E;color:white;  padding: 10px 50px 10px; font-size: 20px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'><center>
			<form method="post">
        <center><p>
			<big>Вход</big>
            <p style="line-height:0px;margin-left:-290px;">Логин</p> <br><input type="text" name="Login" class="some-input" required="required" style="margin: -20px 0 20px 0;"><br>
            <p style="line-height:0px;margin-left:-280px;">Пароль </p><br><input type="password" name="Password" class="some-input" required="required" style="margin: -20px 0 30px 0;"><br>
        </p>
        <input type="submit" style="border-radius: 5px;font-size: 16px;height:40px;width:110px;background-color: #F0E8D8; color:white; text-decoration: none;font-family: MONTSERRAT; margin-left:100px; color:black; border: none;" value="Войти" name="entry">
		<a onclick="window.location.href = 'register.php'" style="color: #F0E8D8;font-size: 13px; margin-left: 20px"><u>Нет аккаунта?</u></a>
		<center></div>
</body>
</html>

<?
function Authorization($login, $password){
	include "connect.php";
		
	$query = "SELECT idClient, FIO, login, password, role FROM tbClient WHERE login = '$login'";

	$result = mysqli_query($link,$query);
	$result = mysqli_fetch_assoc($result);
		
	if (!empty($result))
	{
		if (password_verify($password, $result["password"]))
		{
			setcookie("User", $result['idClient'], time()+60*60*24*7);
            session_start();
            $_SESSION['login'] = $result["role"];
			return "<br>Добро пожаловать, ".$result["FIO"];
		}
		else 
		{
			header( 'HTTP/1.1 400' );
			return "Неверный пароль";
		}
	}
	else 
	{
		header( 'HTTP/1.1 400' );
		return "Неверный email";
	}
	mysqli_close($link);
}

if(isset($_POST['entry'])){
	if(!empty($_SESSION['login'])){ 
		setcookie(session_name(), " ", time()-3600, "/");
		session_destroy();}
    if (!empty($_POST['Login']) && !empty($_POST['Password']))
	{
		echo Authorization($_POST['Login'], $_POST['Password']);
		header('Location: entry.php');
	}
	else
	{
		header( 'HTTP/1.1 400' );
		echo json_encode(["msg" => "Неверно введены данные"]);
	}
}

?>