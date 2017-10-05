<?php
include "../PHP/uloga.php";
include '../PHP/autentikacija.php';
include_once '../PHP/baza.class.php';
$baza = new Baza;
$baza->spojiDB();
$greskaPrijava = "";
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object ()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemPrijave = date('Y-m-d H:i:s', $trenutno);

if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
	$url = 'https://' . $_SERVER['HTTP_HOST']
		. $_SERVER['REQUEST_URI'];
	header('Location: ' . $url);
	exit;
}

if(!isset($_SESSION))
{
	session_start();
}

if(isset($_POST['prijava'])) {
	$user = $_POST['username'];
	$pass = $_POST['lozinka'];
	$provjera=autentikacija($user,$pass);      
        $upit = 'select tip_korisnika from clan where username = "'.$user.'"';
        $uloga = $baza->selectDB($upit)->fetch_object()->tip_korisnika;
        $upit = 'select ID_clan from clan where username = "'.$user.'"';
        $id_clan =$baza->selectDB($upit)->fetch_object()->ID_clan;
        $_SESSION['id_clan']=$id_clan;
        $_SESSION['uloga'] = $uloga;
        $_SESSION["korisnickoImeSesija"]=$user;
	if($provjera==1){
            
		header("Location: ../PHP/index.php");
		$greskaPrijava="";
		setcookie('username', $user, $trenutno);

                $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Uspjesna prijava","'.$vrijemPrijave.'","'.$user.'")';
                   $baza ->updateDB($upit);
		// dnevnik (Uspjesna prijava)
                   $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Uspjesna prijava","'.$vrijemPrijave.'","'.$user.'")';
                   $baza ->updateDB($upit);
	}
	elseif ($provjera==2){
		$greskaPrijava = "Nije aktiviran korisnicki racun, aktivirajte ga preko maila";
                
		// dnevnik(Neuspjesna prijava)
                $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Neuspjesna prijava","'.$vrijemPrijave.'","'.$user.'")';
                $baza ->updateDB($upit);
		setcookie('username', $user, time() - 3600);
	}
	elseif ($provjera==3){
		$greskaPrijava = "Zakljucan je korisnicki racuna";
                $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Zaključan račun","'.$vrijemPrijave.'","'.$_SESSION["korisnickoImeSesija"].'")';
                $baza->updateDB($upit);
		// dnevnik (Zaključan račun)
                $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Zaključan račun","'.$vrijemOdjave.'","'.$user.'")';
                $baza ->updateDB($upit);
		setcookie('username', $user, time() - 3600);
	}
	elseif ($provjera==0){
		$greskaPrijava = "Nije dobro unesena lozinka ili sifra";
                $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Krivo uneseni podaci","'.$vrijemPrijave.'","'.$user.'")';
                $baza ->updateDB($upit);
		//Dnevnik (Krivo uneseni podaci)
                $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Krivo uneseni podaci","'.$vrijemPrijave.'","'.$user.'")';
                $baza ->updateDB($upit);
		setcookie('username', $user, time() - 3600);
	}
}

?>

<html class="pozadina">
    <head>
        <meta charset="UTF-8">

        <title></title>
    </head>
    <body>

        <div id="sadrzaj">
        <form method="POST" name="prijava" enctype="multipart/form-data">
            <fieldset class="sadrzaj">
                
            <fieldset class="prijava">
                <p class="greske">
                    <?php 
                    echo $greskaPrijava;
                    ?>
                </p>
                            <legend><strong>Obrazac za prijavu</strong></legend>

                            <p>
                            <label  for="korime">Korisničko ime</label>
                            <input class="prijava" type="text" id="korime" name="username"  placeholder="Korisničko ime" value="<?php if(isset($_COOKIE['username'])) echo $_COOKIE['username']; ?>"><span id="dostupnost"></span><br>
                            </p>
                            <p>
                            <label for="poljePassword">Lozinka</label>
                            <input class="prijava" type="password" name="lozinka" id="poljePassword"  placeholder="Unesite lozinku" />
                            </p>
                            <h5><a class="zab" onclick="window.location = '../PHP/zaboravljenaLozinka.php';"  >Zaboravili ste lozinku?</a></h5>
                            <p>
                            <input type="submit" name="prijava" value="Prijavi se" class="gumb prijava">
                            </p>
            </fieldset>
                </fieldset>
        </form>
        </div>
    </body>    
</html>
<?php
include_once '../PHP/footer.php';
?>
