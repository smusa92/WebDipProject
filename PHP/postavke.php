<?php

include '../PHP/uloga.php';
include '../PHP/stranicenje.class.php';
include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();

$obavjest = "";

$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------



    if(isset($_POST['rezervacija'])){
    $odabir = $_POST['odabir'];
    $upit="UPDATE `sat` SET `pomaknutoVrijeme` = '".$odabir."' WHERE `sat`.`ID_sat` = '1';";
    $baza->updateDB($upit);
    
    $obavjest="Vrijeme je pomaknuto za ".$odabir." h.";
    }

?>
<html class="pozadina">

    <header class="sadrzaj"  > <h1>Postavke: </h1>
        <hr>
        <h2>Promjeni broj za ispis(stranjičenje): </h2>
        <?php
       include_once '../PHP/baza.class.php';
       $baza = new Baza();
       $baza->spojiDB();
       
       promjeni_odabirt();
       
       ?>
        <hr>
       <h2>Promjeni pomak vremena: </h2> 
        <h2>Trenutni pomak vremena je: <?php echo $pomak; ?> h </h2>
<h2>Koliko pomak želite postaviti: </h2>

<form method="POST" name="rezervacija" enctype="multipart/form-data">

<input  type="text" name = "odabir" placeholder="sati"  /> 

<input type="submit" name="rezervacija" value="DA" class="gumb">
            <?php 
            echo $obavjest;
            ?>

</form>
<hr>
    </header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica1']);
?>
</html>
