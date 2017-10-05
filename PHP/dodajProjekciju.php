<?php
include "../PHP/uloga.php";
include_once '../PHP/baza.class.php';
$greske="";
$ispis= "";
$ispisF= "";
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

$id_clan=$_SESSION['id_clan'];

    $upit="SELECT ID_film, naziv FROM `film`";
    $film=$baza->selectDB($upit);
    $ispisF.="<select name=\"film\">";
    while ($jos = $film->fetch_array()){
        $ispisF.="<option value=\"";
        $ispisF.=$jos[0];
        $ispisF.="\">";
        $ispisF.=$jos[1];
        $ispisF.=" ";
        $ispisF.="</option>";
    }
    $ispisF.="</select>";
    
    $ispis.="</select>";
    $upit="SELECT moderator_lokacija.lokacija, lokacija.grad, lokacija.ulica, lokacija.broj FROM "
            . "`moderator_lokacija`, lokacija WHERE moderator_lokacija.clan='".$id_clan."' "
            . "AND lokacija.ID_lokacija=moderator_lokacija.lokacija;";
    $lokacije =$baza->selectDB($upit);
    $ispis.="<select name=\"lokacija\">";
    while ($jos = $lokacije->fetch_array()){
        $ispis.="<option value=\"";
        $ispis.=$jos[0];
        $ispis.="\">";
        $ispis.=$jos[1];
        $ispis.=" ";
        $ispis.=$jos[2];
        $ispis.=" ";
        $ispis.=$jos[3];
        $ispis.=" ";
        $ispis.="</option>";
    }
    $ispis.="</select>";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    
    $film = $_POST["film"];
    $lokacija = $_POST["lokacija"]; 
    $od = $_POST["od"];
    $do = $_POST["do"];
    $max_broj_posjetitelja = $_POST["max_broj_posjetitelja"];
   
    
    $greske = "";
    $brojac = 1;

    if (empty($film)) {
        $greske .= $brojac . '.' . ' ' . 'film nije upisana' . "<br>";
        $brojac++;
    }
    
    if (empty($lokacija)) {
        $greske .= $brojac . '.' . ' ' . 'lokacija nije upisan' . "<br>";
        $brojac++;
    }
    
    if (empty($od)) {
        $greske .= $brojac . '.' . ' ' . 'Trajanje od nije upisano' . "<br>";
        $brojac++;
    }
    
    if (empty($do)) {
        $greske .= $brojac . '.' . ' ' . 'Trajanje do nije upisano' . "<br>";
        $brojac++;
    }
    if (empty($max_broj_posjetitelja)) {
        $greske .= $brojac . '.' . ' ' . 'Max broj posjetitelja nije upisan!' . "<br>";
        $brojac++;
    }

    if (empty($greske)) {
    $upit = "INSERT INTO `projekcije` (`ID_projekcije`, `film`, `lokacija`, `od`, `do`, `max_broj_posjetitelja`) VALUES "
            . "(default, '".$film."', '".$lokacija."', '".$od."', '".$do."', '".$max_broj_posjetitelja."')";
    $baza->updateDB($upit);
    $upit = 'insert into statistika (akcija, vrijeme, clan) values ("Moderator dodaje projekciju","'.$vrijemOdjave.'","'.$_SESSION["korisnickoImeSesija"].'")';
    $baza->updateDB($upit);

    $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Moderator dodaje projekciju","'.$vrijemOdjave.'","'.$_SESSION["korisnickoImeSesija"].'")';
    $baza ->updateDB($upit);
    $greske .="Uspjesno ste unjeli Projekciju, ne treba ništa prepravljati";
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
                    <legend><strong>Dodaj projekciju</strong></legend> 
                    <fieldset class="greske">          
                    <legend><strong>Što je potrebno prepraviti</strong></legend>    
                    
                    <p class="isp_greski"><?php  echo $greske;?></p>
                </fieldset>
    
    <form id="reg" name="reg" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <p>
                <label for="film">Filma ID: </label>
                <?php echo $ispisF; ?><br><br>

                <label for="lokacija">Lokacija ID: </label>
                <?php echo $ispis; ?><br><br>

                <label for="od">Početak projekcije: </label>
                <input type="datetime" name="od" placeholder="2017-02-20 18:00:00" ><br><br>
                
                <label for="do">Kraj projekcije: </label>
                <input type="datetime" name="do" placeholder="2017-02-20 20:00:00" ><br><br>
                
                <label for="max_broj_posjetitelja">Maksimalni broj posjetitelja: </label>
                <input  type="text" name="max_broj_posjetitelja" ><br><br>

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