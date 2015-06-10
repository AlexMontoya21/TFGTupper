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
                    
        return false;
    }
    else{
                  $(document).ready(function(){
  $("#mdni").toggle(function(){
    $(this).animate({height:0},200);
  });
});    
      
   //     $('#mdni').css('display', 'none');   
          
    }
    return true;
}
function validaEmail() { // valido EMAIL
    var email = document.getElementById("email").value;
    if ((/\w+([.-_]\w)*@\w+(.\w)+/.test(email))) {
       $(document).ready(function(){
  $("#mdni").toggle(function(){
    $(this).animate({height:20},200);
  });
});    
        return true;
    } else {
  $(document).ready(function(){
  $("#mdni").toggle(function(){
    $(this).animate({height:0},200);
  });
});    
              
        document.getElementById("email").value = ""; /*Deja el Campo vacio*/
        
        return false;
    }
}
function validaTfno() {    /*Valida el telefono */
    var valor = document.getElementById("telefono").value;

    if (!(/^[6,9]{1}\d{8}$/.test(valor))) {
        
         $(document).ready(function(){
  $("#mtelefono").toggle(function(){
    $(this).animate({height:20},200);
  });
});    
               
        document.getElementById("telefono").value = ""; /*Deja el Campo vacio*/

        return false;
    }else {
 
        
         $(document).ready(function(){
  $("#mtelefono").toggle(function(){
    $(this).animate({height:0},200);
  });
});    
             
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

