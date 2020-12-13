var page_notification = 1;

var notification;

$(document).scroll(function () {

    var btn = $('#btnTop');
    var home = $('#nav_principal');

    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        btn.fadeIn("slow");
    } else {
        btn.fadeOut("slow");
    }
});

$(document).ready(function () {
    $("#rangeTamañoTexto").change(function () {
        $("body").css("font-size", $(this).val() + "em");
    });
    $("#btnTop").click(backtoTop);
    $("#cerrar").click(cerrarDivCookies);
    $("#icon_search").next().hide();
    $("#icon_search").click(desplegarBuscador);
    comprobarConexion();
    mostrarCookieBanner();
});

function desplegarBuscador() {
    console.log(1);
    console.log()
    $(this).next().fadeIn("slow");
}

function backtoTop() {
    $('body, html').animate({
        scrollTop: '0px'
    }, 1000);
}

function cerrarDivCookies() {
    var div = $("#bannerCookies");
    div.fadeOut("slow");
    aceptarCookieBanner();
}

function cambiarElementos(aux, user = "", id = "", img = "") {
    console.log(aux);
    if (aux == true) {
console.log("dgd");
        $("#logo").attr("href", "home");
        $("#logo_phone a").attr("href", "home");


        if (notification == 1) {
            var aux = '<i class="fas fa-circle ml-1" id="alert_notification"></i>';
        } else {
            var aux = '';
        }

        $('<div class="ml-3" id="button_connect">  <div class="px-0 p-0 m-0 btn btn">                    <div class=" nav-item dropdown">                        <a class="nav-link  p-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div id="img_profile" class="btn btn overflow-hidden rounded-circle"></div> </a>                        <div class="dropdown-menu py-0" aria-labelledby="navbarDropdownMenuLink">                             <a class="dropdown-item text-dark p-2 pl-3 text-left" href="profile?id=' + id + '">Profile</a>                             <a class="dropdown-item text-dark p-2 pl-3" href="upload">Upload work</a>                            <p class="dropdown-item text-danger p-2 pl-3 mb-0" id="log_out">Log Out</p>                        </div>                    </div>                </div>    <div class="px-0 p-0 m-0 btn btn ml-2" id="div_notification">                    <div class=" nav-item dropdown">                        <a class="nav-link  p-0" href="#" id="notification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bell"></i><i class="fas fa-circle ml-1" id="alert_notification"></i></a>                        <div class="dropdown-menu py-0" aria-labelledby="notification">                             <h4 class="p-3">Notification</h4>                          <ul class="ul px-3 my-2">                 </ul>                        </div>                    </div>                </div>            </div>').appendTo($("#navbarSupportedContent"));
        haveNotification();
        document.getElementById("img_profile").style.backgroundImage = "url(img/stock/" + img + ")";

        $("#log_out").click(desconectarConexion);
        $("#notification").click(loadNotifications);
    } else {
        $('<div class="ml-3" id="button_no_connect">  <a href="login"> <button class="btn btn-outline-primary" type="button">Log In</button></a>  <a href="SignUp">           <button class="btn btn-primary ml-2" type="button">Sign Up</button> </a>    </div>').appendTo($("#navbarSupportedContent"));

    }    
    $("#load").remove();
      $('html, body').css({
            'overflow': 'visible',
            'height': 'auto'
        });
}

function comprobarConexion() {
    /*
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                console.log(respuesta);
                if (respuesta[0] == "true") {
                    cambiarElementos(true,  respuesta[1], respuesta[2], respuesta[3])
                } else {
                    cambiarElementos(false)
                }
            }
        };
        xhttp.open("POST", "Actions.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=comprobarSession_AJAX");
    */
    console.log(23);
    $.ajax({
            url: "Actions.php",
            type: "POST",
            data: {
                "function": "comprobarSession_AJAX"
            }
        })
        .done(function (data) {
            var respuesta = JSON.parse(data);
            console.log(respuesta);
            if (respuesta[0] == "true") {
                cambiarElementos(true, respuesta[1], respuesta[2], respuesta[3])
            } else {
                cambiarElementos(false)
            }
        })
}

function haveNotification() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = (this.responseText);
            console.log(respuesta);
            if (respuesta == "true") {
                //$('<i class="fas fa-circle ml-1" id="alert_notification"></i>').appendTo("#notification");
                $("#alert_notification").css("color", "red");
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=haveNotification");

}

function mostrarCookieBanner() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = (this.responseText);
            console.log(respuesta);
            if (respuesta == "true") {
                $("#bannerCookies").fadeOut();
            } else {
                $("#bannerCookies").fadeIn();
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=comprobarCookieBanner");

}

function aceptarCookieBanner() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = (this.responseText);
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=crearCookie_banner");

}

function desconectarConexion() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            location.replace("index"); 
            location.reload();
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=cerrarSession_AJAX");

}

function loadNotifications() {
    console.log(23);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var notification = JSON.parse(this.responseText);
            console.log(notification);
$("#div_notification  ul").html("");
            if (notification.number_page == 0 || notification.length == 0) {
                $('<p class="text-center font-weight-light">You dont have notification.</p>').appendTo($("#div_notification  ul"));
            } else {

                for (var i = 0; i < notification[0].length; i++) {
                    var date = dates(notification[0][i]['date']);
                    $('<li class="row  p-0 m-0 mt-2 my-auto"> <div class="btn btn overflow-hidden rounded-circle p-0 m-0 img_profile_notification img_profile_notification_' + i + '">                </div>                  <p class="col-sm px-3 text-justify">' + notification[0][i]['message'] + '</p>                                <p class="col-sm-1 font-weight-light text-right px-2">' + date + '</p></li>').appendTo($("#div_notification  ul"));

                    var id = "img_profile_notification_" + i;
                    var img = notification[0][i]['image_path'];
                    document.getElementsByClassName(id)[0].style.backgroundImage = "url(img/stock/" + img + ")";
                }

                if (notification.number_page == page_notification) {
                    updateNotificationsReaded();
                }

                page_notification++;
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getNotifications&&page=" + page_notification);
}

function dates(d) {
    var date_post = new Date(d);
    var date_now = new Date();
    var date_return;
    if (date_now.getYear() == date_post.getYear()) {
        if (date_now.getMonth() == date_post.getMonth()) {
            if (date_now.getUTCDate() == date_post.getUTCDate()) {
                if (date_now.getHours() == date_post.getHours()) {
                    if (date_now.getMinutes() == date_post.getMinutes()) {
                        date_return = "0min";
                    } else {
                        date_return = (date_now.getMinutes() - date_post.getMinutes()) + "m";
                    }
                } else {
                    date_return = (date_now.getHours() - date_post.getHours()) + "h";
                }
            } else {
                date_return = (date_now.getUTCDate() - date_post.getUTCDate()) + "d";
            }
        } else {
            date_return = (date_now.getMonth() - date_post.getMonth()) + "M";
        }
    } else {
        date_return = (date_now.getYear() - date_post.getYear()) + "y";
    }

    return date_return;
}

function updateNotificationsReaded() {
    console.log(23);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var aux = (this.responseText);
            console.log(aux);

            if (aux == "true") {
                $("#alert_notification").css("color", "white");
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=updateNotificationStatus");
}


/* Like, unlike post */
/*
function like() {
    console.log(23);
    var element = $(this);
    var id = $(this).parent().next().val();

    $.ajax({
            url: "Actions.php",
            type: "POST",
            data: {
                "function": "like",
                "id": id
            }
        })
        .done(function (data) {
            var respuesta = (data);
            console.log(respuesta);
            if (respuesta == "true") {
                element.removeAttr("class");
                element.attr("class", "fas fa-heart ml-2 mr-3 liked");
                element.removeAttr("id");
                element.attr("id", "liked");
                console.log(element.prev().html());
                element.prev().html(parseInt(element.prev().html()) + 1);
               // $("#liked").click(unlike);
            }

        })

}*/

function updateLike() {
    console.log(55);
    var element = $(this);
    var id = $(this).parent().next().val();
    var aux="";
    if(element.hasClass("liked")==true){
        aux="unlike";
    }else{
        aux="like";
    }
    $.ajax({
            url: "Actions.php",
            type: "POST",
            data: {
                "function": aux,
                "id": id
            }
        })
        .done(function (data) {
            var respuesta = (data);
            console.log(respuesta);
            if (respuesta == "true") {
                if(aux=="like"){
                    element.toggleClass("like");
                    element.toggleClass("liked");
                    element.prev().html(parseInt(element.prev().html()) + 1);
                }else{
                element.toggleClass("liked");
                    element.toggleClass("like");
                    element.prev().html(parseInt(element.prev().html()) - 1);
                }
                
                 
            }

        })

}

function copyToClipboard(element) {
    event.preventDefault();
     var $temp = $("<input>");
     $("body").append($temp);
     $temp.val($(element).attr("href")).select();
     document.execCommand("copy");
     $temp.remove();
}

