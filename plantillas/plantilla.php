<!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Tupperwaring | {titulo}</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Yanone+Kaffeesatz:400,700' rel='stylesheet' type='text/css'>
        <link href='css/tupperwaring.css' rel='stylesheet' type='text/css'>
                <link href='css/inserthtml.com.radios.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/bootstrap.css" /><!-- clases de base -->
        <link rel="stylesheet" href="css/bootstrap-theme.css" /><!--añade efectos 3D a botones...-->
        <link rel="stylesheet" href="css/estilos.css" /><!--clases propias-->
        <link rel="stylesheet" href="css/registro.css" /><!--formulario de registro y login-->
        <script type="text/javascript" src="js/bootstrap.js"></script>  
        <script type="text/javascript" src="js/ValidacionFormulario.js"></script>  
         <script type="text/javascript" src="js/registro.js"></script>  
        <!-- Librería jQuery requerida por los plugins de JavaScript -->
        <script src="http://code.jquery.com/jquery.js"></script>
            <script src="js/modernizr.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script type="text/javascript">

            
        </script>
    </head>
    <body>
        <input type="hidden" id="usuario" value="24">
        <div class="popup-fondo">
            <div class="popup-wrapper">
                <div class="popup-content">
                    <div class="cerrar">x</div>
                </div>
            </div>
        </div>
        <div class="container">
            <!--head-->
            <div class="row panel-heading border morado_logo azul_logo">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><img src="img/logo.png" alt="logotipo"  class="img-responsive" > </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 line-height-header"> <h1>Tupperwaring.com</h1></div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 line-height-header"> 
                    
                    <a href="index.php?iniciaSesion"> <input type="button" class="btn-default" id="login" value="Log out" style="line-height: 200%;" onClick="logOut()"> </a>


                   <!-- <input type="button" class="btn-default" id="sign" value="Accede" style="line-height: 200%;"> --></div>
            </div>
            <!--menu-->
            <div class="row border panel-footer azul_logo2">
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3"> <a href="index.php">Inicio</a></div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3"> <a href="index.php?plato=todos">Voy a probar suerte</a></div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3"> <a href="index.php?recetas">Sube tu tupper</a></div>
             
              <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3"> <a href="index.php?hazteTupper" onClick="login()" >Perfil</a></div>
           
            </div> 
            <!--main-->
            <div class="row border panel-body">
                <!--imagen principal, rueda giratoria --> 
               
                        
        {contenido}
                                
                                       
       
   
            </div>    
            <!--footer-->
            <div class="row panel-footer border azul_logo2">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"><a href="#" class="link_footer">Copyright by Julia Bustos | Lorena Marchán | Alejandro Montoya</a></div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><a href="#" class="link_footer">Política de cookies</a></div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><a href="#" class="link_footer">Política de privacidad</a></div>

            </div>
        </div>
        


    
        <script type='text/javascript'>
            var platos = ['carne', 'arroz', 'verduras', 'entrantes', 'pucheros', 'postres', 'pasta', 'pescado'];
            var grados = ['0', '45', '90', '135', '180', '225', '270', '315'];
            var grados2 = ['-360', '-315', '-270', '-225', '-180', '-135', '-90', '-45'];
            var actual = grados[0];

            $('.elemento').hover(function () {
                var i = platos.indexOf($(this).attr('class').split(' ')[1]);
                if (actual !== grados[i] && actual !== grados2[i]) {
                    console.log('entra');
                    r1 = grados[i] - actual;
                    r2 = grados2[i] - actual;
                    var resultado = (Math.abs(r1) < Math.abs(r2)) ? grados[i] : grados2[i];
                    $('#flecha').css('transform', 'rotate(' + resultado + 'deg)');
                    actual = resultado;
                }
            });

            $('input#checkbox-8-2, input#checkbox-8-3').click(function () {
                var vegano = $('input#checkbox-8-2')[0];
                var vegetariano = $('input#checkbox-8-3')[0];
                $('div.tupper').fadeOut();
                if (vegano.checked && vegetariano.checked) {
                    $('div.tupper.vegano,div.tupper.vegetariano').fadeIn();
                }
                else {
                    if (vegano.checked) {
                        $('div.tupper.vegano').fadeIn();
                    }
                    else if (vegetariano.checked) {
                        $('div.tupper.vegetariano').fadeIn();
                    }
                    else {
                        $('div.tupper').fadeIn();
                    }
                }
            });
            var peticion_http;
            function peticion(tupper) {
                var usuario = document.getElementById('usuario').value;
                console.log(usuario);
                if (usuario !== 'undefined' && usuario !== '') {
                    peticion_http = new XMLHttpRequest();
                    peticion_http.onreadystatechange = procesaRespuesta;
                    var JSONObject = new Object();
                    JSONObject.usuario = usuario;
                    JSONObject.tupper_id = tupper.id;
                    var datos_peticion = JSON.stringify(JSONObject);
                    var parametros_json = "json=" + datos_peticion;
                    peticion_http.open("POST", 'pedirTupper.php', true);
                    peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    peticion_http.send(parametros_json);
                }
                else {
                    $('.popup-content .info').remove();
                    var hola = '<h1>¡Oops!</h1>Tienes que ser usuario para coger tuppers.';
                    hola += '<div class="logeo"><input type="button" value="Inicia sesión">';
                    hola += '<span style="float:left; padding-top:15px;">o <a href="#">Registrate</a></span></div>';
                    $('.popup-content').removeClass('mas_tupper');
                    $('.popup-content').addClass('no_logged');
                    $('.popup-content').append('<div class="error"></div>');
                    $('.popup-content .error').append(hola);
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
                    var elemento = peticion_http.responseText;
                    console.log(elemento);
                    location.reload();
                }
            }
            $('div.contenido p').click(function () {
                var hola = $(this).parent().parent()[0].innerHTML;
                $('.popup-content').addClass('mas_tupper');
                $('.popup-content').append('<div class="info"></div>');
                $('.popup-content .info').append(hola);
                $('.popup-fondo').css('display', 'table');
                $('.popup-fondo').css('opacity', '1');
            });
            $('.cerrar').click(function () {
                $('.popup-content').removeClass('mas_tupper');
                $('.popup-content .info').remove();
                $('.popup-fondo').css('display', 'none');
                $('.popup-fondo').css('opacity', '0');


            });



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
        // FORMULARIO DE REGISTRO O LOGIN SEGUN EL ENLACE QUE PULSES.
        
                 var query = jQuery(location).attr('href'); 
                 
                 if (query.indexOf("iniciaSesion") > 0){
                    
	         $("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$("#login-form-link").addClass('active');
                              
                 }
                 else if(query.indexOf("hazteTupper") > 0){
                
                $("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$("#register-form-link").addClass('active');
                 }
        
    
            };



        </script>
    </body>
</html>