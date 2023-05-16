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
					$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
					$sql = "SELECT pavadinimas,tipo_pavadinimas,data,data_iki "
					. "FROM " . TBL_LEAR . " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
					. " WHERE destytojas=( SELECT asmens_kodas FROM ".TBL_LECT." WHERE ".TBL_LECT.".id='".$_SESSION['userid']."')" 
					. " AND pavadinimas='$pavadinimas'"
					. " ORDER BY pavadinimas desc";

					$result = mysqli_query($db, $sql);

					if (!$result || (mysqli_num_rows($result) < 1))  
					{
						//echo $sql; 
						echo " Laikų su šia kategorija nėra"; exit;}
				}
				else{
					$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
					$sql = "SELECT pavadinimas,tipo_pavadinimas,data,data_iki,destytojas "
					. "FROM " . TBL_LEAR . " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id" 
					. " WHERE destytojas=( SELECT asmens_kodas FROM ".TBL_LECT." WHERE ".TBL_LECT.".id='".$_SESSION['userid']."')"
					. " ORDER BY pavadinimas desc"
					;

					$result = mysqli_query($db, $sql);

					if (!$result || (mysqli_num_rows($result) < 1))  
					{echo $sql; echo " Klaida skaitant lentelę kursai"; exit;}
				}
		?> 
		
		
        <center><font size="5">Vedamų kursų lentelė</font></center><br>
		
    <table class="center" border="1" cellspacing="0" cellpadding="3">
		<tr><td><b>Pavadinimas</b></td><td><b>Tipas</b></td><td><b>Data</b></td><td><b>Data iki</b></td></tr>
<?php

        while($row = mysqli_fetch_assoc($result)) 
	{	 
	    $name=$row['pavadinimas']; 
	  	$date= $row['data'];
		$datetill= $row['data_iki'];
		$type=$row['tipo_pavadinimas'];
		
		    echo "<tr><td>".$name. "</td><td>";
			echo $type;
			echo "</td><td>";			
		    echo $date."</td><td>";
			echo $datetill."</td><tr>";
      		
	}
 ?>
	  </table>
  </body></html>



