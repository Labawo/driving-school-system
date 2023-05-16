<?php
// operacija3.php  Parodoma registruotų vartotojų lentelė

session_start();
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location: logout.php");exit;}

?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Destytojų sąrašas</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <table class="center" ><tr><td>
            <center><img src="include/top.png" width="500" height="200"></center>
        </td></tr><tr><td> 
 <?php
		include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę
 			$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			$sql = "SELECT vardas,pavarde,telefonas,asmens_kodas,kursu_sk "
            . "FROM " . TBL_LECT 
			. " WHERE kursu_sk < 7"
			. " ORDER BY vardas";
			$result = mysqli_query($db, $sql);
			if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Siuo metu laisvų destytojų nėra"; exit;}
 ?> 
		</table>
        <center><font size="5">Laisvų dėstytojų sąrašas</font></center><br>
		
    <table class="center" border="1" cellspacing="0" cellpadding="3">
		<tr><td><b>Vardas</b></td><td><b>Pavardė</b></td><td><b>Telefonas</b></td><td><b>A.K</b></td><td><b>Kursų skaičius</b></td></tr>
<?php
        while($row = mysqli_fetch_assoc($result)) 
	{	 
	    $name=$row['vardas']; 
	  	$lname= $row['pavarde'];
		$cell=$row['telefonas'];
		$ak=$row['asmens_kodas'];
		$numb=$row['kursu_sk'];
		    echo "<tr><td>".$name. "</td><td>";    
 			echo $lname;
			echo "</td><td>";
			echo $cell."</td><td>";
			echo $ak."</td><td>";
		    echo $numb."</td></tr>"; 
      		
	}
 ?>
	  </table>
  </body></html>
