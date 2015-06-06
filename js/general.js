//var platos = ['carne', 'arroz', 'verduras', 'entrantes', 'pucheros', 'postres', 'pasta', 'pescado'];
//var grados = ['0', '45', '90', '135', '180', '225', '270', '315'];
//var grados2 = ['-360', '-315', '-270', '-225', '-180', '-135', '-90', '-45'];
//var actual = grados[0];
//
//$('.elemento').hover(function () {
//    var i = platos.indexOf($(this).attr('class').split(' ')[1]);
//    if (actual !== grados[i] && actual !== grados2[i]) {
//        r1 = grados[i] - actual;
//        r2 = grados2[i] - actual;
//        var resultado = (Math.abs(r1) < Math.abs(r2)) ? grados[i] : grados2[i];
//        $('#flecha').css('transform', 'rotate(' + resultado + 'deg)');
//        actual = resultado;
//    }
//});


var peticion_http;
function peticion(tupper) {
    var usuario = document.getElementById('usuario').value;
    var info = tupper.parentNode.getElementsByClassName('datos_tupper');
    var usuario_tupper = info[0].id;
    var id_tupper = info[0].value;
    if (usuario !== 'undefined' && usuario !== '' && usuario != usuario_tupper) {
        peticion_http = new XMLHttpRequest();
        peticion_http.onreadystatechange = procesaRespuesta_tupper;
        var JSONObject = new Object();
        JSONObject.usuario = usuario;
        JSONObject.tupper_id = id_tupper;
        var datos_peticion = JSON.stringify(JSONObject);
        var parametros_json = "json=" + datos_peticion;
        peticion_http.open("POST", 'pedirTupper.php', true);
        peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        peticion_http.send(parametros_json);
    }
    else {
        var contenido = '<h1>¡Oops!</h1>';
        if (usuario == usuario_tupper) {
            contenido += 'No puedes pedir tu propio tupper<br><br>';
        }
        else {
            contenido += 'Tienes que ser usuario para coger tuppers';
            contenido += '<div class="logeo"><input type="button" value="Inicia sesión">';
            contenido += '<span style="float:left; padding-top:15px;">o <a href="index.php?hazteTupper">Registrate</a></span></div>';
        }
        $('.popup-content .info').remove();
        $('.popup-content').removeClass('mas_tupper');
        $('.popup-content').addClass('no_logged');
        $('.popup-content').append('<div class="error"></div>');
        $('.popup-content .error').append(contenido);
        $('.popup-fondo').css('display', 'table');
        $('.popup-fondo').css('opacity', '1');
        $('.cerrar').click(function () {
            $('.popup-content').removeClass('no_logged');
            $('.popup-content .error').remove();
            $('.popup-fondo').css('display', 'none');
            $('.popup-fondo').css('opacity', '0');
        });
    }
}

function procesaRespuesta() {
    if (peticion_http.readyState === 4 && peticion_http.status === 200) {
        location.reload();

    }
}
function procesaRespuesta_tupper() {
    if (peticion_http.readyState === 4) {
        $('.popup-fondo').css('opacity', '0');
        var contenido
        if (peticion_http.status === 200) {
            contenido = '<div class="exito"> <b>¡Petición realizada con éxito!</b> Se mandó una notificación al propietario del tupper.</div>';
        }
        else {
            contenido = '<div class="exito" style="color:red;"> <b>¡Lo siento!</b> No se pudo realizar la peticion. Intentalo mas tarde.</div>';
        }
        $('.titulo').before(contenido);
        $('html, body').stop().animate({scrollTop: $('body').offset().top}, 500, 'swing', function () {
            $('.exito').css('height', '25px');
            setTimeout(function () {
                $('.exito').css('height', '0px');
            }, 3000);
            setTimeout(function () {
                location.reload();
            }, 3550);
        });
    }
}




window.onload = function () {
    var Modernizr = window.Modernizr;
    if (Modernizr.csstransforms3d) {
        var head = document.querySelector('head');
        head.innerHTML = head.innerHTML + '<link rel="stylesheet" href="inserthtml.com.radios.min.css" />';
    }
    else {
        document.querySelector('.container').innerHTML = '<h1>Hey! Your browser doesn\'t support many of these custom checkboxes.</h1>' +
                '<p>So here is a type your browser does support:</p>' +
                '<div class="holder">' +
                '<div class="center" style="width: 186px;">' +
                '<input type="checkbox" id="checkbox-1-1" /><label for="checkbox-1-1"></label>' +
                '<input type="checkbox" id="checkbox-1-2" checked /><label for="checkbox-1-2"></label>' +
                '<input type="checkbox" id="checkbox-1-3" /><label for="checkbox-1-3"></label>' +
                '</div>' +
                '</div>';
    }
};

function gestion(boton, id_tupper, id_mensaje) {
    peticion_http = new XMLHttpRequest();
    peticion_http.onreadystatechange = procesaRespuesta;
    var JSONObject = new Object();
    JSONObject.opcion = boton.value;
    JSONObject.id_tupper = id_tupper;
    JSONObject.id_mensaje = id_mensaje;
    var datos_peticion = JSON.stringify(JSONObject);
    var parametros_json = "json=" + datos_peticion;
    peticion_http.open("POST", 'controlNotificaciones.php', true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send(parametros_json);
}

function info(tipo_id, id) {
    peticion_http = new XMLHttpRequest();
    peticion_http.onreadystatechange = popup;
    var JSONObject = new Object();
    JSONObject.id = id;
    JSONObject.tipo_id = tipo_id;
    var datos_peticion = JSON.stringify(JSONObject);
    var parametros_json = "json=" + datos_peticion;
    peticion_http.open("POST", 'mas_info.php', true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send(parametros_json);
    console.log('todo');


}
function popup() {
    if (peticion_http.readyState == 4) {
        if (peticion_http.status == 200) {
            var respuesta_json = peticion_http.responseText;
            var resultado = eval("(" + respuesta_json + ")");
            $('.popup-content').append('<div class="info"></div>');
            var contenido;
            if (resultado.tipo_id == 'id_tupper') {
                contenido = "<div class='foto'><img src='img/platos/" + resultado.info.foto + "'><p> en " + resultado.info.tipo + "</p></div>";
                contenido += "<h3>" + resultado.info.nombre + "</h3><div class='gestion'>";
                contenido += (resultado.info.vegano == 1) ? "<div class='vegano'><span class='glyphicon glyphicon-leaf'></span> vegano</div>" : "";
                contenido += (resultado.info.vegetariano == 1) ? "<div class='vegetariano'><span class='glyphicon glyphicon-leaf'></span> vegetariano</div>" : "";
                contenido += (resultado.info.sin_gluten == 1) ? "<div class='sin_gluten'><span class='glyphicon glyphicon-grain'></span> sin gluten</div>" : "";
                contenido += "</div><div class='descripcion'>" + resultado.info.descripcion + "</div>";
                $('.popup-content').css('width', '600px');
                $('.popup-content').css('height', 'auto');

            }
            else if (resultado.tipo_id == 'id_usuario') {
                contenido = '<div class="popup_usuario">';
                contenido += '<div style="float:left;height: 1px;width:110px;padding-left: 3px;">';
                contenido += '<div class="foto_usuario" style="background-image: url(\'img/platos/' + resultado.info.foto + '\')">';
                contenido += '<div class="gorro"></div></div></div><div class="info_usuario">';
                contenido += '<h1>' + resultado.info.nombre + ' ' + resultado.info.apellidos + '</h1>';
                contenido += '<h3>' + resultado.info.email + '</h3><p>' + resultado.info.poblacion + '</p><p>' + resultado.info.edad + ' años</p></div>';
                contenido += '</div>';
                $('.popup-content').css('width', '450px');
                $('.popup-content').css('height', '230px');
            }


            $('.popup-content .info').append(contenido);
            $('.popup-fondo').css('display', 'table');
            $('.popup-fondo').css('opacity', '1');
        }
    }
}
window.onload = function () {
    var usuario = document.getElementById('usuario').value;
    if (usuario != '') {
        notificaciones();
        setInterval("notificaciones()", 30000);
    }
}
function notificaciones() {
    var usuario = document.getElementById('usuario').value;
    peticion_http = new XMLHttpRequest();
    peticion_http.onreadystatechange = function () {
        if (peticion_http.readyState == 4) {
            if (peticion_http.status == 200) {
                var respuesta_json = peticion_http.responseText;
                var resultado = eval("(" + respuesta_json + ")");
                if (resultado.notificaciones > 0) {
                    document.getElementById('n').innerHTML = resultado.notificaciones;
                    $('#n').css('display', 'inline-block');
                }
                else {
                    $('#n').css('display', 'none');
                }
            }
        }
    };
    var JSONObject = new Object();
    JSONObject.id = usuario;
    var datos_peticion = JSON.stringify(JSONObject);
    var parametros_json = "json=" + datos_peticion;
    peticion_http.open("POST", 'notificaciones.php', true);
    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion_http.send(parametros_json);
}

function subir_tupper1() {
    var advertencia = "Hay algunas cosas que tienes que revisar...";
    var nombre = $('input#nombre_tupper')[0].value;
    var foto = $('input#foto_tupper')[0].value;
    var tipo = $('select#tipo_tupper')[0].value;
    var extension = foto.substr(foto.lastIndexOf('.'));
    if (nombre != '' && (nombre.length <= 30) && foto != '' && tipo != 'tipo' && (extension == '.jpg' || extension == '.jpeg' || extension == '.png')) {
        return true;
    }
    else {
        if (nombre == '') {
            advertencia += "<br>-El nombre no puede estar vacio";
        }
        if (nombre.length > 30) {
            advertencia += "<br>-El nombre no puede tener mas de 30 caracteres";
        }
        if (foto == '') {
            advertencia += "<br>-Tienes que subir una foto";
        }
        if (extension != '.jpg' && extension != '.jpeg' && extension != '.png') {
            advertencia += "<br>-La foto tiene que tener una extension .jpg, .jpeg o .png";
        }
        if (tipo == 'tipo') {
            advertencia += "<br>-Tienes que seleccionar que tipo de plato es";
        }
        $('.advertencia').empty();
        $('.advertencia').html(advertencia);
        return false;
    }
}

$('document').ready(function () {
    if ($('.mensaje')[0].innerHTML != '') {
        $('.mensaje').css('height','45px');
        setTimeout(function () {
        $('.mensaje').css('height','0px');
        }, 5000);
        
        setTimeout(function () {
            location.href = 'index.php?hazteTupper';
        }, 6000);
    }

});

        