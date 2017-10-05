
var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject()
{
    var xmlHttp;
    try {
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        var XmlHttpVersions = new Array('MSXML2.XmlHttp', 'Microsoft.XmlHttp');
        for (var i = 0; i < XmlHttpVersions.length && !xmlHttp; i++) {
            try {
                xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
            }
            catch (e) {
            }
        }
    }
    if (!xmlHttp)
        alert("Problem kod kreiranja XMLHttpRequest objekta.");
    else
        return xmlHttp;
}

function dajPodatke()
{
    if (xmlHttp) {
        try {
            if (xmlHttp.readyState === 4 || xmlHttp.readyState === 0) {
                xmlHttp.open("GET", "../XML/o_autoru.xml", true);
                xmlHttp.onreadystatechange = preuzmiPodatke;
                xmlHttp.send(null);
            } else {  // ako je XMLHttpRequest objekt zauzet...
            }
        } catch (e) {
            alert("Problem kod povezivanja na server:\n" + e.toString());
        }
    }
}

function preuzmiPodatke()
{
    if (xmlHttp.readyState === 4) {
        if (xmlHttp.status === 200) { // samo ako je HTTP status "OK"
            try {
               // alert("Stizu podaci");
                prikaziPodatke();
            } catch (e)
            {
                alert(e.toString());
            }
        } else {
            alert("Problem kod preuzimanja podataka:\n" + xmlHttp.statusText);
        }
    }
}

function prikaziPodatke()
{
    var response = xmlHttp.responseText;

    if (response.indexOf("ERRNO") >= 0
            || response.indexOf("error") >= 0
            || response.length === 0);
       // throw(response.length === 0 ? "Prazan odgovor servera." : response);

    response = xmlHttp.responseXML.documentElement;

    var nameArray = new Array();
    nameArray[0] = pripremiPodatke(response.getElementsByTagName("ime"));
    nameArray[1] = pripremiPodatke(response.getElementsByTagName("prezime"));
    nameArray[2] = pripremiPodatke(response.getElementsByTagName("smjer"));
    nameArray[3] = pripremiPodatke(response.getElementsByTagName("datum_rod"));
    nameArray[4] = pripremiPodatke(response.getElementsByTagName("indeks"));
    nameArray[5] = pripremiPodatke(response.getElementsByTagName("mail"));


    var inHTML = '';

    inHTML += ' <br/>' + nameArray[0] + " <br/>" + nameArray[1] + ' <br/>' + 
                nameArray[2] + " <br/> " + nameArray[3] + ' <br/>'+ nameArray[4] + ' <br/>'+' <br/>'+ nameArray[5] + ' <br/>';

    //inHTML += '</select>';
    var oSuggest = document.getElementById("cilj");
    oSuggest.innerHTML = inHTML;
}

function pripremiPodatke(resultsXml)
{
    var resultsArray = new Array();
    for (i = 0; i < resultsXml.length; i++) {
        var $smjer = resultsXml.item(i).firstChild.data;
        var $podaci = new Array( $smjer);
        resultsArray[i] = $podaci;
    }
    return resultsArray;
}