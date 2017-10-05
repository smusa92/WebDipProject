<?php

session_start();

include './baza.class.php';

$baza = new Baza();
$baza->spojiDB();

$upitV = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upitV)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemOdjave = date('Y-m-d H:i:s', $trenutno);

$sifra = $_GET['sifra'];
$odabit = $_GET['odabir'];     
$broj_mjesta = $_GET['broj_m'];
$clan = $_GET['clan'];
$sifra_p = $_GET['sifra_p'];

$upit="SELECT `email` FROM `clan` WHERE `username`='".$clan."';";
$primatelj=$baza->selectDB($upit)->fetch_object()->email;
$naslov="Odgovor na rezervaciju";

    if ($odabit == 1) {

        $upit = "UPDATE `rezervacije` SET `potvrda` = '2' WHERE `rezervacije`.`ID_rezervacije` = '".$sifra."';";
        $baza->updateDB($upit); 
        
        $upit="SELECT `email` FROM `clan` WHERE `username`='".$clan."';";
        $primatelj=$baza->selectDB($upit)->fetch_object()->email;
        
        $upit="UPDATE projekcije SET `max_broj_posjetitelja`=max_broj_posjetitelja-'".$broj_mjesta."' WHERE ID_projekcije='".$sifra_p."';";
        $baza->updateDB($upit);
        
        $poruka="Vaša rezervacija je potvrđena.";
        mail($primatelj, $naslov, $poruka);
        
        $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Potvrda rezervacije i salanje maila","'.$vrijemOdjave.'","'.$_SESSION["korisnickoImeSesija"].'")';
        $baza->updateDB($upit);

        $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Potvrda rezervacije i salanje maila","'.$vrijemOdjave.'","'.$_SESSION["korisnickoImeSesija"].'")';
        $baza ->updateDB($upit);
       
    
        
        echo 'Potvrđena rezervacija';
        header("Refresh:3; ../PHP/rezervacijeModerator.php");
        
    }elseif ($odabit == 0) {

        $upit="DELETE FROM `rezervacije` WHERE `rezervacije`.`ID_rezervacije` ='".$sifra."';";
        $baza->updateDB($upit);
        $poruka="Vaša rezervacija je odbijena.";
        mail($primatelj, $naslov, $poruka);
        echo 'Odbijena rezervacija';
        header("Refresh:3; ../PHP/rezervacijeModerator.php");   
        
    }


?>