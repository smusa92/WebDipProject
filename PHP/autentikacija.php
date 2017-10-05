<?php
include_once '../PHP/baza.class.php';
function autentikacija($user,$pass){
    $baza = new Baza();
    $baza ->spojiDB();
    $rezultat=0;
    $upit="select lozinka, status, greska_prijava from clan where username = '".$user."';";
    $rez = $baza->selectDB($upit);
    if($rez ->num_rows !=0) {
        
        $status = mysqli_fetch_array($rez);
        if ($status['lozinka'] == $pass) {
        $upit = "UPDATE `clan` SET `greska_prijava` = 0 WHERE `clan`.`username` = '".$user."';";
        $baza->updateDB($upit);  
            if ($status['status'] == '1') {
                $rezultat = 1;
            } elseif ($status['status'] == '2') {
                $rezultat = 2;
            } elseif ($status['status'] == '3') {
                $rezultat = 3;
            }
        }
        elseif($status['greska_prijava'] == 3){
                // zaključavanje clana
                $upit = "UPDATE `clan` SET status = 3 WHERE `clan`.`username` = '".$user."';";
                $baza->updateDB($upit);
            }
            else {
                $upit = "UPDATE `clan` SET `greska_prijava` = `greska_prijava`+ 1 WHERE `clan`.`username` = '".$user."';";
                $baza->updateDB($upit);
          }   
    }
    else{$rezultat = 0;} return $rezultat;
}
?>

