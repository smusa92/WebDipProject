function Provjeri() {
    var provjeraPass = false;
    var provjeraPass1 = false;
    var provjeraUser = false;
    var provjeraMail = false;

        jQuery.ajax(
                {
                    url: './provjeraKorisnika.php',
                    data: 'korisnicko=' + $("#korime").val(),
                    type: "POST",
                    success: function (data) {
                        $("#dostupnost").html(data);

                    },
                    error: function () {}
    });
                    
/*
                    
                        var zauzetost = "";
                        $(data).find('korisnici').each(
                                function () {
                                    zauzetost = $(this).find('korisnik').text();
                                    console.log("konzola", zauzetost);
                                }
                        );
                        
                        if(zauzetost === "1"){
                            var greskaUsername = "Korisnik već postoji! Unesite drugog korisnika";
                            $("#greske").html(greskaUsername);
                            $("#poljeUsername").css("background-color","red");
                            $('#poljeUsername').focus();
                            provjeraUser = false;
                        }
                        else {
                            if(korIme.length < 6) {
                                console.log(korIme);
                                provjeraUser = false;
                                var greskaUsername1 = "Korisničko ime mora sadržavati minimalno 6 znakova";
                                $("#greske").html(greskaUsername1);
                            }
                            else {
                            provjeraUser = true;
                            console.log("Korisničko ime je slobodno!");
                            $("#poljeUsername").css("background-color","lime");
                        }
                        }
                    },
                    error: function (data) {
                        console.log("Greška u prijenostu");
                    }
                }
         );
    });*/
    
    var mailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
    $("#poljeEmail").focusout(function(event) {
       if(!$(this).val().match(mailPattern)) {
           var greskaMail = "Pogrešna forma e-mail adrese! Pokušajte ponovo";
           $("#greške").html(greskaMail);
           $("#poljeEmail").css("background-color","red");
           $("#poljeEmail").focus();
       } 
       else {
           provjeraMail = true;
           $(this).css("background-color","lime");
       }
    });
    
    var passPattern = /(?=(.*\d))(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    $("#poljePassword").focusout(function(event){
        if (!$(this).val().match(passPattern)){
            var greskaPass = "Pogrešna forma lozinke! Pokušajte ponovo";
            $("#greske").html(greskaPass);
            $("#poljePassword").css("background-color","red");
            $('#poljePassword').focus();
        }
        else {
            provjeraPass = true;
            $(this).css("background-color","lime");
        }
    });
    
    $("#poljePassword1").focusout(function(event){
        if ($(this).val() !== ($("#poljePassword").val())){
            var greskaPass1 = "Lozinke se ne podudaraju!";
            $("#greske").html(greskaPass1);
            $("#poljePassword1").css("background-color","red");
            $('#poljePassword1').focus();
        }
        else {
            provjeraPass1 = true;
            $(this).css("background-color","lime");
        }
    });
    
    $("gumbSubmit").click(function(event){
        if(provjeraPass === false){
            $("poljePassword").effect("highlight", 5000);
        }
        
        if(provjeraPass1 === false){
            $("poljePassword").effect("highlight", 5000);
        }

        if(provjeraUser === false){
            $("poljeUsername").effect("highlight", 5000);
        }
    });

    }
    
   /* $("#submit").click( function() {
             $.post( $("#formaRegistracija").attr("action"),
                     $("#formaRegistracija :input").serializeArray(),
                             function(info) {

                               $("#greske").empty();
                               $("#greske").html(info);
                             });

            $("#formaRegistracija").submit( function() {
               return false;	
            });
   */ 