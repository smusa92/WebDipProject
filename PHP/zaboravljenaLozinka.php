<?php
include '../PHP/uloga.php';
include_once '../PHP/baza.class.php';

$baza = new Baza();
$baza->spojiDB();
//pomak za 24 sata 
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object ()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemZaboravljena = date('Y-m-d H:i:s', $trenutno);

$greska = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $korIme = $_POST["korime"];
    $email = $_POST["email"];
    
    $upit = 'select count(*) as broj from clan where username = "'.$korIme.'"';
    $brojK = $baza->selectDB($upit)->fetch_object()->broj;
    
    if($brojK>0){
        
        $upit= 'select count(*) as broj from clan where email = "'.$email.'"';
        $brojM= $baza->selectDB($upit)->fetch_object()->broj;
        
        if ($brojM>0){
            
          $upit= 'select ID_clan from clan where email = "'.$email.'"';  
          $rezultat1 = $baza->selectDB($upit)->fetch_object()->ID_clan;
          $upit= 'select ID_clan from clan where username = "'.$korIme.'"';  
          $rezultat2 = $baza->selectDB($upit)->fetch_object()->ID_clan;
          
          if($rezultat1==$rezultat2){
              

              $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Zaboravio lozinku","'.$vrijemZaboravljena.'","'.$korIme.'")';
              $baza->updateDB($upit);
              $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Zaboravio lozinku","'.$vrijemZaboravljena.'","'.$korIme.'")';
              $baza ->updateDB($upit);
              $novaLozinka = substr(str_shuffle(MD5(microtime())), 0, 10);
              $upit = 'update clan set lozinka = "'.$novaLozinka.'" where username = "'.$korIme.'"';
              $baza->updateDB($upit);
              //$od = 'From: smusa@foi.hr ';
              $naslovMaila = 'Nova lozinka';
              $porukaMaila  = 'Vasa nova lozinka glasi: "'.$novaLozinka.'"';
              mail($email, $naslovMaila, $porukaMaila);
              $greska .="Uspješno ste promjenili lozinku, novu lozinku pogledajte na mail: '$email'";
              
          }
          
          else{ $greska .="Korisničko ime i mail se ne poklapaju<br />";}
          
        }
        
        else{ $greska .="E-mail ne postoji u bazi.<br />";}
        
    }
    
}

//$baza->closeDB();

?>
<html class="pozadina">
    <head>
        <meta charset="UTF-8">

        <title></title>
    </head>
    <body>

    <?php
    include_once ('../XML/navigacija_za_inc.xml');
    ?>
    </body>
    <fieldset class="sadrzaj">
    <fieldset class="">
                    <legend><strong>Zaboravili ste lozinku?</strong></legend>
                    <p class="isp_greski"><?php echo $greska;?></p>
                    <form method="post" name="form1" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <p>
                    <label  for="korime">Vaše korisničko ime</label>
                    <input class="prijava" type="text" id="korime" name="korime"  maxlength="20" placeholder="Korisničko ime" ><span id="dostupnost"></span><br>
                    </p>
                    <p>
                    <label for="poljePassword">E- mail na koji želite zaprimiti novu lozinku</label>
                    <input class="prijava" type="email" name="email" id="email" placeholder="Unesite e-mail" />
                    </p>
                    
                    <p>
                    <input type="submit" name="posalji" placeholder="Pošalji" class="gumb prijava">
                    </p>
                    </form> 
    </fieldset>
        </fieldset>
</html>
<?php
include_once '../PHP/footer.php';
?>