<?php
// operacija3.php  Parodoma registruotų vartotojų lentelė

session_start();
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location: logout.php");exit;}

?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Kursų sąrašas</title>
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
		$sql = "SELECT pavadinimas,data,data_iki,vietu_sk,aprasas,kaina,tipo_pavadinimas,vardas,pavarde "
		. "FROM " . TBL_LEAR . " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
		. " LEFT JOIN ". TBL_LECT . " ON " .TBL_LEAR. ".destytojas=" . TBL_LECT .".asmens_kodas"
		. " WHERE pavadinimas='$pavadinimas'"
		. " ORDER BY pavadinimas desc";
		$result = mysqli_query($db, $sql);
		if (!$result || (mysqli_num_rows($result) < 1))  
		{echo "Klaida skaitant lentelę kursai"; exit;}
	}
	else{
		//$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		$sql = "SELECT pavadinimas,data,data_iki,vietu_sk,aprasas,kaina,tipo_pavadinimas,vardas,pavarde "
		. "FROM " . TBL_LEAR . " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
		. " LEFT JOIN ". TBL_LECT . " ON " .TBL_LEAR. ".destytojas=" . TBL_LECT .".asmens_kodas"
		. " ORDER BY pavadinimas desc";
		$result = mysqli_query($db, $sql);
		if (!$result || (mysqli_num_rows($result) < 1))  
		{echo "Klaida skaitant lentelę kursai"; exit;}
	} 			
			
 ?> 
		
        <center><font size="5">Dabar yra tokia registruotų kursų lentelė</font></center><br>
		
    <table class="center" border="1" cellspacing="0" cellpadding="3">
		<tr><td><b>Pavadinimas</b></td><td><b>Data</b></td><td><b>Data iki</b></td><td><b>Vietų sk.</b></td><td><b>Aprašas</b></td><td><b>Kaina</b></td><td><b>Tipas</b></td><td><b>Dėstytojas</b></td></tr>
<?php
        while($row = mysqli_fetch_assoc($result)) 
	{	 
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
		    echo $lname." ".$last."</td></tr>"; 
      		
	}
 ?>
	  </table>
  </body></html>

