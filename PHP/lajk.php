<?php

session_start();

include './baza.class.php';

$baza = new Baza();
$baza->spojiDB();

$sifra = $_GET['sifra'];
$lajk = $_GET['lajk'];

$upit = "select lajkovi.ID_like, lajkovi.lajk, lajkovi.projekcija, lajkovi.clan from lajkovi where projekcija = '" . $sifra . "' AND clan = '".$_SESSION['korisnickoImeSesija']."';";
$rez = $baza->selectDB($upit);

if($rez ->num_rows !=0) {
$poljeLajkova = mysqli_fetch_array($rez);      


if($poljeLajkova[3] == $_SESSION['korisnickoImeSesija'] && $poljeLajkova[2]==$sifra){
    
        $upit="UPDATE `lajkovi` SET `lajk`='".$lajk."' WHERE ID_like='".$poljeLajkova[0]."'";
        $baza->updateDB($upit);
        if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }   

} } else {
    
        $upit = "INSERT INTO `lajkovi` (`lajk`, `projekcija`, `clan`) VALUES ( '".$lajk."', '".$sifra."', '".$_SESSION['korisnickoImeSesija']."');";
        $baza->updateDB($upit);
        
        if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }  
    
}
?>

