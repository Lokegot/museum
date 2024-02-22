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
                    header('Location: register.php');}
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
        <p>
            Введите ФИО: <input type="text" name="FIO" required="required"><br>
            Введите Логин: <input type="text" name="Login" required="required"><br>
            Введите Пароль: <input type="text" name="Password" required="required"><br>
            Введите mail: <input type="text" name="Email" required="required"><br>
        </p>
        <input type="submit" value="Зарегистрироваться" name="register">
        </form>
    </body>
</html>
<?
function Registration($fio, $login, $email, $password)
{
    include "connect.php";
    
    $query = "SELECT login FROM tbClient WHERE login = '$login'";
    
    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_array($result);
    
    if (empty($result))
    {
        $query = "INSERT INTO tbClient(FIO, login, mail, password) VALUES ('$fio','$login','$email','".password_hash($password, PASSWORD_DEFAULT)."')";
        $result = mysqli_query($link,$query);
        return "Успешное добавление пользователя";
    }
    else 
    {
        header( 'HTTP/1.1 400' );
        return "Пользователь с таким login уже существует!";
    }
    
    mysqli_close($link);
}

if(isset($_POST['register'])){
    if (!empty($_POST['FIO']) && !empty($_POST['Login']) && !empty($_POST['Email']) && !empty($_POST['Password'])){
        echo Registration($_POST['FIO'], $_POST['Login'],  $_POST['Email'], $_POST['Password']);
    }
    else{
    header( 'HTTP/1.1 400' );
    echo json_encode(["msg" => "Неверно введены данные"]);
    }
}

?>