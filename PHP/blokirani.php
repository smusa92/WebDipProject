<?php

include '../PHP/uloga.php';
?>
<html class="pozadina">
   
    <header class="sadrzaj"  > <h1>Ispis blokiranih</h1>
        <?php
       include_once '../PHP/baza.class.php';
       $baza = new Baza();
       $baza->spojiDB();
       
       if (isset($_SESSION['tablica1'])){
          $upit = $_SESSION['tablica1']; 
       }  else {
    $upit= "SELECT clan.ID_clan, clan.ime, clan.prezime , clan.username, clan.lozinka, clan.email, tip_korisnika.uloga from clan LEFT JOIN tip_korisnika ON clan.tip_korisnika=tip_korisnika.ID_tip_korisnika WHERE clan.status= '3' ORDER BY 1 ;";
  }
       $rez = $baza->selectDB($upit);
       $ispis="";
       $ispis1 = "<table class='tab'><thead><th> ID </th><th> <a href=\"../PHP/sortiraj.php?&tablica=1&order=2\"><h7>Ime ˇ^ </h7></a></th><th><a href=\"../PHP/sortiraj.php?&tablica=1&order=3\"><h7> Prezime ˇ^ </h7></a></th><th> Korisnicko ime </th><th> Lozinka </th><th> E-mail </th><th> Uloga </th><th> Odblokiraj </th></thead>";
       while ($jos = $rez->fetch_array()){

           $ispis.="<tr class='redak'>";
           $ispis.="<td id='id'>";
           $ispis.=$jos["ID_clan"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$jos["ime"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$jos["prezime"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$jos["username"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$jos["lozinka"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$jos["email"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$jos["uloga"];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.="<a href=\"../PHP/odblokiraj.php?&sifra=".$jos[0]."\"><h7>DA</h7></a>";
           $ispis.="</td>";
           $ispis.="</tr>";

       }
       if(empty($ispis)){
           echo 'Nema blokiranih clanova!!!!!!!!';
       }else{
       echo $ispis1;
       echo $ispis;
       }
       ?>
    </header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica1']);
?>
</html>