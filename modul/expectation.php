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
include "connect.php";
if(mysqli_connect_errno()){
    echo "Error: Ошибка подключения к бд";
    exit();
}
else{
    if($_SESSION['login'] == 'admin'){
        $id[100];
        $i = 0;
        $q = "select * from tbApplication where Status = 1";
        echo "<form method='post'><table>
        <tr>
            <th>Номер Заявки</th>
            <th>Номер Клиента</th>
            <th>Мероприятие</th>
            <th>Количество участников</th>
            <th>Полная цена</th>
            <th>Дата</th>
            <th>Статус</th>
            <th>Принять заявку</th>
            <th>Отклонить заявку</th>
        </tr>";
        $result = mysqli_query($link, $q);
        $table = '';
        while($l = mysqli_fetch_assoc($result)){
            $table .= "<tr>";
            $table .= "<td>".$l['idApplication']."</td>";
            $table .= "<td>".$l['idClient']."</td>";
            $q1 = "select Name from tbAction where idAction = ".$l['idAction'];
            $res = mysqli_query($link, $q1);
            $tRes = mysqli_fetch_assoc($res);
            $table .= "<td>".$tRes['Name']."</td>";
            $table .= "<td>".$l['NumClients']."</td>";
            $table .= "<td>".$l['FullPrice']."</td>";
            $table .= "<td>".$l['Date']."</td>";
            $q1 = "select statusName from tbStatus where idStatus = ".$l['Status'];
            $res = mysqli_query($link, $q1);
            $tRes = mysqli_fetch_assoc($res);
            $table .= "<td>".$tRes['statusName']."</td>";
            $table .= "<td><input type='submit' value='OK' name='Y_".$l['idApplication']."'></td>";
            $id[$i] = "Y_".$l['idApplication'];
            $i++;
            $table .= "<td><input type='submit' value='OK' name='N_".$l['idApplication']."'></td>";
            $id[$i] = "N_".$l['idApplication'];
            $i++;    
            $table .= "</tr>";
        }
        $table .= "</table></form>";
        echo $table;
        $result->free();
        foreach($id as $key => $value){
            #echo $value;
            if(isset($_POST[$value])){
                $value = $value.str_split("_");
                if($value[0] == "N"){
                    $q = "update tbApplication set Status = 3 where idApplication = ". $value[2];
                    mysqli_query($link, $q);
                }
                else{
                    $q = "update tbApplication set Status = 2 where idApplication = ". $value[2];
                    mysqli_query($link, $q);
                    $q = "select idAction, NumClients from tbApplication where idApplication = ". $value[2];
                    $res = mysqli_query($link, $q);                    
                    $tRes = mysqli_fetch_assoc($res);
                    $countC = $tRes['NumClients'];
                    $idA = $tRes['idAction'];
                    $q = "select NumberTicket from tbAction where idAction = ".$idA;
                    $res = mysqli_query($link, $q);                    
                    $tRes = mysqli_fetch_assoc($res);
                    $sum = $tRes['NumberTicket'] - $countC;
                    $q = "update tbAction set NumberTicket = $sum where idAction = ".$idA;
                    $res = mysqli_query($link, $q);
                }
                header("Location: expectation.php");
            }
        }
    }
}
?>