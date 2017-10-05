<?php
    class Baza { 
        const server = "localhost";
        //const korisnik = "WebDiP2015x060";
        //const lozinka = "admin_rfP3";
        const korisnik = "root";
        const lozinka = "";
        const baza = "WebDiP2015x060";

		
        function spojiDB(){
            $mysqli = new mysqli(self::server,self::korisnik,self::lozinka,self::baza);
            if($mysqli->connect_errno){
                echo "Neuspješno spajanje na bazu: ".$mysqli->connect_errno.", ".
                    $mysqli->connect_error;
            }
            return $mysqli;
        }
        
        function selectDB($upit){
            $veza = $this->spojiDB();
            $rezultat = $veza->query($upit) or trigger_error("Greška kod upita: {$upit} - ".
                    "Greška: ".$veza->error . " " . E_USER_ERROR);
            
            if(!$rezultat){
                $rezultat = null;
            }        
            $veza->close();
            return $rezultat;
        }

        function updateDB($upit,$skripta=''){
            $veza = $this->spojiDB();
            if($rezultat = $veza->query($upit)){
                $veza->close();
                
                if($skripta != ''){
                    header("Location: $skripta");
                }
                
                return $rezultat;
                
            }else{
                echo "Pogreška: ".$veza->error;
                $veza->close();
                return $rezultat; 
            }
        }
        function closeDB($veza){
            $veza->close();
        }
    }


