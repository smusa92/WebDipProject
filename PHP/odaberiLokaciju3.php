<?php
include '../PHP/uloga.php';

    $id = $_GET['sifra'];
    $g= $_GET['g'];
    $u = $_GET['u'];
    $b= $_GET['b'];
    
    echo $id;
    ?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h2>Odabrali ste  lokaciju: <?php echo $g,' ', $u,' ', $b ;?> </h2>
    <h2>Prikazane su 3 projekcije koje još traju</h2>
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

//-----------Pomak vremena--------
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------

$upit = "SELECT film.naziv, film.trajanje, film.redatelj, zanrovi.naziv, projekcije.od ,projekcije.do, projekcije.max_broj_posjetitelja FROM film, projekcije, zanrovi WHERE projekcije.lokacija=".$id." AND  projekcije.film=film.ID_film AND zanrovi.ID_zanr=film.zanr;";
$rez = $baza->selectDB($upit);

$ispis = "";
$broj=0;

while ($jos = $rez->fetch_array()){
    if($broj<3){
    if($vrijemeTrenutno<$jos['od']){
    
    
    
    $ispis.="<div class='pregled_film'>";
    $ispis.="<img src =\"../slike/film.png\" >";
    $ispis.="<p>Film : ".$jos[0]."<br>";
    $ispis.="Redatelj : ".$jos["redatelj"]."<br>";
    $ispis.="Žanr : ".$jos["naziv"]."<br>";
    $ispis.="Početak : ".$jos["od"]." <br>";
    $ispis.="Kraj projekcije : ".$jos["do"]." <br>";
    $ispis.="Trajanje : ".$jos["trajanje"]." min <br>";
    $ispis.="Slobodna mjesta : ".$jos["max_broj_posjetitelja"]." </p>";
    $ispis.="</div>";
    
}
}

++$broj;

    }
echo $ispis;

?>
    </header>
<?php
include '../PHP/footer.php';
?>
</html>