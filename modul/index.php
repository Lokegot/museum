<html>
    <head>
        <title>Museum</title>
    </head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css.css">
<body>
        <header>
        <form method='post'><center><div align='center' style="color:Black;font-size: 20px;"><a href="index.php" style="color: Black;font-family: MONTSERRAT; margin-left:10px">Главная</a>
			<a href="Application.php" style="color: Black;font-family: MONTSERRAT; margin-left:10px ">Оставить заявку</a>
			<a href="entry.php" style="color: Black;font-family: MONTSERRAT; margin-left:10px ">Вход</a>
            <?
                if(isset($_POST['exit']) && empty($_SESSION['login'])) { setcookie(session_name(), " ", time()-3600, "/");
                    session_destroy();
                    header('Location: index.php');}
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

    </body>
</html>
<?
function sCookie($id){
    setcookie("idAction", $id, time()+60*60*24*7);
}

include "connect.php";
if(mysqli_connect_errno()){
    echo "Error: Ошибка подключения к бд";
    exit();
}
else{
    if($result=$link->query("select name, price, numberTicket, idAction from tbAction")){
        $id[10];
        $i = 0;
        echo "<center><form method='post'><table>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество билетов</th>
                <th> </th>
            </tr><center>";
            $table = "<tr>";
            while($row = $result->fetch_assoc()){
                foreach($row as $key => $value){
                    if($key == "idAction"){
                        $table .= "<td><input type='submit' style='background-color: #D4CEDF; border-radius: 4px; border-width: 1px;' name='".$value."' value='Оставить заявку'>";
                        $id[$i] = $value;
                        $i++;
                    } 
                    else{$table .= "<td>";
                    $table .= $value;
                    $table .= "</td>";
                    }
                } 
                
                $table .= "</tr>";
            }
            $table .= "</table></form>";
            echo $table;
            $result->free();
            foreach($id as $key => $value){
                if(isset($_POST[$value])){
                    sCookie($value);
                    header("Location: Application.php");
                }
            }
    }

}



?>