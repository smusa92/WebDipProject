<?php

include '../PHP/uloga.php';

?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h1>Nepotvrđene rezervacije</h1>
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();



$upit = "SELECT film.naziv, lokacija.grad,lokacija.ulica,lokacija.broj, rezervacije.broj_mjesta, rezervacije.vrijeme_rezervacije"
        . " FROM rezervacije "
        . "JOIN projekcije ON rezervacije.projekcija=projekcije.ID_projekcije "
        . "JOIN lokacija ON projekcije.lokacija=lokacija.ID_lokacija "
        . "JOIN film ON film.ID_film=projekcije.film "
        . "AND rezervacije.clan= '".$_SESSION['id_clan']."' AND rezervacije.potvrda=1;";
$rez = $baza->selectDB($upit);

$ispis = "<table><thead><th>Film</th><th>Grad</th><th>Ulica</th><th>Broj</th><th>Zatrazena mjesta</th><th>Vrijeme rezervacije</th></thead>";
while ($jos = $rez->fetch_array()){

    $ispis.="<tr >";
    $ispis.="<td>";
    $ispis.=$jos[0];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[1];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[2];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[3];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[4];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[5];
    $ispis.="</td>";
    $ispis.="</tr>";


}
echo $ispis;
?>
</header>
<?php
include '../PHP/footer.php';
?>
</html>
