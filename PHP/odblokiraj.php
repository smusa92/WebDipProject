<?php

session_start();

include './baza.class.php';

$baza = new Baza();
$baza->spojiDB();

$sifra = $_GET['sifra'];
$upit = "UPDATE clan SET status='1' WHERE clan.ID_clan='".$sifra."';";
        $baza->updateDB($upit); 
        if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        
?>

