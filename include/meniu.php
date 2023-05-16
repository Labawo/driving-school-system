<?php
// meniu.php  rodomas meniu pagal vartotojo rolę

if (!isset($_SESSION)) { header("Location: logout.php");exit;}
include("include/nustatymai.php");
$user=$_SESSION['user'];
$userlevel=$_SESSION['ulevel'];
$role="";
{foreach($user_roles as $x=>$x_value)
			      {if ($x_value == $userlevel) $role=$x;}
} 

     echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
        echo "<tr><td>";
        echo "Prisijungęs vartotojas: <b>".$user."</b>     Rolė: <b>".$role."</b> <br>";
        echo "</td></tr><tr><td>";
        if ($_SESSION['user'] != "guest") {
			echo "<a href=\"useredit.php\">Redaguoti paskyrą</a> &nbsp;&nbsp;";
			echo "<a href=\"profileedit.php\">Profilio redagavimas</a> &nbsp;&nbsp;";
		}
		if ($_SESSION['user'] == "guest") {
			echo "<a href=\"register.php\">Registruotis kaip dėstytojas</a> &nbsp;&nbsp;";
			echo "<a href=\"registerS.php\">Registruotis kaip kursantas</a> &nbsp;&nbsp;";
			echo "<a href=\"registerA.php\">Registruotis kaip administratorius</a> &nbsp;&nbsp;";
		}
		if ($userlevel != $user_roles["Kursantas"] && $userlevel != $user_roles["Administratorius"]){
			echo "<a href=\"kursai.php\">Kursų sąrašas</a> &nbsp;&nbsp;";
		}
		else if ($userlevel == $user_roles["Kursantas"]){
			echo "<a href=\"kurskursai.php\">Kursų sąrašas</a> &nbsp;&nbsp;";
		}
		else{
			echo "<a href=\"adminkursai.php\">Kursų sąrašas</a> &nbsp;&nbsp;";
		}
        
        
		if ($userlevel == $user_roles["Kursantas"] ) {
			echo "<a href=\"manokursai.php\">Mano kursai</a> &nbsp;&nbsp;";
		}
     //Trečia operacija tik rodoma pasirinktu kategoriju vartotojams, pvz.:
        
		if ($userlevel == $user_roles["Dėstytojas"] ) {
			echo "<a href=\"vedamikursai.php\">Vedamų kursų laikai</a> &nbsp;&nbsp;";
			echo "<a href=\"kursantaiDest.php\">Kursantų sąrašas</a> &nbsp;&nbsp;";
		}
        //Administratoriaus sąsaja rodoma tik administratoriui
        if ($userlevel == $user_roles[ADMIN_LEVEL] ) {  
			echo "<a href=\"kursantai.php\">Kursantų sąrašas</a> &nbsp;&nbsp;";  
			echo "<a href=\"destytojai.php\">Dėstytojų sąrašas</a> &nbsp;&nbsp;";
			echo "<a href=\"pridetikursa.php\">Pridėti kursą</a> &nbsp;&nbsp;";			
			//echo "<a href=\"admin.php\">Administratoriaus sąsaja</a> &nbsp;&nbsp;";
			
        }
        echo "<a href=\"logout.php\">Atsijungti</a>";
      echo "</td></tr></table>";
?>       
    
 