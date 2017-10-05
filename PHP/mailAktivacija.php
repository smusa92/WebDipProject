<?php

include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();

$akkod = $_GET['aktivacijski'];
$razlika = 43200;
$vrijeme = $_GET['vrijemeReg'];

//-----------Pomak vremena--------
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemeAktivacije = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------

$upit = 'select username from clan where akkod = "'.$akkod.'";';
$clan = $baza->selectDB($upit)->fetch_object()->username;

if($trenutno - $vrijeme < $razlika){
    
   $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Aktivacija racuna","'.$vrijemeAktivacije.'","'.$clan.'");';
   $baza ->updateDB($upit);
   $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Aktivacija racuna","'.$vrijemeAktivacije.'","'.$clan.'");';
   $baza ->updateDB($upit);  
   $upit='update clan  set status = "1" where akkod= "'.$akkod.'"';
   $baza->updateDB($upit);
   echo 'Vaš račun je aktiviran.';
   header("Refresh:5; ../PHP/prijavi_se.php");
   
}else{
    
    $upit='insert into statistika (akcija, vrijeme, clan) values ("Neuspjesna aktivacija racuna","'.$vrijemeAktivacije.'","'.$clan.'");';
    $baza ->updateDB($upit);
    $upit='delete from clan where akkod="'.$akkod.'";';
    $baza->updateDB($upit);
    echo 'Vrijem za aktivaciju računa je isteklo, izbrisani ste iz baze.';
    header("Refresh:5; ../PHP/registriraj_se.php");
    
}

?>