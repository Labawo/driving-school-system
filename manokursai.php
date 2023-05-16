<?php
// operacija3.php  Parodoma registruotų vartotojų lentelė

session_start();
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location: logout.php");exit;}

?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Kursanto kursų sąrašas</title>
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
			//$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$sql = "SELECT ". TBL_LEAR .".id,pavadinimas,data,data_iki,vietu_sk,aprasas,kaina,tipo_pavadinimas,".TBL_LECT.".vardas,".TBL_LECT.".pavarde,uzdarytas "
				. " FROM ". TBL_CONN
				. " RIGHT JOIN ".TBL_STUD. " ON ".TBL_CONN. ".kursanto_ak=". TBL_STUD.".asmens_kodas"
				. " AND ".TBL_STUD.".id='".$_SESSION['userid']."'"
				. " LEFT JOIN ".TBL_LEAR. " ON ".TBL_CONN. ".kurso_id=".TBL_LEAR. ".id"
				. " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
				. " LEFT JOIN ". TBL_LECT . " ON " .TBL_LEAR. ".destytojas=" . TBL_LECT .".asmens_kodas"
				. " WHERE trim(".TBL_LEAR.".id) != \"\""
				. " AND pavadinimas='$pavadinimas'";
				//echo $sql;
				$result = mysqli_query($db, $sql);
				if (!$result || (mysqli_num_rows($result) < 1))  
				{echo "Nera pasirinktu kursu"; exit;}
		}
		else{
			//$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$sql = "SELECT ". TBL_LEAR .".id,pavadinimas,data,data_iki,vietu_sk,aprasas,kaina,tipo_pavadinimas,".TBL_LECT.".vardas,".TBL_LECT.".pavarde,uzdarytas "
				. " FROM ". TBL_CONN
				. " RIGHT JOIN ".TBL_STUD. " ON ".TBL_CONN. ".kursanto_ak=". TBL_STUD.".asmens_kodas"
				. " AND ".TBL_STUD.".id='".$_SESSION['userid']."'"
				. " LEFT JOIN ".TBL_LEAR. " ON ".TBL_CONN. ".kurso_id=".TBL_LEAR. ".id"
				. " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
				. " LEFT JOIN ". TBL_LECT . " ON " .TBL_LEAR. ".destytojas=" . TBL_LECT .".asmens_kodas"
				. " WHERE trim(".TBL_LEAR.".id) != \"\"";
				//echo $sql;
				$result = mysqli_query($db, $sql);
				if (!$result || (mysqli_num_rows($result) < 1))  
				{echo "Nera pasirinktu kursu"; exit;}
		}
				
		?> 
		
		<?php

		if(isset($_POST['edit'])){
			$kursid = $_POST["edit"][1];
			$sql = "SELECT asmens_kodas FROM ".TBL_STUD." WHERE id = '".$_SESSION['userid']."'";
			$result = mysqli_query($db, $sql);
			$asmens= null;
			if (!$result || (mysqli_num_rows($result) != 1))   // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
				{  // neradom vartotojo DB
					$_SESSION['name_error']=
					"<font size=\"2\" color=\"#ff0000\">* Tokio stud nėra</font>";
				}
			else{
				$row = mysqli_fetch_assoc($result);
				$asmens = $row["asmens_kodas"];
				$sql = "DELETE FROM " .TBL_CONN ." WHERE kursanto_ak = '$asmens' AND kurso_id = '$kursid'";
				if (!mysqli_query($db, $sql))  die ("Klaida trinant:" .mysqli_error($db));
				else{
					$sql = "UPDATE " .TBL_LEAR ." SET vietu_sk = vietu_sk + 1 WHERE id = '$kursid'";
					if (!mysqli_query($db, $sql))  die ("Klaida pridedant vietu sk:" .mysqli_error($db));
					else{
						header("Location: manokursai.php");
						exit;
					}
				}
				
			}	
		}

		?>

        <center><font size="5">Mano registruotų kursų lentelė</font></center><br>
		
    <table class="center" border="1" cellspacing="0" cellpadding="3">
		<tr><td><b>Pavadinimas</b></td><td><b>Data</b></td><td><b>Data iki</b></td><td><b>Vietų sk.</b></td><td><b>Aprašas</b></td><td><b>Kaina</b></td><td><b>Tipas</b></td><td><b>Dėstytojas</b></td></tr>
<?php
        while($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['id'];	 
	    $name=$row['pavadinimas']; 
	  	$date= $row['data'];
		$datetill= $row['data_iki'];
		$space=$row['vietu_sk'];
		$about=$row['aprasas'];
		$price=$row['kaina'];
		$type=$row['tipo_pavadinimas'];
		$lname=$row['vardas'];
		$last=$row['pavarde'];
		    echo "<tr><td>".$name. "</td><td>";    
 			echo $date;
			echo "</td><td>";
			echo $datetill."</td><td>";
			echo $space."</td><td>";
			echo $about."</td><td>";
			echo $price."</td><td>";
			echo $type."</td><td>";
		    echo $lname." ".$last."</td>"; 
			echo "<form method=\"post\" onSubmit=\"return confirm('Are you sure?');\"> <td> <input type=\"submit\" name=\"edit[]\", value=\"Atsisakyti\"> <input type=\"hidden\" name=\"edit[]\" value=\"".$id."\" > </td></form></tr>";
      		
	}
 ?>
	  </table>
  </body></html>


