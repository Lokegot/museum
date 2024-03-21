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
                    header('Location: application.php');}
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
        <center><form method="post">
            Выберете мероприятие: <select name = 'Action' value="Action" style="margin: 5px 0;"><?
				setInfo();?>
		    </select> <br> 
            Количество участников: <input type="text" name="NumClient" value=1 required="required" style="margin: 3px 0;"> <br>
            Дата: <input type="date" name="date" value="09.01.2024" required="required" style="margin: 5px 0;"> <br>
            <input type="submit" name="commit" style="background-color: #D4CEDF; border-radius: 4px; border-width: 1px;" value="Отправить заявку для рассмотрения">
            <?
            if(isset($_POST['commit'])) setApplication()?>
        </form><center>
    </body>
</html>
<?

function setInfo(){
    include "connect.php";
    if(!empty($_COOKIE["idAction"])){
        $query = "select idAction, Name from tbAction where idAction =".$_COOKIE['idAction'];
        $result = mysqli_query($link, $query);
        $l = mysqli_fetch_assoc($result);
        echo "<option  value ='".$l['idAction']."'>".$l['Name']."</option>";
        $query = "select idAction, Name from tbAction where idAction <> ".$_COOKIE['idAction'];
        $result = mysqli_query($link, $query);
        while($link = mysqli_fetch_assoc($result)){
            echo "<option class='dropdown-item' value ='".$link['idAction']."'>".$link['Name']."</option>";
        }

    }
    else{
        $query = "select idAction, Name from tbAction";
        $result = mysqli_query($link, $query);
        while($link = mysqli_fetch_assoc($result)){
            echo "<option class='dropdown-item' value ='".$link['idAction']."'>".$link['Name']."</option>";
        }
    }
}
function setApplication(){
    include "connect.php";
    $selectValue = $_POST['Action'];
    $q = "select idAction, Price from tbAction where idAction = '$selectValue'";
    $result = mysqli_query($link, $q);
    $s = mysqli_fetch_assoc($result);
    $price = $s['Price'];
    $idAction = $s['idAction'];
    $idUser = $_COOKIE['User'];
    $date = $_POST['date'];
    $date = date_format(date_create($date), "Y-m-d");
    $countCl = $_POST['NumClient'];
    $fullPrice = $countCl*$price;
    echo "price = $price
    idAction = $idAction
        idUser = $idUser
        date = $date
        countCl = $countCl
        fullPrice = $fullPrice";
    $q = "insert into tbApplication(idClient, idAction, NumClients, FullPrice, Date, Status) values ($idUser, $idAction, $countCl, $fullPrice, '$date', 1)";
    mysqli_query($link, $q);
}
?>