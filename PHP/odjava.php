<?php
include '../PHP/baza.class.php';
$baza = new Baza();

$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemOdjave = date('Y-m-d H:i:s', $trenutno);

session_start();
$userSesija = $_SESSION["korisnickoImeSesija"];

$upit = 'insert into statistika (akcija, vrijeme, clan) values ("Uspjesna odjava","'.$vrijemOdjave.'","'.$userSesija.'")';
$baza->updateDB($upit);

$upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Uspjesna odjava","'.$vrijemOdjave.'","'.$userSesija.'")';
$baza ->updateDB($upit);

session_destroy();
header("Location: ../PHP/prijavi_se.php");

?>