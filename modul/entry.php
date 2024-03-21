<html>
    <head>
        <title>Museum</title>
    </head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<body>
        <header>
        <form method='post'><center><div align='center' style="color:Black;font-size: 20px;"><a href="index.php" style="color: Black;font-family: MONTSERRAT; margin-left:10px">Главная</a>
			<a href="Application.php" style="color: Black;font-family: MONTSERRAT; margin-left:10px ">Оставить заявку</a>
			<a href="entry.php" style="color: Black;font-family: MONTSERRAT; margin-left:10px ">Вход</a>
            <?
                if(isset($_POST['exit']) && empty($_SESSION['login'])) { setcookie(session_name(), " ", time()-3600, "/");
                    session_destroy();
                    header('Location: entry.php');}
				if(isset($_COOKIE[session_name()])){
				session_start();
				}
                if($_SESSION['login'] == 'admin'){
                    echo "<a href='expectation.php' style='color: Black;font-family: MONTSERRAT; margin-left:10px'>Ожидают подтверждения</a>";
                    echo "<a href='history.php' style='color: Black;font-family: MONTSERRAT; margin-left:10px'>История заявок</a>";
                    echo "<input type='submit' name='exit' value='Выход' style='color: Black;font-family: MONTSERRAT; margin-left:10px'></form>";
                }
				elseif($_SESSION['login'] == 'user'){
					echo "<a href='history.php' style='color: Black;font-family: MONTSERRAT; margin-left:10px'>История заявок</a>";
                    echo "<form method='post'><input type='submit' name='exit' value='Выход' style='color: Black;font-family: MONTSERRAT; margin-left:10px'></form>";
				}
            ?>
        </header>
        <form method="post">
        <center><p>
            Введите Логин: <input type="text" name="Login" required="required" style="margin: 5px 0;"><br>
            Введите Пароль: <input type="password" name="Password" required="required" style="margin: 5px 0;"><br>
        </p>
        <input type="submit" style="background-color: #D4CEDF; border-radius: 4px; border-width: 1px;" value="Вход" name="entry">
        <input type="button" style="background-color: #D4CEDF; border-radius: 4px; border-width: 1px;" value="Регистрация" onclick="window.location.href = 'register.php'">
    <center></body>
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