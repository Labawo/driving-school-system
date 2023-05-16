<?php
// operacija3.php  Parodoma registruotų vartotojų lentelė

session_start();
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location: logout.php");exit;}

?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Kursantų sąrašas</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <table class="center" ><tr><td>
            <center><img src="include/top.png" width="500" height="200"></center>
        </td></tr><tr><td>
			 
 		<?php
			include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę			
 		?> 
		</table>
		
		<form method='post'>
				Pasirinkti pagal kokios kategorijos kursus žiūreti:
				<select name="pavad">
					<?php
					include("include/nustatymai.php");
					$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
					$sql = "SELECT pavadinimas "
            		. "FROM " . TBL_LEAR 
					. " GROUP BY pavadinimas"
					. " ORDER BY pavadinimas";
					$result = mysqli_query($db, $sql);
					
					while ($row = mysqli_fetch_assoc($result)){
						$name = $row['pavadinimas'];
						echo "<option value=\"$name\">" . $row['pavadinimas'] . "</option>";
					}
					?>
				</select>
				<div>
					<input type='submit' name='ok' value='Perziureti'>
				</div>
		</form>

		<?php
		if (isset($_POST["ok"])){
			$pavadinimas = $_POST['pavad'];
			$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$sql = "SELECT ".TBL_STUD.".vardas,".TBL_STUD.".pavarde,telefono_nr,pavadinimas,amzius,kaina "
            . "FROM " . TBL_CONN 
			. " LEFT JOIN ". TBL_STUD. " ON ".TBL_CONN.".kursanto_ak=".TBL_STUD.".asmens_kodas"
			. " LEFT JOIN ". TBL_LEAR. " ON ".TBL_CONN.".kurso_id=".TBL_LEAR.".id"
            . " LEFT JOIN ". TBL_LECT. " ON ".TBL_LEAR.".destytojas=".TBL_LECT.".asmens_kodas"
			. " WHERE pavadinimas='$pavadinimas'"
            . " AND ".TBL_LECT.".id='".$_SESSION['userid']."'"
			. " ORDER BY amzius";
			$result = mysqli_query($db, $sql);
			if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Kursantu siame kurse nera"; exit;}
		} else{
			$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$sql = "SELECT ".TBL_STUD.".vardas,".TBL_STUD.".pavarde,telefono_nr,pavadinimas,amzius,kaina "
            . "FROM " . TBL_CONN 
			. " LEFT JOIN ". TBL_STUD. " ON ".TBL_CONN.".kursanto_ak=".TBL_STUD.".asmens_kodas"
			. " LEFT JOIN ". TBL_LEAR. " ON ".TBL_CONN.".kurso_id=".TBL_LEAR.".id"
            . " LEFT JOIN ". TBL_LECT. " ON ".TBL_LEAR.".destytojas=".TBL_LECT.".asmens_kodas"
            . " WHERE ".TBL_LECT.".id='".$_SESSION['userid']."'"
			. " ORDER BY amzius";
			$result = mysqli_query($db, $sql);
			if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Kursantu siame kurse nera"; exit;}
		}
			
		?>

        <center><font size="5">Dabar yra tokia registruotų kursantų lentelė</font></center><br>
		
    <table class="center" border="1" cellspacing="0" cellpadding="3">
		<tr><td><b>Vardas</b></td><td><b>Pavardė</b></td><td><b>Telefonas</b></td><td><b>Amžius</b></td><td><b>Kurso pavadinimas</b></td><td><b>Kurso kaina</b></td></tr>
<?php
    $sum = 0;
    while($row = mysqli_fetch_assoc($result)) 
	{	 
	    $name=$row['vardas']; 
	  	$lname= $row['pavarde'];
		$cell=$row['telefono_nr'];
		$course=$row['pavadinimas'];
		$age=$row['amzius'];
        $price=$row['kaina'];
		    echo "<tr><td>".$name. "</td><td>";    
 			echo $lname;
			echo "</td><td>";
			echo $cell."</td><td>";
			echo $age."</td><td>";
            echo $course."</td><td>";
		    echo $price."</td></tr>";
        $sum = $sum + $price;       		
	}
    
 ?>
	  </table>
  </body></html>


<?php
    echo "<h3>Galutine suma: ".$sum." Eurai.</h3>";
?>