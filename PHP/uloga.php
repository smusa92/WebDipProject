<?php
$opcije="";
session_start();
?>
<!DOCTYPE html>
<head>
    <title>KINO KING</title>
    <meta charset="UTF-8"> 
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <link media="screen and (max-width: 450px)" href="../css/mobitel.css" rel="stylesheet" type="text/css"/>
    <link media="all and (min-width: 450px) and (max-width: 700px)" href="../css/tableti.css" rel="stylesheet" type="text/css"/>
    <link media="all and (min-width: 700px) and (max-width: 1500px)" href="../css/glavna.css" rel="stylesheet" type="text/css"/>
    <link media="all and (min-width: 1500px)" href="../css/tv.css" rel="stylesheet" type="text/css"/>
</head>

<?php /*Neregistrirani*/if(empty($_SESSION['korisnickoImeSesija']) && empty($_SESSION['uloga'])){  $userSesija ="gost";?>
<head>
    
</head>    
<header>  
        <div >
            <p class="naslov" >KINO KING</p>
            <h4 class="prijavljeni"><a  > Koristite sustav kao <h3><?php echo $userSesija; ?></h3></a></h4>
        </div>     
    <nav>
        <ul>
        
        <li class="desno"><a href="../PHP/prijavi_se.php">Prijavi se</a></li>
        <li class="desno" ><a href="../PHP/registriraj_se.php">Registriraj se</a></li>
        <script language="php">
        include_once ('../XML/navigacija_za_inc.xml');
        </script>
        </ul>
        <ul>
            <li><a href= '../PHP/popisLokacijaNeregistrirani.php'>Popis lokacija</a></li>
        </ul>
    </nav>
</header>
    
       
    

<?php }?>



<?php /*Registrirani*/ if(isset($_SESSION['korisnickoImeSesija']) && ($_SESSION['uloga'] == 3|| $_SESSION['uloga'] == 2||$_SESSION['uloga'] == 1)) {$userSesija =$_SESSION['korisnickoImeSesija'];?>
    
<header> 
        <div>
            <p class="naslov" >KINO KING</p>
            <h4 class="prijavljeni"><a  > Koristite sustav kao <h3><?php echo $userSesija; ?></h3></a></h4>
        </div>     
    <nav>
        
        <ul>
        <script language="php">
        include_once ('../XML/navigacija_za_inc.xml');
        </script>
        </ul><?php
        $opcije="<div class=\"opcije\"><div class=\"dropdown-content\">"
                . "<a href=\"../PHP/potvrNePotvRezervacije.php\">Lokacije</a>"
                . "<a href=\"../PHP/pregledRezervacijaKor.php\">Potvrđene rezervacije</a>"
                . "<a href=\"../PHP/pregledRezervacijaKorNe.php\">Nepotvrđene rezervacije</a>";
                
        
        ?>
        
    </nav>
</header>
<?php }?>

<!-- Moderator -->

<?php /*Moderator*/ if(isset($_SESSION['korisnickoImeSesija']) && ($_SESSION['uloga'] == 2||$_SESSION['uloga'] == 1)) {$userSesija = $_SESSION['korisnickoImeSesija'];

        
   $opcije.= "<a href=\"../PHP/dodajProjekciju.php\">Dodaj projekciju</a>"
           . "<a href=\"../PHP/rezervacijeModerator.php\">Potvrde rezervacije</a>"
           . "<a href=\"#\">Popis slika ulaznica</a>"
            ."<a href=\"../PHP/statistikaLajkova.php\">Statistika lajkova</a>";
        
          
   
}?>



<?php /*Administrator*/
    if(isset($_SESSION['korisnickoImeSesija']) && $_SESSION['uloga'] == 1) {
    $userSesija =$_SESSION['korisnickoImeSesija']
;

        $opcije.="<a href=\"../PHP/dodjela_adrese.php\">Dodjela adrese</a>"
                . "<a href=\"../PHP/KiD_moderatora.php\">Kreiranje i dodjela moderatora</a>"
                . "<a href=\"#\">Update</a>"
                . "<a href=\"../PHP/statistika.php\">Statistika</a>"
                . "<a href=\"../PHP/dnevnik.php\">Dnevnik</a>"
                . "<a href=\"../PHP/blokirani.php\">Blokirani</a>"
                . "<a href=\"../PHP/postavke.php\">Postavke</a>";

}
 $opcije.="<a  href=\"../PHP/odjava.php\" ><div class=\"odjava\"></div></a>"
         . "</div></div>"; 
 if( empty($_SESSION['korisnickoImeSesija'] )){
     $opcije="";
 }
echo $opcije;
?>
