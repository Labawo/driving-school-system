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
        
        <?php
        if (isset($_POST["ok"])){
			$pavadinimas = $_POST['pavad'];
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT ". TBL_LEAR .".id,pavadinimas,data,data_iki,vietu_sk,aprasas,kaina,tipo_pavadinimas,vardas,pavarde,uzdarytas "
            . "FROM " . TBL_LEAR . " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
            . " LEFT JOIN ". TBL_LECT . " ON " .TBL_LEAR. ".destytojas=" . TBL_LECT .".asmens_kodas"
            . " WHERE pavadinimas='$pavadinimas'"
            . " ORDER BY pavadinimas desc";
            $result = mysqli_query($db, $sql);
            if (!$result || (mysqli_num_rows($result) < 1))  
            {echo "Kursu nėra"; exit;}
        }else{
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT ". TBL_LEAR .".id,pavadinimas,data,data_iki,vietu_sk,aprasas,kaina,tipo_pavadinimas,vardas,pavarde,uzdarytas "
            . "FROM " . TBL_LEAR . " LEFT JOIN ". TBL_TYPE . " ON " .TBL_LEAR. ".tipas=" . TBL_TYPE .".id"
            . " LEFT JOIN ". TBL_LECT . " ON " .TBL_LEAR. ".destytojas=" . TBL_LECT .".asmens_kodas"
            . " ORDER BY pavadinimas desc";
            $result = mysqli_query($db, $sql);
            if (!$result || (mysqli_num_rows($result) < 1))  
            {echo "Kursu nėra"; exit;}
        }                    
        ?>
        
        <?php
            if(isset($_POST['edit'])){
                $_SESSION['kursas'] = $_POST["edit"][1];
                header("Location: redaguotikursa.php");
                exit;
            }
            if(isset($_POST['block'])){
                $kursid = $_POST["block"][1];
                $sql = "UPDATE " .TBL_LEAR ." SET uzdarytas = 1 WHERE id = $kursid";
                if (!mysqli_query($db, $sql))  die ("Klaida atnaujinant:" .mysqli_error($db));
                header("Location: adminkursai.php");
                exit;
            }
            if(isset($_POST['unblock'])){
                $kursid = $_POST["unblock"][1];
                $sql = "UPDATE " .TBL_LEAR ." SET uzdarytas = 0 WHERE id = $kursid";
                if (!mysqli_query($db, $sql))  die ("Klaida atnaujinant:" .mysqli_error($db));
                header("Location: adminkursai.php");
                exit;
            }
            if(isset($_POST['del'])){
                $kursid = $_POST["del"][1];
                $sql = "DELETE FROM " .TBL_CONN ." WHERE kurso_id = $kursid";
                if (!mysqli_query($db, $sql))  die ("Klaida trinant:" .mysqli_error($db));
                else{
                    $sql = "UPDATE ".TBL_LECT." SET kursu_sk = kursu_sk - 1 WHERE asmens_kodas=(SELECT destytojas FROM ".TBL_LEAR." WHERE id = $kursid )";
                    if (!mysqli_query($db, $sql))  die ("Klaida atnaujinant destytoju lentele:" .mysqli_error($db));
                    else{
                        $sql = "DELETE FROM " .TBL_LEAR ." WHERE id = $kursid";
                        if (!mysqli_query($db, $sql))  die ("Klaida trinant:" .mysqli_error($db));
                        else{
                            header("Location: adminkursai.php");
                            exit;
                        }
                    }        
                }
                
            }

            unset($_SESSION['kursas']);
            // if(isset($_POST['sal'])){
            //     $sql = "DELETE FROM " .TBL_CONN ." WHERE kurso_id IN (SELECT kurso_id FROM ".TBL_LEAR." WHERE data_iki < '".date("Y-m-d")."')";
            //     echo $sql;
            //     if (!mysqli_query($db, $sql))  die ("Klaida trinant:" .mysqli_error($db));
            //     else{
            //         $sql = "UPDATE ".TBL_LECT." SET kursu_sk = kursu_sk - ".number_format("SELECT COUNT(destytojas) FROM ".TBL_LEAR." WHERE data_iki < '".date("Y-m-d")."'")
            //         ." WHERE asmens_kodas IN (SELECT destytojas FROM ".TBL_LEAR." WHERE data_iki < '".date("Y-m-d")."')";
            //         echo $sql;
            //         if (!mysqli_query($db, $sql))  die ("Klaida atnaujinant destytoju lentele:" .mysqli_error($db));
            //         else{
            //             $sql = "DELETE FROM " .TBL_LEAR ." WHERE data_iki < '".date("Y-m-d")."'";
            //             if (!mysqli_query($db, $sql))  die ("Klaida trinant:" .mysqli_error($db));
            //             else{
            //                 header("Location: adminkursai.php");
            //                 exit;
            //             }
            //         }        
            //     }
                
            // }
        ?>
		
        <center><font size="5">Dabar yra tokia registruotų kursų lentelė</font></center><br>
		
    <table class="center" id ="customers" border="1" cellspacing="0" cellpadding="3">
		<tr><td><b>Pavadinimas</b></td><td><b>Data</b></td><td><b>Data iki</b></td><td><b>Vietų sk.</b></td><td><b>Aprašas</b></td><td><b>Kaina</b></td><td><b>Tipas</b></td><td><b>Dėstytojas</b></td></tr>

        

        <?php
            //echo date("Y-m-d");
                while($row = mysqli_fetch_assoc($result)) 
            {	 
                $id=$row['id'];
                $name=$row['pavadinimas']; 
                $date= $row['data'];
                $datetill= $row['data_iki'];
                $space=$row['vietu_sk'];
                $about=$row['aprasas'];
                $price=$row['kaina'];
                $type=$row['tipo_pavadinimas'];
                $lname=$row['vardas'];
                $last=$row['pavarde'];
                $closed=$row['uzdarytas'];	
                    
                    echo "<tr><td>".$name. "</td><td>";    
                    echo $date;
                    echo "</td><td>";
                    echo $datetill."</td><td>";
                    echo $space."</td><td>";
                    echo $about."</td><td>";
                    echo $price."</td><td>";
                    echo $type."</td><td>";
                    echo $lname." ".$last."</td>";
                    echo "<form method=\"post\"> <td> <input type=\"submit\" name=\"edit[]\", value=\"Redaguoti\"> <input type=\"hidden\" name=\"edit[]\" value=\"".$id."\" > </td></form>";
                    if($closed == 0){
                        echo "<form method=\"post\"> <td> <input type=\"submit\" name=\"block[]\", value=\"Blokuoti\"> <input type=\"hidden\" name=\"block[]\" value=\"".$id."\" > </td></form>";
                    }
                    else{
                        echo "<form method=\"post\"> <td> <input type=\"submit\" name=\"unblock[]\", value=\"Atblokuoti\"> <input type=\"hidden\" name=\"unblock[]\" value=\"".$id."\" > </td></form>";
                    }
                    echo "<form method=\"post\" onSubmit=\"return confirm('Are you sure?');\"> <td> <input type=\"submit\" name=\"del[]\", value=\"Trinti\"> <input type=\"hidden\" name=\"del[]\" value=\"".$id."\" > </td></form>";
                    if ($datetill < date("Y-m-d"))
                    {
                        echo "<td><p style=\"color:red;\"> *Pasibaigė</p></td></tr>";
                    }


            }

            
        ?>
	  </table>
      <!-- <?php
        echo "<form method=\"post\" onSubmit=\"return confirm('Are you sure?');\"> <input type=\"submit\" name=\"sal\", value=\"Trinti senus įrašus\"></form>";
      ?> -->
  </body></html>

	

