<html>
    <head>
        <title>Museum</title>
    </head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
			<a href="Application.php" style="font-weight: 300;color: white;font-family: Jost; margin-left:10px; text-decoration: none; ">оставить заявку</a>
			<a href="entry.php" style="font-weight: 300;color: white;font-family: Jost; margin-left:10px; text-decoration: none; ">вход</a>
            <?
                if(isset($_POST['exit']) && empty($_SESSION['login'])) { setcookie(session_name(), " ", time()-3600, "/");
                    session_destroy();
                    header('Location: index.php');}
				if(isset($_COOKIE[session_name()])){
				session_start();
				}
                if($_SESSION['login'] == 'admin'){
                    echo "<a href='expectation.php' style='font-weight: 300;color: white; text-decoration: none;font-family: Jost; margin-left:10px'>ожидают подтверждения</a>";
                    echo "<a href='history.php' style='font-weight: 300;color: white; text-decoration: none;font-family: Jost; margin-left:10px'>история заявок</a>";
                    echo "<input type='submit'  class='btn-flip' name='exit' value='выход' style='font-weight: 300;background-color: #4D4D4D85; color:white; text-decoration: none;font-family: Jost; margin-left:10px'></form>";
                }
				elseif($_SESSION['login'] == 'user'){
					echo "<a href='history.php' style='font-weight: 300;color: white; text-decoration: none;font-family: Jost; margin-left:10px'>история заявок</a>";
                    echo "<form method='post'><input class='btn-flip' type='submit' name='exit' value='выход' style='font-weight: 300;background-color: #4D4D4D85; color:white; text-decoration: none;font-family: Jost; margin-left:10px'></form>";
				}
            ?>
        </header></div>
    </body>
<center>
<?
include "connect.php";
if(mysqli_connect_errno()){
    echo "Error: Ошибка подключения к бд";
    exit();
}
else{
    if($_SESSION['login'] == 'admin'){
        $q = "select * from tbApplication";
        echo "<center><table style='font-size: 15px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'>
        <tr>
            <th>Номер Заявки</th>
            <th>Номер Клиента</th>
            <th>Мероприятие</th>
            <th>Количество участников</th>
            <th>Полная цена</th>
            <th>Дата</th>
            <th>Статус</th>
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
            $table .= "</tr>";
        }
        $table .= "</table>";
        echo $table;
        $result->free();
    } elseif($_SESSION['login'] == 'user'){
        $q = "select idAction, NumClients, FullPrice, Date, Status from tbApplication where idClient =".$_COOKIE['User'];
        echo "<table>
        <tr>
            <th>Мероприятие</th>
            <th>Количество участников</th>
            <th>Полная цена</th>
            <th>Дата</th>
            <th>Статус</th>
        </tr>";
        $result = mysqli_query($link, $q);
        $table = '';
        while($l = mysqli_fetch_assoc($result)){
            $table .= "<tr>";
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
            $table .= "</tr>";
        }
        $table .= "</table>";
        echo $table;
        $result->free();
    }
}
?>
<center>
</html>