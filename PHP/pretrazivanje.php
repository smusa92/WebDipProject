<?php
include_once  "../PHP/baza.class.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$baza = new Baza;
$baza->spojiDB();
$upit = 'select ID_clan from clan where username = "'.$userSesija.'"';
$id_clan =$baza->selectDB($upit)->fetch_object()->ID_clan;

//-----------Pomak vremena--------
$upit = "select pomaknutoVrijeme from sat where ID_sat = 1; ";
$pomak = $baza->selectDB($upit)->fetch_object()->pomaknutoVrijeme;
$trenutno = time() + ($pomak * 3600);
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);
//-----------Pomak vremena--------
     
    if(isset($_POST['pretrazi'])){
    $_SESSION['unos']= $_POST['unos'];
    }
?>


    
    
    
    <form class="forma_pretrazivanja" method="POST" name="pretrazi" enctype="multipart/form-data">
    <button class="search" type="submit" name="pretrazi"></button>  
    <input class="pretrazi" type="text" name="unos" placeholder="Pretraži" />
    </form>    

    <?php
    include '../PHP/footer.php';
    ?>
