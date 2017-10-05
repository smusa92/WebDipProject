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
        $sql="SELECT COUNT(*) AS broj FROM statistika;";
        $broj = $baza->selectDB($sql)->fetch_object()->broj;
?>
<html class="pozadina">
    
    <header class="sadrzaj"  > 
       <h1>Statistika</h1> 
        <?php
        include '../PHP/pretrazivanje.php';
        include '../PHP/stranicenje.class.php';
        //funkcija za ispis brojeva straničenja
        brojevi($broj,'statistika',$stranica);
 
        

       if (isset($_SESSION['tablica2'])){
          $upit = $_SESSION['tablica2']; 
       }elseif (isset ($_SESSION['unos'])) {
           $upit="SELECT * FROM `statistika`WHERE clan LIKE '".$_SESSION['unos']."%' OR akcija LIKE '".$_SESSION['unos']."%' "
                   ."  OR clan LIKE '%".$_SESSION['unos']."%' OR akcija LIKE '%".$_SESSION['unos']."%'";
       }  else {
       //$upit="SELECT * FROM `statistika`";
           $upit=  prikazi_stranicenje($stranica, 'statistika');
       }        
       $rez = $baza->selectDB($upit);
       
       $ispis="";
       $ispis1 = "<table class='tab'><thead><th><a href=\"../PHP/sortiraj.php?&tablica=2&order=1\"><h7>ID ˇ^ </h7></a></th><th>Akcija</th><th>Vrijeme</th><th><a href=\"../PHP/sortiraj.php?&tablica=2&order=4\"><h7>Član ˇ^ </h7></a></th></th></thead>";
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
           echo '<h3>U tablici statistika ne postoji: '.$_SESSION['unos'] .'</h3>';
       }else{
       echo $ispis1;
       echo $ispis;
       }
       ?>
    </header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica2']);
unset($_SESSION['unos']);

?>
</html>
