<?php
include "../PHP/uloga.php";
$greska = "";

include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();

//-----------Pomak vremena--------
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object ()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemRegistracije = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------

if(isset($_POST['registracija'])){
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $username = $_POST['korime'];
    $password = $_POST['password'];
    $datum = $_POST['datum'];
    $spol = $_POST['spol'];
    
    if (empty($ime)) {
        $greska .= "Polje ime nije ispunjeno.<br />";
    }
    if ($ime != ucfirst($ime) && !empty($ime)) {
        $greska .= "Ime ne počinje velikim slovom.<br />";
    }
    if (empty($prezime)) {
        $greska .= "Polje prezime nije ispunjeno.<br />";
    }
    if ($prezime != ucfirst($prezime) && !empty($prezime)) {
        $greska .= "Prezime ne počinje velikim slovom.<br />";
    }
    if (empty($email)) {
        $greska .= "Polje email nije ispunjeno.<br />";
    }
    if (empty($username)) {
        $greska .= "Polje korisničko ime nije ispunjeno.<br />";
    }
    if (mb_strlen($username) < 5) {
        $greska .= "Korisničko ime mora sadržavati minimalno 5 znakova.<br />";
    }
    if (empty($password)) {
        $greska .= "Polje lozinka nije ispunjeno.<br />";
    }
    if (empty($datum)) {
        $greska .= "Polje datum nije ispunjeno.<br />";
    }
    if (empty($spol)) {
        $greska .= "Spol nije odabran.<br />";
    }
    
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $greska .= "Netočno strukturirana e-mail adresa";
    }
    
    
    $uzorak = '/(?=(.*\d))(?=.*[a-z])(?=.*[A-Z]).{6,}/';
    if(!preg_match($uzorak ,$password)){
        $greska .= "Krivo strukturirana lozinka mora sadrzavati veliko, malo slovo i broj! <br />";
    }
    
    if(empty($greska)){
        $upit = "select * from statistika where clan = '".$username."'";
        $rezultat = $baza->selectDB($upit);
        $upit = "select * from clan where email = '".$email."'";
        $rezultat1 = $baza->selectDB($upit);
        $aktivacijskiKod = hash('md5', $email);
        
        do{
            $upit = "select * from clan where akkod = '".$aktivacijskiKod."'";
            $rezultat2 = $baza->selectDB($upit);
        }while($rezultat2->num_rows != 0);
        if($rezultat->num_rows != 0){
            $greska .= "Zauzeto korisnicko ime.<br />";
        }
        elseif ($rezultat1->num_rows != 0)
        {
            $greska .= "Zauzeta email adresa.<br />";
        }
        else {
            
            $upit = "Insert into clan"
            . " ( ime, prezime, email, username, lozinka, datum_r, spol, akkod) "
            . "values "
            . "('".$ime."',"
            . " '".$prezime."',"
            . " '".$email."',"
            . " '".$username."',"
            . " '".$password."',"
            . " '".$datum."' ,"
            . "'".$spol."' , "
            . "'".$aktivacijskiKod."')";  
                  
            if($baza->updateDB($upit)){
                
                $upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
                $pomak = $baza->selectDB($upit)->fetch_object ()->pomaknutoVrijeme;
                $trenutno = time() + ($pomak * 3600);
                $vrijemRegistracije = date('Y-m-d H:i:s', $trenutno);
                $upit = "insert into statistika (akcija, vrijeme, clan) values ('Registracija korisnika', '".$vrijemRegistracije."', '".$username."')";
                $baza->updateDB($upit);
                $upit = "insert into dnevnik (akcija, vrijeme, clan) values ('Registracija korisnika', '".$vrijemRegistracije."', '".$username."')";
                $baza->updateDB($upit);
                $primatelj = $email;
                $naslov = "Aktivacija korisnickog racuna";
                $poruka = "Postovani/a, <br /><br />Aktivirajte svoj racun na: http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x060/PHP/mailAktivacija.php?aktivacijski=$aktivacijskiKod&vrijemeReg=$trenutno ";
                mail($primatelj, $naslov, $poruka);
                header("Location: index.php");}
            else {
                $greska .= "Greška pri radu sa bazom podataka.<br />";
            }
        }
    }
}
if(isset($_POST['submit'])) {
     
        // check reCAPTCHA information
        require_once('recaptcha-php-1.11/recaptchalib.php');
         
        $privatekey = "6LcNdggTAAAAAHYQhktLrVqAJyliWTaN-vEV5vZ6";
        $resp = recaptcha_check_answer ($privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"]);
                        
        if ($resp->is_valid) {
                               
        } else {
            $poruka.= "Pogresan recaptcha unos";
            header("Location: registracija.php");
        }
    }
    ?>
<html class="pozadina">
    
    <head>
        <meta charset="UTF-8">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <title></title>
    </head>
    <body>

        <div id="sadrzaj">

            <form method="POST" name="registracija" id="formaRegistracija" enctype="multipart/form-data">
                <fieldset class="regOkvir">
                <fieldset>
                    <legend><strong>Obrazac za registraciju</strong></legend> 
                <fieldset class="greske">          
                    <legend><strong>Što je potrebno prepraviti</strong></legend>    
                    
                    <p class="isp_greski"><?php echo $greska;?></p>
                </fieldset>
                <p>
                <label for="poljeIme">Ime</label>
                <input class="reg" type="text" name="ime" id="poljeIme" placeholder="Unesite ime"  /><br />
                </p>
                
                <p>
                <label for="poljePrezime">Prezime</label>
                <input class="reg" type="text" name="prezime" id="poljePrezime" placeholder="Unesite prezime" size="20" maxlength="50" /><br />
                </p>
                
                <p>
                    <label for="poljeEmail">E-pošta</label>
                    <input class="reg" type="email" name="email" id="poljeEmail" placeholder="Unesite e-mail" /><br />
                </p>
                
                <p>
                    <label for="korime">Korisničko ime</label>
                    <input class="reg" type="text" id="korime" name="korime"  maxlength="20" placeholder="korisničko ime" onblur="Provjeri()"><span id="dostupnost"></span><br>
                </p>
                
                <p>
                    <label for="poljePassword">Lozinka</label>
                    <input class="reg" type="text" name="password" id="poljePassword" placeholder="Unesite lozinku" />
                </p>
                
               
                    <label for="poljePassword1">Potvrda lozinke</label>
                   <input class="reg" type="password" name="password1" id="poljePassword1" placeholder="Ponovite lozinku" />
                </p>

                <p>
                    <label for="poljeDatum">Datum rođenja</label>
                    <input class="reg" type="date" name="datum" id="poljeDatum" placeholder="yyyy-mm-dd" />
                    <br />
                </p>
                
                <p>
                <label>Odaberite spol:</label>
                <input class="radioFirst" type="radio" name="spol" value="musko"  >MUŠKO
                <input class="radio" type="radio" name="spol" value="zensko" checked="checked" >ŽENSKO 
                <br />
                </p>
                
                <div class="g-recaptcha" name="g-recaptcha" data-sitekey="6LdQHyITAAAAALtnch3z1QZdD3YNhlln3yFHKPup" data-theme="dark"></div>

                <p>
                <input type="submit" name="registracija" value="Registriraj se" class="gumb">
                <input type="reset" value="Očisti" class="gumb">
                </p>
                </fieldset>
                    </fieldset>
            </form>
        </div>
    </body>
        <script src="https://www.google.com/recaptcha/api.js?hl=hr"></script>
        <script type="text/javascript" src="../JS/smusa.js"></script>
        <script type="text/javascript" src="../JS/registracija.js"></script>
        <noscript>Preglednik ne može učitati JavaScript! </noscript>
</html>
<?php
include_once '../PHP/footer.php';
?>
        