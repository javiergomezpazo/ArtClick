<?php

function comprobarCookieBanner(){
    if(isset($_COOKIE['cookie_banner'])){
       echo "true";
    }else{
        echo "false";
    }
}
function crearCookie_banner(){
    if(!isset($_COOKIE['cookie_banner'])){
        setcookie('cookie_banner', 'ok', time()+(60*60*24*360));
    }
}