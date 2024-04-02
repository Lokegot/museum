<html>
    <head>
        <title>Museum</title>
    </head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
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
            <center><img style="transform: scale(0.4);margin-top:-40px"src="IMG/logo.png"></center>
        </header></div>

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
        echo "<div class='container'><center><form method='post'><table style='font-size: 19px;margin-top:-10px; border-radius: 20px;backdrop-filter: blur(5px); font-family: Jost;font-weight: 300;'>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество билетов</th>
                <th> </th>
            </tr><center></div>";
            $table = "<tr>";
            while($row = $result->fetch_assoc()){
                foreach($row as $key => $value){
                    if($key == "idAction"){
                        $table .= "<td><input type='submit' class='btn-flip' style='background-color: #3B5567; color:white;border-radius: 4px; border-width: 1px;' name='".$value."' value='Оставить заявку'>";
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