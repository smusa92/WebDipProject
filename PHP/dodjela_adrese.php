<?php
include "../PHP/uloga.php";
include_once '../PHP/baza.class.php';
$greske="";
$ispis= "";

if(!isset($_SESSION))
{
	session_start();
}
$baza = new Baza;
$baza->spojiDB();

$upitV = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upitV)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemOdjave = date('Y-m-d H:i:s', $trenutno);

    $ispis.="</select>";
    $upit="SELECT * FROM `drzave`";
    $lokacije =$baza->selectDB($upit);
    $ispis.="<select name=\"drzava\">";
    while ($jos = $lokacije->fetch_array()){
        $ispis.="<option value=\"";
        $ispis.=$jos[0];
        $ispis.="\">";
        $ispis.=$jos[1];
        $ispis.=" ";
        $ispis.="</option>";
    }
    $ispis.="</select>";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    
    $drzava = $_POST["drzava"];
    $grad = $_POST["grad"]; 
    $ulica = $_POST["ulica"];
    $broj = $_POST["broj"];
    
   
    
    $greske = "";
    $brojac = 1;

    if (empty($drzava)) {
        $greske .= $brojac . '.' . ' ' . 'država nije odabrana' . "<br>";
        $brojac++;
    }
    
    if (empty($grad)) {
        $greske .= $brojac . '.' . ' ' . 'grad nije upisan' . "<br>";
        $brojac++;
    }
    
    if (empty($ulica)) {
        $greske .= $brojac . '.' . ' ' . 'ulica nije upisana' . "<br>";
        $brojac++;
    }
    
    if (empty($broj)) {
        $greske .= $brojac . '.' . ' ' . 'broj nije upisan' . "<br>";
        $brojac++;
    }

    if (empty($greske)) {
    $upit = "INSERT INTO `lokacija` ( `drzava`, `grad`, `ulica`, `broj`) VALUES "
            . "('".$drzava."', '".$grad."', '".$ulica."', '".$broj."')";
    $baza->updateDB($upit);
    $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Dodjeljena adresa ADMIN","'.$vrijemOdjave.'","'.$_SESSION["korisnickoImeSesija"].'")';
    $baza->updateDB($upit);

    $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Dodjeljena adresa ADMIN","'.$vrijemOdjave.'","'.$_SESSION["korisnickoImeSesija"].'")';
    $baza ->updateDB($upit);
    
    $greske .="Uspjesno ste unjeli adresu, ne treba ništa prepravljati<hr>";
    }
}

?>
<html class="pozadina">
    <head>
        <meta charset="UTF-8">

        
        <title></title>
    </head>
    <body >
    <fieldset class="regOkvir">
                <fieldset>
                    <legend><strong>Dodaj adresu</strong></legend> 
                             
                       
                    
                    <p ><?php  echo $greske;?></p>
               
    
    <form id="reg" name="reg" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <p>
                <label for="drzava">Država: </label>
                <?php echo $ispis; ?><br><br>

                <label >Grad: </label>
                <input type="text" name="grad" placeholder="Varaždin"><br><br>

                <label >Ulica: </label>
                <input type="datetime" name="ulica" placeholder="Trakošćanska" ><br><br>
                
                <label >Broj: </label>
                <input type="datetime" name="broj" placeholder="10" ><br><br>

                <input class="gumb" id="registracija" type="submit" value=" Spremi ">
            </p> 
        </form>
    
    </fieldset>
                    </fieldset> 
</body>
</html>


<?php
include_once '../PHP/footer.php';
?>