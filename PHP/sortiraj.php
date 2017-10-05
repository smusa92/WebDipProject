
<?php

if(!isset($_SESSION))
{
	session_start();
}

//blokirani
$sql1 = "SELECT clan.ID_clan, clan.ime, clan.prezime , clan.username, clan.lozinka, clan.email, tip_korisnika.uloga from clan LEFT JOIN tip_korisnika ON clan.tip_korisnika=tip_korisnika.ID_tip_korisnika WHERE clan.status= '3'";
       
//statistika
$sql2 = "SELECT * FROM `statistika`";

//lajkovi
$sql3 = "SELECT projekcije.ID_projekcije, film.naziv, projekcije.od ,projekcije.do, lajkovi.lajk, lajkovi.clan FROM film, projekcije, lajkovi WHERE  projekcije.film=film.ID_film AND projekcije.ID_projekcije=lajkovi.projekcija";

//dnevnik
$sql4 = "SELECT * FROM `dnevnik`";

//potvrđene rezervacije
$sql5 = "SELECT film.naziv, lokacija.grad,lokacija.ulica,lokacija.broj, rezervacije.broj_mjesta, rezervacije.vrijeme_rezervacije"
        . " FROM rezervacije "
        . "JOIN projekcije ON rezervacije.projekcija=projekcije.ID_projekcije "
        . "JOIN lokacija ON projekcije.lokacija=lokacija.ID_lokacija "
        . "JOIN film ON film.ID_film=projekcije.film "
        . "AND rezervacije.clan= '".$_SESSION['id_clan']."' AND rezervacije.potvrda=2";

// za tablicu blokiranih
if ($_GET['tablica'] == '1')
{ 
    if($_GET['order']== 2){
$sql1 .= " ORDER BY 2";}  else {
$sql1 .= " ORDER BY 3";    
}

$_SESSION['tablica1'] = $sql1;
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}

// za tablicu statistike
elseif ($_GET['tablica'] == '2')
{
    if($_GET['order']== 1){
$sql2 .= " ORDER BY 1";}  else {
$sql2 .= " ORDER BY 4";    
}
$_SESSION['tablica2'] = $sql2;
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}

//za tablicu statistika lajkova
elseif ($_GET['tablica'] == '3')
{
    if($_GET['order']== 3){
$sql3 .= " ORDER BY 3";}  elseif($_GET['order']== 5) {
$sql3 .= " ORDER BY 5";    
}  else {
$sql3 .= " ORDER BY 6";  
}
$_SESSION['tablica3'] = $sql3;
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}

// za tablicu dnevnik
elseif($_GET['tablica'] == '4')
{
    if($_GET['order']== 1){
$sql4 .= " ORDER BY 1";}  else {
$sql4 .= " ORDER BY 3";    
}
$_SESSION['tablica4'] = $sql4;
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}

// za tablicu potvrđenih rezervacija
elseif($_GET['tablica'] == '5')
{
    if($_GET['order']== 1){
$sql5 .= " ORDER BY 1";}  else {
$sql5 .= " ORDER BY 5";    
}
$_SESSION['tablica5'] = $sql5;
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}

?>