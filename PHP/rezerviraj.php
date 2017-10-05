<?php

include '../PHP/uloga.php';
include "../PHP/baza.class.php";


$baza = new Baza;
$baza->spojiDB();
$upit = 'select ID_clan from clan where username = "'.$userSesija.'"';
$id_clan =$baza->selectDB($upit)->fetch_object()->ID_clan;

$obavjest = "";

//-----------Pomak vremena--------
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------

    $id = $_GET['sifra'];
    $film= $_GET['film'];
    $od= $_GET['od'];
    $do= $_GET['do'];
    $slobodno= $_GET['slobodno'];
    
    
    if(isset($_POST['rezervacija'])){
    $odabir = $_POST['odabir'];
    $id = $_GET['sifra'];
    
    if( $odabir<=$slobodno && $odabir>0){
    
    $upit="INSERT INTO `rezervacije` (`clan`, `projekcija`, `potvrda`, `vrijeme_rezervacije`, broj_mjesta) VALUES ( '".$id_clan."','".$id."','1','".$vrijemeTrenutno."','".$odabir."');";
    $baza->updateDB($upit);
    $obavjest="Poslali ste rezervaciju, nakon što je moderator potvrdi dobiti će te potvrdu mailom.";
    
    $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Zahtjev za rezervacijom","'.$vrijemeTrenutno.'","'.$_SESSION["korisnickoImeSesija"].'")';
    $baza->updateDB($upit);

    $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Zahtjev za rezervacijom","'.$vrijemeTrenutno.'","'.$_SESSION["korisnickoImeSesija"].'")';
    $baza ->updateDB($upit);
    
    header("Refresh: 7; ../PHP/potvrNePotvRezervacije.php");
    }  else {   
       $obavjest="Slobodno je ".$slobodno." mjesta, ne mozete rezervirati ".$odabir." mjesta."; 
    if($odabir==0){$obavjest="Slobodno je ".$slobodno." mjesta, nema smisla rezervirati 0 mjesta :P !!"; }
    }
    }
?>

<html class="pozadina">

<header class="sadrzaj"  >
    <h2>Trenutno je slobodnih mjesta: <?php echo $slobodno; ?> </h2>
    <h2>Koliko mjesta zelite rezervirati </h2>
    
<form method="POST" name="rezervacija" enctype="multipart/form-data">
    
<input  type="text" name = "odabir" placeholder="Broj mjesta" max="50" />
   
<h2>Želite li rezervirati projekciju za film  <?php echo '"',$film,'" koja će se održati od ', $od,'h do ', $do ;?>h ?</h2>  
    

        <input type="submit" name="rezervacija" value="DA" class="gumb">
                    <?php 
                    echo $obavjest;
                    ?>
 
</form>    
</header>
<?php
include '../PHP/footer.php';
?>
</html>