var poljeGreske = [];

function sadrzi(obj){
    for (var i = 0; i < poljeGreske.length; i++) {
        if (poljeGreske[i] === obj) {
            return true;
        }
    }
    return false;
}

function upis_greske(polje){
    document.getElementById("greske").innerHTML = "";
    var porukaGreske = document.getElementById("greske").innerHTML;
    switch (polje.name){
        case "grad":
            porukaGreske += "Polje " + polje.name + " nema veliko početno slovo.";
            break;
        case "ime":
            porukaGreske += "Polje " + polje.name + " nema veliko početno slovo.";
            break;
        case "prezime":
            porukaGreske += "Polje " + polje.name + " nema veliko početno slovo.";
            break;
        case "adresa":
            porukaGreske += "Polje " + polje.name + " ima previše znakova.";
            break;
        case "password":
            porukaGreske += "Polje " + polje.name + " ne zadovoljava formu.";
            break;
        case "spol":
            porukaGreske += "Polje " + polje.name + " nije označeno.";
            break;
    }
    if (sadrzi(porukaGreske) === false){
        poljeGreske.push(porukaGreske);
    }
    for (var i = 0; i < poljeGreske.length; i++){
        if (poljeGreske[i] !== ""){
            document.getElementById("greske").innerHTML += poljeGreske[i] + "<br>";
        }
    }
}

function brisanje_greske(polje){
    document.getElementById("greske").innerHTML = "";
    var porukaGreske = document.getElementById("greske").innerHTML;
    switch (polje.name){
        case "grad":
            porukaGreske += "Polje " + polje.name + " nema veliko početno slovo.";
            break;
        case "ime":
            porukaGreske += "Polje " + polje.name + " nema veliko početno slovo.";
            break;
        case "prezime":
            porukaGreske += "Polje " + polje.name + " nema veliko početno slovo.";
            break;
        case "adresa":
            porukaGreske += "Polje " + polje.name + " ima previše znakova.";
            break;
        case "password":
            porukaGreske += "Polje " + polje.name + " ne zadovoljava formu.";
            break;
        case "spol":
            porukaGreske += "Polje " + polje.name + " nije označen.";
            break;
    }
    for (var i = 0; i <= poljeGreske.length; i++){
        if (poljeGreske[i] === porukaGreske){
            poljeGreske.splice(i, 1);
        }
    }
    for (var i = 0; i < poljeGreske.length; i++){
        if (poljeGreske[i] !== ""){
            document.getElementById("greske").innerHTML += poljeGreske[i] + "<br>";
        }
    }
}

function provjeriPrvoSlovo(polje){
    var vrijednost = polje.value;
    prvoSlovo = vrijednost[0];
            
    if(prvoSlovo !== prvoSlovo.toUpperCase()){
        upis_greske(polje);
        return false;
    }
    brisanje_greske(polje);
    return true;
}

function radioGumb(polje) {
    gumb = document.getElementById("poljeSpol1");
    brisanje_greske(gumb);
    var rezultat = true;
    for(var i=0;i<polje.length;i++){
        if(polje[i].type === "radio" && !polje[i].checked) {
            rezultat = false;
        }
        if(polje[i].type === "radio" && polje[i].checked) {
            rezultat = true;
            return true;
        }
    }
    if (!rezultat) {
        upis_greske(gumb);
        return false;
    }
}



var ime = document.getElementById("poljeIme");
ime.addEventListener("input", function(){
    var provjera = provjeriPrvoSlovo(ime);
    if (!provjera) {
        ime.setAttribute("class", "neispravno");
    }
    else {
        ime.setAttribute("class", "ispravno");
        
    }
}, true);

var prezime = document.getElementById("poljePrezime");
prezime.addEventListener("input", function(){
    var provjera = provjeriPrvoSlovo(prezime);
    if (!provjera) {
        prezime.setAttribute("class", "neispravno");
    }
    else {
        prezime.setAttribute("class", "ispravno");
        
    }
}, true);

var radio = document.getElementById("formaRegistracija");
radio.addEventListener("submit", function(e){
    var greska = document.getElementById("greske").value;
    var provjera = radioGumb(radio);
    if (!provjera || poljeGreske.length !== 0) {
        e.preventDefault();        
    }
});

