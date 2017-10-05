<?php
include '../PHP/uloga.php';
?>

<html class="pozadina">
    
<header class="sadrzaj"  >
    <h2>Statistika lajkova </h2>
<?php
include "../PHP/baza.class.php";
if(isset($_GET['stranica'])){
    
    $stranica=$_GET['stranica'];
    
}  else {
    $stranica=1;
}
$baza = new Baza;
$baza->spojiDB();
//racuna broj za straničenje
$sql="SELECT COUNT(*) AS broj FROM lajkovi;";
$broj = $baza->selectDB($sql)->fetch_object()->broj;

include '../PHP/pretrazivanje.php';
include '../PHP/stranicenje.class.php';
//funkcija za ispis brojeva straničenja
brojevi($broj,'statistikaLajkova',$stranica);



//-----------Pomak vremena--------
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------

$sortiranje = 1;
       if (isset($_SESSION['tablica3'])){
          $upit = $_SESSION['tablica3']; 
       } elseif (isset ($_SESSION['unos'])){
           $upit="SELECT projekcije.ID_projekcije, film.naziv,"
            . " projekcije.od ,projekcije.do, lajkovi.lajk, "
            . "lajkovi.clan FROM film, projekcije, lajkovi "
            . "WHERE  projekcije.film=film.ID_film "
            . "AND projekcije.ID_projekcije=lajkovi.projekcija "
                   . "AND film.naziv LIKE '".$_SESSION['unos']."%' ";
       } else {
$upit = prikazi_stranicenjeLajk($stranica);//tutututututu
       }
$rez = $baza->selectDB($upit);


$ispis = "<table class='tab'><thead><th>ID projekcije</th><th>Film</th><th><a href=\"../PHP/sortiraj.php?&tablica=3&order=3\"><h7>OD ˇ^ </h7></a></th><th>DO </th><th><a href=\"../PHP/sortiraj.php?&tablica=3&order=5\"><h7>Sviđa ˇ^ </h7></a></th><th><a href=\"../PHP/sortiraj.php?&tablica=3&order=6\"><h7>Ne sviđa ˇ^ </h7></a></th></thead>";
$ponavljanje = array();
$ponavljanje []=0;
while ($jos = $rez->fetch_array()){

    $upit = "SELECT COUNT(*)as broj FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='1';";
    $brojL=$baza->selectDB($upit)->fetch_object()->broj;

    $upit = "SELECT COUNT(*)as broj FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='0';";
    $brojN=$baza->selectDB($upit)->fetch_object()->broj;
           
           
    
    foreach ($ponavljanje as $pon){
        
            if($pon != $jos[0]){
                $jump = 0;
            }elseif ($pon == $jos[0]) {
                $jump = 1;
                break;
            }   
       
    }       
    if($jump==0){
           $ispis.="<tr class='redak'>";
           $ispis.="<td id='id'>";
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
           $ispis.=$brojL;
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$brojN;
           $ispis.="</td>";
           $ispis.="</tr>";
           
           
           
           $ponavljanje[]=$jos[0];
    }
    
    }
    
    

echo $ispis;


?>
    </header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica3']);
unset($_SESSION['unos']);
?>
</html>

