
$(document).ready(function () {
    /* loadPaises();
     loadTipos();
     loadEspecialidad();*/
    console.log("2");
    $("form").submit(function () {
        event.preventDefault();
    });
    $("#formnUp").submit(comprobarUsuario);
     
     $("#formSignUp").submit(sendData);
});

function loadPaises() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var paises = JSON.parse(this.responseText);
            var select_socio = $("select[name='pais_socio']");
            var select_institucion = $("select[name='pais_institucion']");
            for (var i = 0; i < paises.length; i++) {
                var option_socio = $("<option value='" + paises[i].id_pais + "'>" + paises[i].nombre + "</option>");
                option_socio.appendTo(select_socio);

                var option_institucion = $("<option value='" + paises[i].id_pais + "'>" + paises[i].nombre + "</option>");
                option_institucion.appendTo(select_institucion);
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getPaises");

}

function loadTipos() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var tipos = JSON.parse(this.responseText);
            var select = $("select[name='tipo_institucion']");
            for (var i = 0; i < tipos.length; i++) {
                var option = $("<option value='" + tipos[i].ID_TIPO_INSTITUCION + "'>" + tipos[i].tipo + "</option>");
                option.appendTo(select);
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getTipo_Institucion");

}

function loadEspecialidad() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var tipos = JSON.parse(this.responseText);
            var select = $("select[name='especialidad_institucion']");
            for (var i = 0; i < tipos.length; i++) {
                var option = $("<option value='" + tipos[i].id_especialidad + "'>" + tipos[i].tipo + "</option>");
                option.appendTo(select);
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getEspecialidad");

}

function comprobarUsuario() {
    event.preventDefault();
    $("#mensaje_error").remove();
    var user_socio = $("input[name='usuario_socio']").val();
    var email_socio = $("input[name='email_socio']").val();
    var vat_socio = $("input[name='vat_socio']").val();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText === "true") {
                $("#formSocio").css("display", "none");
                $("#formInstitucion").css("display", "block");
                var li_institucion = $("#formulario_container li .active").parent().next().children();
                var li_empresa = $("#formulario_container li .active");
                li_empresa.removeClass("active");
                li_institucion.addClass("active");
            } else {
                $('<div class="p-4 bg-danger text-center my-auto mt-2 mb-4" id="mensaje_error">                            <p class="m-0 text-white">El usuario, o email que ha introducido ya fue introducidoa. Vuelva a ingresar los datos.</p>                        </div>').insertBefore($("#continue"));
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=comprobarDatosUsuario" + "&&usuario_socio=" + user_socio + "&&email_socio=" + email_socio + "&&vat_socio=" + vat_socio);
}

function sendData() {
    console.log(23);
    $("#mensaje_error").remove();
    var name = $("input[name='name']").val();
    var email = $("input[name='email']").val();
    var user_name = $("input[name='user_name']").val();
    var password = $("input[name='password']").val();
    var location = $("input[name='location']").val();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = this.responseText;
            console.log(respuesta.toString());
            if (respuesta == "true") {
                console.log(45);
                $("#formSignUp").fadeOut();
                $('<div id="accion_realizada" class="p-4" text-center my-auto my-4>                    <p class="m-0">Se ha registrado con exito en nuestra web. Acaba de recibir un email de bienvenida. Gracias por registrarse en ArtClick.</p>                    <p>Acceda en <a href="login.php">Login</a> para conectarse.</p>                </div>').appendTo($("section"));
            } else {
                console.log(5);
                $('<div class="p-4 bg-danger text-center my-auto mt-2 mb-4" id="mensaje_error">                            <p class="m-0 text-white">El usuario, email o vat que ha introducido ya fue introducidoa. Vuelva a ingresar los datos.</p>                        </div>').insertBefore($("#send"));
            }

        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=signUp" + "&&name=" + name + "&&email=" + email + "&&user_name=" + user_name + "&&password=" + password + "&&location=" + location);
}