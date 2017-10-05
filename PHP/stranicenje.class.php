<?php
include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();

$upit= "SELECT sat.pomaknutoVrijeme FROM `sat` WHERE ID_sat=2;";
$GLOBALS['$odabir_stranicenje']= $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;

function promjeni_odabirt (){
include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();
   if(isset($_POST['promjeni_stranicenje'])){
   $upit="UPDATE  sat SET pomaknutoVrijeme = '".$_POST['odabir']."' WHERE ID_sat=2;";
   $baza->updateDB($upit);
   }
   $_SESSION['odabir']=$GLOBALS['$odabir_stranicenje'];
   ?>  

<form method="POST" name="promjeni_stranicenje" enctype="multipart/form-data">
<input  type="text" name = "odabir" placeholder="broj_stranicenje"  />
<input type="submit" name="promjeni_stranicenje"  class="gumb">
</form> 
    
<?php 
}
                   

function prikazi_stranicenje ($test, $tablica){
    $limit_kraj=$GLOBALS['$odabir_stranicenje'];
    $limit_start=($test*$limit_kraj)-$limit_kraj;
    $sql_stranicenje="SELECT * FROM ".$tablica." LIMIT ".$limit_start.", ".$limit_kraj."";
    
    return $sql_stranicenje;
    
}
function prikazi_stranicenjeLajk ($test){
    $limit_kraj=$GLOBALS['$odabir_stranicenje'];
    $limit_start=($test*$limit_kraj)-$limit_kraj;
    $sql_stranicenje="SELECT projekcije.ID_projekcije, film.naziv,"
            . " projekcije.od ,projekcije.do, lajkovi.lajk, "
            . "lajkovi.clan FROM film, projekcije, lajkovi "
            . "WHERE  projekcije.film=film.ID_film "
            . "AND projekcije.ID_projekcije=lajkovi.projekcija "
            . "LIMIT ".$limit_start.", ".$limit_kraj."";
    
    return $sql_stranicenje;
    
}
function prikazi_stranicenjeLokacije ($test){
    $limit_kraj=$GLOBALS['$odabir_stranicenje'];
    $limit_start=($test*$limit_kraj)-$limit_kraj;
    $sql_stranicenje="SELECT lokacija.ID_lokacija, drzave.naziv, lokacija.grad, "
        . "lokacija.ulica, lokacija.broj from drzave right "
        . "JOIN lokacija ON drzave.ID_drzave=lokacija.drzava "
            . "LIMIT ".$limit_start.", ".$limit_kraj."";
    
    return $sql_stranicenje;
    
}

function brojevi ($broj,$putanja,$stranica){
$rez = $broj/$GLOBALS['$odabir_stranicenje'];
        $test=0;
        
    $naprijed=$stranica+1;
    $nazad=$stranica-1;
    if($nazad<1) {$nazad=1;}
    if($naprijed>  ceil($rez)) {$naprijed=ceil($rez);}
    
$strani="<div class=\"pagination\"><h4>Straničenje: ".$GLOBALS['$odabir_stranicenje']." Stranica: $stranica </h4><a href=\"../PHP/$putanja.php?stranica=$nazad\">&laquo;</a>";

        
        for($i=$rez;$i>0;$i--){ 
           $test++; 
           if($test<10){
            $strani.="<a href=\"../PHP/$putanja.php?stranica=$test\">$test</a>";
        }  else if($test==ceil($rez)) {
            $strani.="<a >...</a><a href=\"../PHP/$putanja.php?stranica=$test\">$test</a>";
        }}
        
        
        
$strani.="<a href=\"../PHP/$putanja.php?stranica=$naprijed\">&raquo;</a></div></br></br></br>";
echo $strani;
}
?>