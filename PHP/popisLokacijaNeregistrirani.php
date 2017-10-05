<?php

include '../PHP/uloga.php';

?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h1>Lokacije projekcija</h1>
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

$upit = "SELECT lokacija.ID_lokacija, drzave.naziv, lokacija.grad, lokacija.ulica, lokacija.broj from drzave right JOIN lokacija ON drzave.ID_drzave=lokacija.drzava;";
$rez = $baza->selectDB($upit);

$ispis= " " ;
while ($jos = $rez->fetch_array()){
    
    $ispis.="<div class='pregled'>";
    $ispis.="<img src =\"../slike/kino_king.jpg\" >";
    $ispis.="<p>Šifra : ".$jos["ID_lokacija"]."<br>";
    $ispis.="Država : ".$jos["naziv"]."<br>";
    $ispis.="Grad : ".$jos["grad"]."<br>";
    $ispis.="Ulica : ".$jos["ulica"]." <br>";
    $ispis.="Broj : ".$jos["broj"]." </p>";
    $ispis.="<a  href=\"../PHP/odaberiLokaciju3.php?&sifra=".$jos[0]."&g=".$jos[2]."&u=".$jos[3]. "&b=".$jos[4]."\"> Odaberi lokaciju </a>";
    $ispis.= "<a href=\"https://maps.google.com?q=".$jos["broj"]."+".$jos["ulica"]."+".$jos["grad"]."+".$jos["naziv"]."\"> Google Maps</a>";
    $ispis.="</div>";

}
echo $ispis;
?>
</header>
<?php
include '../PHP/footer.php';
?>
</html>
