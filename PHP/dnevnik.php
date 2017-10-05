<?php
include '../PHP/uloga.php';
include_once '../PHP/baza.class.php';
if(isset($_GET['stranica'])){
    
    $stranica=$_GET['stranica'];
    
}  else {
    $stranica=1;
}
        $baza = new Baza();
        $baza->spojiDB();
        //racuna broj za straničenje
        $sql="SELECT COUNT(*) AS broj FROM dnevnik;";
        $broj = $baza->selectDB($sql)->fetch_object()->broj;

?>
<html class="pozadina">
    
    <header class="sadrzaj"  > <h1>Dnevnik</h1>
        <?php
        include '../PHP/pretrazivanje.php';
        include '../PHP/stranicenje.class.php';
       
       //funkcija za ispis brojeva straničenja
        brojevi($broj,'dnevnik',$stranica);

       if (isset($_SESSION['tablica4'])){
          $upit = $_SESSION['tablica4']; 
       } elseif (isset ($_SESSION['unos'])) {
           $upit="SELECT * FROM `dnevnik` WHERE clan LIKE '".$_SESSION['unos']."%' OR akcija LIKE '".$_SESSION['unos']."%' "
                   . "OR clan LIKE '%".$_SESSION['unos']."%' OR akcija LIKE '%".$_SESSION['unos']."%'";
       } else {
       //$upit="SELECT * FROM `statistika`";
           $upit=  prikazi_stranicenje($stranica, 'dnevnik');
       }
       $rez = $baza->selectDB($upit);
       $ispis="";
       $ispis1 = "<table class='tab'><thead><th><a href=\"../PHP/sortiraj.php?&tablica=4&order=1\"><h7>ID ˇ^ </h7></a></th><th>Član</th><th><a href=\"../PHP/sortiraj.php?&tablica=4&order=3\"><h7>Vrijeme ˇ^ </h7></a></th><th>Akcija</th></th></thead>";
       while ($jos = $rez->fetch_array()){

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
           $ispis.="</tr>";

       }
       if(empty($ispis)){
           echo '<h3>U tablici dnevnik ne postoji: '.$_SESSION['unos'] .'</h3>';
       }else{
       echo $ispis1;
       echo $ispis;
       }
       ?>
    </header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica4']);
unset($_SESSION['unos']);
?>
</html>
