<?php
// operacija3.php  Parodoma registruotų vartotojų lentelė

    session_start();
    if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index") && ($_SESSION['prev'] != "procprofileedit"))
    { header("Location: index.php");exit;}

?>

<?php
    //include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę
    include("include/nustatymai.php");
    include("include/functions.php");
    if ($_SESSION['prev'] != "procprofileedit")  inisession("part");  // pradinis bandymas registruoti

    $_SESSION['prev']="profileedit";

    $userlevel=$_SESSION['ulevel'];
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if ($userlevel == $user_roles["Administratorius"]){
        $sql = "SELECT vardas,pavarde "
        . "FROM " . TBL_ADMIN 
        . " WHERE id = '".$_SESSION['userid']."'";
        $result = mysqli_query($db, $sql);
        $name = $last = null;
        if (!$result || (mysqli_num_rows($result) < 1))  
        {echo "Siuo metu laisvų destytojų nėra"; exit;}
        else{
            //echo "paviko";
            $row = mysqli_fetch_assoc($result);
            $name = $row['vardas'];
            $last = $row['pavarde'];
        }
    }
    if ($userlevel == $user_roles["Dėstytojas"]){
        $sql = "SELECT vardas,pavarde,telefonas "
        . "FROM " . TBL_LECT 
        . " WHERE id = '".$_SESSION['userid']."'";
        $result = mysqli_query($db, $sql);
        $name = $last = $tel = null;
        if (!$result || (mysqli_num_rows($result) < 1))  
        {echo "Siuo metu laisvų destytojų nėra"; exit;}
        else{
            //echo "paviko";
            $row = mysqli_fetch_assoc($result);
            $name = $row['vardas'];
            $last = $row['pavarde'];
            $tel = $row['telefonas'];
        }
    }
    if ($userlevel == $user_roles["Kursantas"]){
        $sql = "SELECT vardas,pavarde,amzius,telefono_nr "
        . "FROM " . TBL_STUD
        . " WHERE id = '".$_SESSION['userid']."'";
        //echo $sql;
        $result = mysqli_query($db, $sql);
        $name = $last = $tel = $age = null;
        if (!$result || (mysqli_num_rows($result) < 1))  
        {echo "Siuo metu laisvų destytojų nėra"; exit;}
        else{
            //echo "paviko";
            $row = mysqli_fetch_assoc($result);
            $name = $row['vardas'];
            $last = $row['pavarde'];
            $tel = $row['telefono_nr'];
            $age = $row['amzius'];
        }
    }
    
                
?> 

<html>
        <head>  
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"> 
            <title>Profilio redagavimas</title>
            <link href="include/styles.css" rel="stylesheet" type="text/css" >
        </head>
        <body>   
            <table class="center"><tr><td> <img src="include/top.png" width="500" height="200"> </td></tr><tr><td> 
				<table style="border-width: 2px; border-style: dotted;"><tr><td>
                     Atgal į <a href="index.php">Pradžia</a> </td></tr>
		        </table>               
                <div align="center">   <font size="4" color="#ff0000"><?php echo $_SESSION['message']; $_SESSION['message']="";?><br></font>  
					
                <table bgcolor=#C3FDB8>
                    <tr><td>
                    <form method="POST" action="procprofileedit.php" class="login">             
                    <center style="font-size:18pt;"><b>Profilio redagavimas</b></center><br>
                    <center style="font-size:14pt;"><b>Vartotojas: <?php echo $_SESSION['user'];  ?></b></center>
                    
                    <p style="text-align:left;">Vardas:<br>
                        <input class ="s1" name="name" type="text" value="<?php echo $name; ?>"><br>
                        <?php echo $_SESSION['vardas_error']; ?>
                    </p>
                        
                    <p style="text-align:left;">Pavardė:<br>
                        <input class ="s1" name="last" type="text" value="<?php echo $last; ?>"><br>
                        <?php echo $_SESSION['pavarde_error']; ?>
                    </p>	
                    
                    <?php
                        if($userlevel == $user_roles["Dėstytojas"]){
                            echo '
                            <p style="text-align:left;">Telefonas:<br>
                            <input class ="s1" name="tel" type="text" value="'.$tel.'"><br>
                            <?php echo $_SESSION[\'tel_error\']; ?>
                            </p>
                            ';
                        }
                        if($userlevel == $user_roles["Kursantas"]){
                            echo '
                            <p style="text-align:left;">Telefonas:<br>
                            <input class ="s1" name="tel" type="text" value="'.$tel.'"><br>
                            <?php echo $_SESSION[\'tel_error\']; ?>
                            </p>
                            ';
                            echo '
                            <p style="text-align:left;">Amzius:<br>
                            <input class ="s1" name="age" type="number" min="10" max="100" value="'.$age.'"><br>
                            </p>
                            ';
                        }
                    ?>
                        
                    <p style="text-align:left;">
                        <input type="submit" name="update" value="Atnaujinti"/>     
                    </p>  
                    </form>
                    </td></tr>
                </table>
            </div>
            </td></tr>
            </table>           
        </body>
</html>
