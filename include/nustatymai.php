<?php
//nustatymai.php
// define("DB_SERVER", "localhost");
define("DB_SERVER", "127.0.0.1:3308");
//define("DB_USER", "stud");
define("DB_USER", "root");
//define("DB_PASS", "stud");
define("DB_PASS", "");
define("DB_NAME", "vairavimokursai");
define("TBL_USERS", "naudotojai");
define("TBL_LECT", "destytojai");
define("TBL_STUD", "kursantai");
define("TBL_LEAR", "kursai");
define("TBL_TYPE", "tipai");
define("TBL_ADMIN", "administratoriai");
define("TBL_CONN", "rysiai");


$user_roles=array(      // vartotojų rolių vardai lentelėse ir  atitinkamos userlevel reikšmės
	"Administratorius"=>"9",
	"Kursantas"=>"4",
	"Dėstytojas"=>"5",);   // galioja ir vartotojas "guest", kuris neturi userlevel
define("DEFAULT_LEVEL","Kursantas");  // kokia rolė priskiriama kai registruojasi
define("ADMIN_LEVEL","Administratorius");
define("LECTURE_LEVEL", "Dėstytojas");  // kas turi vartotojų valdymo teisę
define("UZBLOKUOTAS","255");      // vartotojas negali prisijungti kol administratorius nepakeis rolės
$uregister="both";  // kaip registruojami vartotojai
// self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai
// * Email Constants - 
define("EMAIL_FROM_NAME", "Demo");
define("EMAIL_FROM_ADDR", "demo@ktu.lt");
define("EMAIL_WELCOME", false);
