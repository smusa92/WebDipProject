<?php

include '../PHP/uloga.php';

?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h1>Potvrđene rezervacije</h1>
<?php

include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

$upit = 'select ID_clan from clan where username = "'.$userSesija.'"';
$id_clan =$baza->selectDB($upit)->fetch_object()->ID_clan;
$_SESSION['id_clan']=$id_clan;

$upit = "SELECT rezervacije.ID_rezervacije, film.naziv, lokacija.grad,lokacija.ulica,lokacija.broj, rezervacije.broj_mjesta, rezervacije.vrijeme_rezervacije, clan.username, rezervacije.projekcija"
        . " FROM rezervacije "
        . "JOIN projekcije ON rezervacije.projekcija=projekcije.ID_projekcije "
        . "JOIN lokacija ON projekcije.lokacija=lokacija.ID_lokacija "
        . "JOIN film ON film.ID_film=projekcije.film JOIN clan ON rezervacije.clan=clan.ID_clan "
        . "AND rezervacije.potvrda=1;";
$rez = $baza->selectDB($upit);

$ispis = "<table><thead><th>Sifra</th><th>Film</th><th>Grad</th><th>Ulica</th><th>Broj</th><th>Zatrazena mjesta</th><th>Vrijeme rezervacije</th><th>Korisnik</th><th>Sifra_P</th><th>Potvrdi</th><th>Odbij</th></thead>";
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
    $ispis.="<td>";
    $ispis.=$jos[6];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[7];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[8];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.="<a href=\"../PHP/potvrdiRezervaciju.php?&odabir=1&broj_m=".$jos[5]."&sifra=".$jos[0]."&clan=".$jos[7]."&sifra_p=".$jos[8]."\"><h7>Potvrdi</h7></a>";
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.="<a href=\"../PHP/potvrdiRezervaciju.php?&odabir=0&broj_m=".$jos[5]."&sifra=".$jos[0]."&clan=".$jos[7]."&sifra_p=".$jos[8]."\"><h7>Odbij</h7></a>";
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

