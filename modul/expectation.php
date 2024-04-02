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
                else{
                    echo "<a href='entry.php' style='color: white;font-family: MONTSERRAT; margin-left:10px; text-decoration: none; '>Вход</a>";
                }
            ?>
        </header></div>

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
        echo "<center><img style='transform: scale(0.4);margin-top:-50px' src='IMG/logo.png'></center><center><form method='post'><table style='font-size: 17px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'>
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
        </tr><center>";
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
            $table .= "<td><input type='submit' style=' width: 40px; height: 30px;border-radius: 2px; border:none;background-color: #3B5567; color:white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px' value='OK' name='Y_".$l['idApplication']."'></td>";
            $id[$i] = "Y_".$l['idApplication'];
            $i++;
            $table .= "<td><input type='submit' style=' width: 40px; height: 30px;border-radius: 2px; border:none;background-color: #3B5567; color:white; text-decoration: none;font-family: MONTSERRAT; margin-left:10px' value='OK' name='N_".$l['idApplication']."'></td>";
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