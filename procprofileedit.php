<?php
// procregister.php tikrina registracijos reikšmes
// įvedimo laukų reikšmes issaugo $_SESSION['xxxx_login'], xxxx-name, pass, mail
// jei randa klaidų jas sužymi $_SESSION['xxxx_error']
// jei vardas, slaptažodis ir email tinka, įraso naują vartotoja į DB, nukreipia į index.php
// po klaidų- vel į register.php 

    session_start(); 
// cia sesijos kontrole
    if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "profileedit"))
    { header("Location: profileedit.php");exit;}

    include("include/nustatymai.php");
    include("include/functions.php");
    //-------------------------------------------------------------------------------
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if($conn->connect_error) die("Negaliu prisijungti: " . $conn->connect_error);
    mysqli_set_charset($conn,"utf8"); // del lietuviškų raidžių
    $userlevel=$_SESSION['ulevel'];
    $vardas=$_POST['name'];
    $pavarde=$_POST['last'];
    if($userlevel == $user_roles["Dėstytojas"]){
        $tel_nr=$_POST['tel'];
    }
    if($userlevel == $user_roles["Kursantas"]){
        $tel_nr=$_POST['tel'];
        $amzius=$_POST['age'];
    }
    
    //-------------------------------------------------------------------------------

    $_SESSION['vardas_error']="";
    $_SESSION['pavarde_error']="";
    $_SESSION['tel_error']="";
    $_SESSION['amzius_error']="";

    $_SESSION['prev'] = "procprofileedit"; 
    
    //------------------------------------------------------------------------------
    if(!preg_match("/^([a-zA-Z])*$/", $vardas)) {
        $_SESSION['vardas_error'] = "<p style='color:#ff0000;'>* Vardas gali būti sudarytas<br>&nbsp;&nbsp;tik iš raidžių";
    }
    if(strlen($vardas) > 32) {
        $_SESSION['vardas_error'] = "<p style='color:#ff0000;'>* Vardas per ilgas";
    }
    if(!preg_match("/^([a-zA-Z])*$/", $pavarde)) {
        $_SESSION['pavarde_error'] = "<p style='color:#ff0000;'>* Pavardė gali būti sudaryta<br>&nbsp;&nbsp;tik iš raidžių";
    }
    if(strlen($pavarde) > 32) {
        $_SESSION['pavarde_error'] = "<p style='color:#ff0000;'>* Pavardė per ilga";
    }

    if($userlevel == $user_roles["Dėstytojas"] || $userlevel == $user_roles["Kursantas"]){
        if(!preg_match("/^\+?[0-9]*$/", $tel_nr)) {
            $_SESSION['tel_error'] = "<p style='color:#ff0000;'>* Telefono numeris turi būti formatu '+skaičiai' arba 'tikskaičiai'</p>";
        }  
        if(strlen($tel_nr) > 12) {
            $_SESSION['tel_error'] = "<p style='color:#ff0000;'>* Telefono numeris per ilgas";
        }
        if($_SESSION['vardas_error'] != "" || $_SESSION['pavarde_error'] != "" || $_SESSION['tel_error'] != "") {
            $conn->close();
            header("Location:profileedit.php");exit;
        }
    }
    else{
        if($_SESSION['vardas_error'] != "" || $_SESSION['pavarde_error'] != "") {
            $conn->close();
            header("Location:profileedit.php");exit;
        }
    }    
    //---------------------------------------------------------------------------------------------------------------------------------------

	$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if($userlevel == $user_roles["Dėstytojas"]){
        $sql = "UPDATE " . TBL_LECT. " SET vardas='$vardas', pavarde='$pavarde', telefonas='$tel_nr' ".
        "WHERE id='".$_SESSION['userid']."'";
        if (mysqli_query($db, $sql))
        {
            $_SESSION['message']="Profilis atnaujintas sėkmingai";
            header("Location:profileedit.php");
            exit;
        }
        else
        {
            $_SESSION['message']="DB profilio atnaujinimo klaida:" . $sql . "<br>" . mysqli_error($db);
        }
    }

    if($userlevel == $user_roles["Kursantas"]){
        $sql = "UPDATE " . TBL_STUD. " SET vardas='$vardas', pavarde='$pavarde', telefono_nr='$tel_nr', amzius=$amzius ".
        "WHERE id='".$_SESSION['userid']."'";
        echo $sql;
        if (mysqli_query($db, $sql))
        {
            $_SESSION['message']="Profilis atnaujintas sėkmingai";
            header("Location:profileedit.php");
            exit;
        }
        else
        {
            $_SESSION['message']="DB profilio atnaujinimo klaida:" . $sql . "<br>" . mysqli_error($db);
        }
    }

    if($userlevel == $user_roles["Administratorius"]){
        $sql = "UPDATE " . TBL_ADMIN. " SET vardas='$vardas', pavarde='$pavarde' ".
        "WHERE id='".$_SESSION['userid']."'";
        if (mysqli_query($db, $sql))
        {
            $_SESSION['message']="Profilis atnaujintas sėkmingai";
            header("Location:profileedit.php");
            exit;
        }
        else
        {
            $_SESSION['message']="DB profilio atnaujinimo klaida:" . $sql . "<br>" . mysqli_error($db);
        }
    }
         
    
?>
