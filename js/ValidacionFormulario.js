/*
Autor=Alejandro Montoya Blanco
Fecha=05-dic-2014
Licencia=gpl30
Version=1.0
Descripcion=Archivo con todas las funciones de validaciones y campos obligatorios para el lado cliente.
*/

function validaTodos() { /*Valida todos los campos, y si son correctos los envia.*/

    if (validaDNI() === true && validaTfno() === true && validaNombreApellidos() === true && validaEmail() === true) {
        document.getElementById('form_cv').onsubmit = true;

    }
    ;


}
function validaDNI() { //valido DNI

    var valor = document.getElementById('dni').value;
    var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X',
        'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];
    if (!(/^\d{8}[A-Z]$/.test(valor)) && valor.charAt(8).toUpperCase() !== letras[(valor.substring(0, 8)) % 23]) {
         $(document).ready(function(){
  $("#mdni").toggle(function(){
    $(this).animate({height:20},200);
  });
});
     
        $('#mdni').css('display', 'block');   
        setTimeout(function () {
                $('#mdni').css('min-height', '0px');
            }, 1);
            
            setTimeout(function () {
                $('#mdni').css('height', 'auto').slideDown(4000);
            }, 10);     
        
        
      
        document.getElementById("dni").value = ""; /*Deja el Campo vacio*/
        document.getElementById("Enviar").disabled = true;/*Deshabilita el boton envio*/
        return false;
    }
    return true;
}
function validaEmail() { // valido EMAIL
    var email = document.getElementById("email").value;
    if ((/\w+([.-_]\w)*@\w+(.\w)+/.test(email))) {
        return true;
    } else {
         $('#memail').css('display', 'block');   
        setTimeout(function () {
                $('#memail').css('min-height', '0px');
            }, 1);
            
            setTimeout(function () {
                $('#memail').css('height', 'auto').slideDown(4000);
            }, 10);     
        document.getElementById("email").value = ""; /*Deja el Campo vacio*/
        document.getElementById("Enviar").disabled = true;/*Deshabilita el boton envio*/
        return false;
    }
}
function validaTfno() {    /*Valida el telefono */
    var valor = document.getElementById("telefono").value;

    if (!(/^[6,9]{1}\d{8}$/.test(valor))) {
         $('#mtelefono').css('display', 'block');   
        setTimeout(function () {
                $('#mtelefono').css('min-height', '0px');
            }, 1);
            
            setTimeout(function () {
                $('#mtelefono').css('height', 'auto').slideDown(4000);
            }, 10);     
        document.getElementById("telefono").value = ""; /*Deja el Campo vacio*/
        document.getElementById("Enviar").disabled = true;/*Deshabilita el boton envio*/
        return false;
    }

    return true;
}

function validaNombreApellidos() { //valido nombres y apellidos
    var nombre = document.getElementById('nombre').value;

    if (/[A-Za-z]+/.test(nombre) ) {
        return true;
    }
    else {
        alert("nombre o apellidos incorrectos");
        return false;
    }
}

function obligatorio() { /*Comprueba que todos los datos estan rellenos, en ese caso, habilita el boton enviar.*/
    var nombre = document.getElementById("username").value;
    var dni = document.getElementById("dni").value;
    var telefono = document.getElementById("telefono").value;
    var email = document.getElementById("email").value;
    var password= document.getElementById("password").value;


    if ((nombre === "") || (dni === "") || (telefono === "") || (email === "") || (password==="")) {
        document.getElementById("Enviar").disabled = true;  /*Deshabilita el boton envio*/
  

    }
    else
        document.getElementById("Enviar").disabled = false; /*habilita el boton envio*/
}

      /*      var peticion_http;
            var READY_STATE_COMPLETE = 4;

            function inicializa_xhr() {
                if (window.XMLHttpRequest) {
                    return new XMLHttpRequest();
                }
                else if (window.ActiveXObject) {
                    return new ActiveXObject("Microsoft.XMLHTTP");
                }
            }

      /*     
                PETICION AJAX (igual nos hace falta para tenerla de referenci)
       function valida() {
                peticion_http = inicializa_xhr();
                if (peticion_http) {
                    peticion_http.onreadystatechange = procesaRespuesta;
                    peticion_http.open("POST", "ciudades.php", true);
                    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    var orig= document.getElementById("origen").value;
                    var origen = "origen=" + encodeURIComponent(orig);
                    console.log(origen);
                    peticion_http.send(origen);/*envio el origen al servidor
                }
            } */
       /*     function procesaRespuesta() {
                /*proceso la respuesta XML
                if (peticion_http.readyState == 4) {
                    if (peticion_http.status == 200) {

            var documento_xml = peticion_http.responseXML;
            var nombres = documento_xml.getElementsByTagName("destino");
            var ciudad=documento_xml.getElementsByTagName("ciudad");
            var destino = document.getElementById('destino');
            
            if (destino.value !== null) {
                destino.disabled = false;
            }

            destino.innerHTML = "";

            for (var i = 0; i < nombres.length; i++) {
                destino.innerHTML += "<option value="+ciudad[i].firstChild.nodeValue+">" + nombres[i].firstChild.nodeValue + "</option>";
            }
        }
    }
} */
        