<?php
// procregister.php tikrina registracijos reikšmes
// įvedimo laukų reikšmes issaugo $_SESSION['xxxx_login'], xxxx-name, pass, mail
// jei randa klaidų jas sužymi $_SESSION['xxxx_error']
// jei vardas, slaptažodis ir email tinka, įraso naują vartotoja į DB, nukreipia į index.php
// po klaidų- vel į register.php 

session_start(); 
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "registerS"))
{ header("Location: logout.php");exit;}

  include("include/nustatymai.php");
  include("include/functions.php");
  //-------------------------------------------------------------------------------
  $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if($conn->connect_error) die("Negaliu prisijungti: " . $conn->connect_error);
	mysqli_set_charset($conn,"utf8"); // del lietuviškų raidžių

	$vardas=$_POST['vardas'];$_SESSION['vardas_login']=$vardas;
	$pavarde=$_POST['pavarde'];$_SESSION['pavarde_login']=$pavarde;
	$ak=$_POST['ak'];$_SESSION['ak_login']=$ak;
	$tel_nr=$_POST['tel_nr'];$_SESSION['tel_login']=$tel_nr;
    $amzius=$_POST['amzius'];$_SESSION['amzius_login']=$amzius;
  //-------------------------------------------------------------------------------

	$_SESSION['vardas_error']="";
	$_SESSION['pavarde_error']="";
	$_SESSION['ak_error']="";
	$_SESSION['tel_error']="";
    $_SESSION['amzius_error']="";


  $_SESSION['name_error']="";
  $_SESSION['pass_error']="";
  $_SESSION['mail_error']="";
  $user=strtolower($_POST['user']);
  $_SESSION['name_login']=$user;
  $pass=$_POST['pass'];$_SESSION['pass_login']=$pass;
  $mail=$_POST['email'];$_SESSION['mail_login']=$mail;   
  $_SESSION['prev'] = "procregisterS";
  

        // registracijos formos lauku  kontrole
        if (checkname($user))
		{ // vardas  geras,  nuskaityti vartotoja is DB
      
			list($dbuname)=checkdb($user);  //patikrinam DB       
			if ($dbuname)  
			{  // jau yra toks vartotojas DB
				$_SESSION['name_error']= "<font size=\"2\" color=\"#ff0000\">* Tokiu vardu jau yra registruotas vartotojas</font>";
			}
			else 
			{  // gerai, vardas naujas
				$_SESSION['name_error']= "";
				if (checkpass($pass,substr(hash('sha256',$pass),5,32))  && checkmail($mail)) // antra tikrinimo dalis checkpass bus true
				{ // viskas tinka sukurti vartotojo irasa DB
					$userid=md5(uniqid($user));                          //naudojam toki userid
					$pass=substr(hash('sha256',$pass),5,32);     // DB password skirti 32 baitai, paimam is maisos vidurio 
					if ($_SESSION['ulevel'] == $user_roles[ADMIN_LEVEL] ) $ulevel=$_POST['role'];  // jei registravo adminas, imam jo nurodyta role
					else $ulevel=$user_roles[DEFAULT_LEVEL]; 

					//------------------------------------------------------------------------------
					if(!preg_match("/^([a-zA-Z])*$/", $vardas)) {
						$_SESSION['vardas_error'] = "<p style='color:#ff0000;'>* Vardas gali būti sudarytas<br>&nbsp;&nbsp;tik iš raidžių";
					}
					if(strlen($pavarde) > 32) {
						$_SESSION['vardas_error'] = "<p style='color:#ff0000;'>* Vardas per ilgas";
					}
					if(!preg_match("/^([a-zA-Z])*$/", $pavarde)) {
						$_SESSION['pavarde_error'] = "<p style='color:#ff0000;'>* Pavardė gali būti sudaryta<br>&nbsp;&nbsp;tik iš raidžių";
					}
					if(strlen($pavarde) > 32) {
						$_SESSION['pavarde_error'] = "<p style='color:#ff0000;'>* Pavardė per ilga";
					}
					if(!preg_match("/^([0-9])*$/", $ak)) {
						$_SESSION['ak_error'] = "<p style='color:#ff0000;'>* Asmens kodas gali būti sudarytas<br>&nbsp;&nbsp;tik iš skaičių";
					}
					if(strlen($ak) > 12) {
						$_SESSION['ak_error'] = "<p style='color:#ff0000;'>* Asmens kodas per ilgas";
					}
					if(!preg_match("/^\+?[0-9]*$/", $tel_nr)) {
						$_SESSION['tel_error'] = "<p style='color:#ff0000;'>* Telefono numeris turi būti formatu '+skaičiai' arba 'tikskaičiai'</p>";
					}  
					if(strlen($tel_nr) > 12) {
						$_SESSION['tel_error'] = "<p style='color:#ff0000;'>* Telefono numeris per ilgas";
					}
					if(checkdbL($ak)){
						$_SESSION['ak_error'] = "<p style='color:#ff0000;'>* Sis a.k. uzimtas";
					}
					else{
						$_SESSION['ak_error'] = "";
					}
					if(checkdbS($ak)){
						$_SESSION['ak_error'] = "<p style='color:#ff0000;'>* Sis a.k. uzimtas";
					}
					else{
						$_SESSION['ak_error'] = "";
					}

					if($_SESSION['vardas_error'] != "" || $_SESSION['pavarde_error'] != "" || $_SESSION['tel_error'] != "" || $_SESSION['ak_error'] != "") {
						$conn->close();
						header("Location:registerS.php");exit;
					}
					//---------------------------------------------------------------------------------------------------------------------------------------

					$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
					$ak=substr(hash('sha256',$ak),5,12);

					$sql = "INSERT INTO " . TBL_USERS. " (slapyvardis, slaptazodis, id, lygmuo, el_pastas, timestamp)
					VALUES ('$user', '$pass', '$userid','$ulevel', '$mail', null)";

					if (mysqli_query($db, $sql)){
							$sql = "INSERT INTO " . TBL_STUD. " (vardas, pavarde, telefono_nr, asmens_kodas, amzius, id)
								VALUES ('$vardas', '$pavarde', '$tel_nr','$ak', '$amzius' , '$userid')";

							if (mysqli_query($db, $sql)){
								$_SESSION['message']="Registracija sėkminga";
							}
							else{$_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($db);}
					}
					else {$_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($db);}

					// uzregistruotas

					if ($_SESSION['ulevel'] == $user_roles[ADMIN_LEVEL] )  {header("Location:admin.php");} 
					else {header("Location:index.php");}
				
					exit;
				}
			}
		}
        // griztam taisyti
         // session_regenerate_id(true);
        header("Location:registerS.php");exit;
