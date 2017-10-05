<?php
include '../PHP/uloga.php';
?>
<html class="pozadina">

    <header class="sadrzaj"  > <h1>Ispis svih korisnika</h1>
        <?php
       include_once '../PHP/baza.class.php';
       $baza = new Baza();
       $baza->spojiDB();

       $upit= "SELECT clan.ID_clan, clan.ime, clan.prezime ,"
               . " clan.username, clan.lozinka, clan.email,"
               . " tip_korisnika.uloga from clan "
               . "LEFT JOIN tip_korisnika ON "
               . "clan.tip_korisnika=tip_korisnika.ID_tip_korisnika;";
       $rez = $baza->selectDB($upit);

       $ispis = "<table class='tab'><thead><th>ID</th><th>Ime</th><th>Prezime</th><th>Korisnicko ime</th><th>Lozinka</th><th>E-mail</th><th>Uloga</th></thead>";
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
           $ispis.="</tr>";

       }
       echo $ispis;

       ?>
    </header>
<?php
include '../PHP/footer.php';
?>
</html>