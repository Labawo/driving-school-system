<?php
// operacija1.php
// skirtapakeisti savo sudaryta operacija pratybose

session_start();
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location:logout.php");exit;}

?>




<?php
include("include/nustatymai.php");
include("include/functions.php");
// prisijungimas prie DB
$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if(!$db){ 
	die ("Negaliu prisijungti prie MySQL:"  .mysqli_error($db)); 
}

?>

<?php
    $kursoid = $_SESSION['kursas'];
    

	$sql = "SELECT * FROM ".TBL_LEAR ." WHERE id = ".$kursoid;
	$result = mysqli_query($db, $sql);
	$pav= $dat = $vie = $apr = $kai = $tip = $dest = null;
	if (!$result || (mysqli_num_rows($result) != 1))   // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
	  	 {  // neradom vartotojo DB
		    $_SESSION['name_error']=
			 "<font size=\"2\" color=\"#ff0000\">* Tokio kurso nėra</font>";
         }
	else{
		$row = mysqli_fetch_assoc($result);
		$pav= $row["pavadinimas"];
		$dat= $row["data"];
		$datiki= $row["data_iki"];
		$vie= $row["vietu_sk"];
		$apr= $row["aprasas"];
		$kai= $row["kaina"];
		$tip= $row["tipas"];
		$dest= $row["destytojas"];

		
	}
	
	
?>

<?php
if (isset($_POST["ok"])){

	$sql = "UPDATE " .TBL_LECT ." SET kursu_sk = kursu_sk - 1 WHERE asmens_kodas = '$dest'";
	if (!mysqli_query($db, $sql))  die ("Klaida atnaujinant:" .mysqli_error($db));

	$pavadinimas = $_POST['name'];
	$data =$_POST['date'];
	$dataiki =$_POST['datetill'];
	$vietos =$_POST['cnt'];
	$aprasas =htmlspecialchars($_POST['about']);
	$kaina=$_POST['price'];
	$tipas=$_POST['tipas'];
	$dest=$_POST['dest'];

	$sql = "UPDATE " .TBL_LEAR ." SET pavadinimas = '$pavadinimas', data = '$data', data_iki = '$dataiki', vietu_sk = $vietos, aprasas = '$aprasas', kaina = $kaina, tipas = $tipas, destytojas = '$dest' WHERE id = $kursoid";
	//echo $sql;
	if (!mysqli_query($db, $sql))  die ("Klaida įrašant:" .mysqli_error($db));
	
	else{
		$sql = "UPDATE " .TBL_LECT ." SET kursu_sk = kursu_sk + 1 WHERE asmens_kodas = '$dest'";
		if (!mysqli_query($db, $sql))  die ("Klaida atnaujinant:" .mysqli_error($db));
	
		else{
			$_SESSION['added']="<p style='color:#4682B4;'>* Kursas redaguotas";
			
			header("Location:redaguotikursa.php");
			exit;
		}
	}

	
}
else{
	echo $_SESSION['added'];
	$_SESSION['added']="";
}
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Redaguoti kursą</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
    <table style="border-width: 2px; border-style: dotted;"><tr><td>
         Atgal į <a href="adminkursai.php">Kursus</a>
      </td></tr>
	</table><br>
			
		<div style="text-align: center;color:green"> <br><br>
			
            <h1>Redaguoti kursą.</h1>
			
			<form method='post' style="color:black">
				Pavadinimas:<input name='name' type='text' value='<?php echo $pav; ?>' required><br><br>
				Data:<input name='date' type='date' value='<?php echo $dat; ?>' min="<?php echo $dat; ?>" required><br><br>
				Data iki:<input name='datetill' type='date' value='<?php echo $datiki; ?>' min="<?php echo date("Y-m-d"); ?>" required><br><br>
				Vietų skaičius:<input name='cnt' type='number' value='<?php echo $vie; ?>' min="1" max="100" required><br><br>
				Aprašas:<textarea name='about' required><?php echo $apr; ?></textarea><br><br>
				Kaina:<input name='price' type='number' value='<?php echo $kai; ?>' min="1" step="any" max = "600" required><br><br>
				Tipas:
				<table style="margin-left: auto; margin-right: auto;">
						<tr><td><input name='tipas' type='radio' value='1' <?php if(1 == $tip)echo "checked"; ?>>Teorija</td></tr>
						<tr><td><input name='tipas' type='radio' value='2' <?php if(2 == $tip)echo "checked"; ?>>Praktika</td></tr>
						<tr><td><input name='tipas' type='radio' value='3' <?php if(3 == $tip)echo "checked"; ?>>Teorija + Praktika</td></tr>
				</table>
				Destytojas:
				<select name="dest">
					<?php
					include("include/nustatymai.php");
					$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
					$sql = "SELECT vardas,pavarde,asmens_kodas "
            		. "FROM " . TBL_LECT 
					. " WHERE kursu_sk < 7"
					. " ORDER BY vardas";
					$result = mysqli_query($db, $sql);
					
					while ($row = mysqli_fetch_assoc($result)){
						$ak = $row['asmens_kodas'];
						if($ak == $dest){
							echo "<option value=\"$ak\" selected>" . $row['vardas'] . " ". $row['pavarde']. "</option>";
						}
						else{
							echo "<option value=\"$ak\">" . $row['vardas'] . " ". $row['pavarde']. "</option>";
						}
						
					}
					?>
				</select>
				<div>
					<input type='submit' name='ok' value='Redaguoti'>
				</div>
			</form>
			
        </div><br>
				</body>
