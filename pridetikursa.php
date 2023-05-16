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

	if (isset($_POST["ok"])){

		$pavadinimas = $_POST['name'];
		$data =$_POST['date'];
		$dataiki =$_POST['datetill'];
		$vietos =$_POST['cnt'];
		$aprasas =htmlspecialchars($_POST['about']);
		$kaina=$_POST['price'];
		$tipas=$_POST['tipas'];
		$dest=$_POST['dest'];

		$sql = "INSERT INTO " .TBL_LEAR ." (pavadinimas, data, data_iki, vietu_sk, aprasas, kaina, tipas, destytojas ) VALUES ('$pavadinimas', '$data', '$dataiki', '$vietos', '$aprasas', '$kaina', '$tipas', '$dest' )";
		if (!mysqli_query($db, $sql))  die ("Klaida įrašant:" .mysqli_error($db));
		
		else{
			$sql = "UPDATE " .TBL_LECT ." SET kursu_sk = kursu_sk + 1 WHERE asmens_kodas = '$dest'";
			if (!mysqli_query($db, $sql))  die ("Klaida įrašant:" .mysqli_error($db));
		
			else{
				$_SESSION['added']="<p style='color:#4682B4;'>* Kursas pridėtas";
				//
				header("Location:pridetikursa.php");
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
        <title>Pridėti kursą</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
    <table style="border-width: 2px; border-style: dotted;"><tr><td>
         Atgal į <a href="index.php">Pradžia</a>
      </td></tr>
	</table><br>
			
		<div style="text-align: center;color:green"> <br><br>
		<center><b><?php if($_SESSION['added'] != ""){echo $_SESSION['added'];}; ?></b></center>
            <h1 style="text-align: center;color:black">Prideti kursa.</h1>
			
			<form method='post' style="color:black">
				Pavadinimas:<input name='name' type='text' required><br><br>
				Data:<input name='date' type='date' min="<?php echo date("Y-m-d"); ?>" required><br><br>
				Data iki:<input name='datetill' type='date' min="<?php echo date("Y-m-d"); ?>" required><br><br>
				Vietų skaičius:<input name='cnt' type='number' min="1" max="100" required><br><br>
				Aprašas:<textarea name='about' required></textarea><br><br>
				Kaina:<input name='price' type='number' min="1" step="any" max = "1200" required><br><br>
				Tipas:
				<table style="margin-left: auto; margin-right: auto;">
						<tr><td><input name='tipas' type='radio' value='1' checked>Teorija</td></tr>
						<tr><td><input name='tipas' type='radio' value='2'>Praktika</td></tr>
						<tr><td><input name='tipas' type='radio' value='3'>Teorija + Praktika</td></tr>
				</table>
				
				Destytojas:
				<select name="dest">
					<?php
					include("include/nustatymai.php");
					$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
					$sql = "SELECT vardas,pavarde,asmens_kodas "
            		. "FROM " . TBL_LECT 
					. " WHERE kursu_sk < 3"
					. " ORDER BY vardas";
					$result = mysqli_query($db, $sql);
					
					while ($row = mysqli_fetch_assoc($result)){
						$ak = $row['asmens_kodas'];
						echo "<option value=\"$ak\">" . $row['vardas'] . " ". $row['pavarde']. "</option>";
					}
					?>
				</select>
				<div>
					<input type='submit' name='ok' value='Pridėti'>
				</div>
			</form>
			
        </div><br>
