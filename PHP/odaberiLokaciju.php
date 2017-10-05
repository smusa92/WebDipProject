<?php
include '../PHP/uloga.php';

    $id = $_GET['sifra'];
    $g= $_GET['g'];
    $u = $_GET['u'];
    $b= $_GET['b'];
    
    ?>

<html class="pozadina">
   
<header class="sadrzaj"  >
    <h2>Na lokaciji "<?php echo $g,' ', $u,' ', $b ;?>"  imate projekcije </h2>
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

$upit = "SELECT projekcije.ID_projekcije, film.naziv, film.trajanje, film.redatelj, zanrovi.naziv, projekcije.od ,projekcije.do, projekcije.max_broj_posjetitelja FROM film, projekcije, zanrovi WHERE projekcije.lokacija=".$id." AND  projekcije.film=film.ID_film AND zanrovi.ID_zanr=film.zanr;";
$rez = $baza->selectDB($upit);

$ispis = "";
$dizajn = "";



while ($jos = $rez->fetch_array()){
$odabrao1 = "svidja";
$odabrao0 = "svidja";

$clan="<table><thead><th>Lajkali su</th></thead>";

    $upit = "SELECT lajkovi.projekcija, lajkovi.lajk FROM `lajkovi` WHERE lajkovi.clan='".$_SESSION['korisnickoImeSesija']."';";
    $sto_lajkas = $baza->selectDB($upit);
   //dodjeljujem posebnu class ako je lajkano ili dislajkano 
while ($odabraniLajk = $sto_lajkas->fetch_array()){
    if($odabraniLajk[0]==$jos[0]){
        
        if($odabraniLajk[1]==1){
            
            $odabrao1="odabrano";
            $odabrao0 = "svidja";
            
        }  elseif($odabraniLajk[1]==0) {
            $odabrao0="odabrano";
            $odabrao1 = "svidja";
}
        
    }
}
    //brojač za lajkove
    $upit = "SELECT COUNT(*)as broj FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='1';";
    $brojL=$baza->selectDB($upit)->fetch_object()->broj;
    //brojač za dislajkove
    $upit = "SELECT COUNT(*)as broj FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='0';";
    $brojN=$baza->selectDB($upit)->fetch_object()->broj;
    //prikaz projekcije sa pod. iz baze
    if($vrijemeTrenutno<$jos['od'] && $jos['max_broj_posjetitelja']>0){
    $dizajn = "pregled_film";} else {
    $dizajn = "pregled_film_red";
    }   
    
    $ispis.="<div class=".$dizajn.">";
    $ispis.="<img src =\"../slike/film.png\" >";
    $ispis.="<p>Film : ".$jos[1]."<br>";
    $ispis.="Redatelj : ".$jos["redatelj"]."<br>";
    $ispis.="Žanr : ".$jos["naziv"]."<br>";
    $ispis.="Početak : ".$jos["od"]." <br>";
    $ispis.="Kraj projekcije : ".$jos["do"]." <br>";
    $ispis.="Trajanje : ".$jos["trajanje"]." min <br>";
    $ispis.="Slobodna mjesta : ".$jos["max_broj_posjetitelja"]." </p>";
      //gumbovi za rezervaciju, sviđa, ne sviđa                                          
    $ispis.="<a class=\"rezerviraj\" href=\"../PHP/rezerviraj.php?sifra=".$jos[0]."&film=".$jos[1]."&od=".$jos['od']."&do=".$jos['do']."&slobodno=".$jos[7]."\">Rezerviraj</a>";
    
    
    $ispis.="<a class=\"zelenoLajk\">+".$brojL."</a>";
    
    //prikaz clanova koji su lajkali projekciju
    $upit = "SELECT lajkovi.clan FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='1';";
    $clanoviKojiSuLajkali = $baza->selectDB($upit);
    $ispis.="<div class=\"prikaziLajkase\" >";
    while ($lajkasi = $clanoviKojiSuLajkali->fetch_array()){
    $ispis.=$lajkasi[0]."<br>";
    }
    $ispis.="</div >";$ispis.="<a class=".$odabrao1." href=\"../PHP/lajk.php?sifra=".$jos[0]."&lajk=1\">Sviđa  </a>";
    $ispis.="<a class=".$odabrao0." href=\"../PHP/lajk.php?sifra=".$jos[0]."&lajk=0\">Ne sviđa</a>";
    $ispis.="<a class=\"crvenoLajk\">+".$brojN."</a>";
    //prikaz clanova koji su dislajkali projekciju
    $upit = "SELECT lajkovi.clan FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='0';";
    $clanoviKojiSuDislajkai = $baza->selectDB($upit);
    $ispis.="<div class=\"prikaziDislajk\" >";
    while ($dislajk = $clanoviKojiSuDislajkai->fetch_array()){
    $ispis.=$dislajk[0]."<br>";
    }
    $ispis.="</div >";
    
    $ispis.="<h1>Istekla/popunjena!</h1>";
    $ispis.="</div>";
 
    
    
    
    
    }

echo $ispis;
//echo $clan;

?>
    </header>
<?php
include '../PHP/footer.php';
?>
</html>