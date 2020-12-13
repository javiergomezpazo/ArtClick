<?php

/**
 * This file contains common functions used throughout the application.
 *
 * @package    Actions
 * @author     Javier Gomez <gomez.javiergomez11@gmail.com>
 */

/**
 * Verify if user is connected
 *
 * @return boolean Return true or false
 */
function comprobarSession() {
    session_start();
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        session_abort();
        return false;
    }
}
/**
 * Verify if user is connected
 *
 * Return true if user is connected, else return false
 */
function comprobarSession_AJAX() {
    session_start();
    $array=[];
    if (isset($_SESSION['user'])) {
        array_push($array,"true",$_SESSION['user']['userName'], $_SESSION['user']['id'], $_SESSION['user']['profile_photo']);
       
    } else {
        array_push($array,"false");
    }
     echo json_encode($array);
}

/**
 * Session destroy
 */
function cerrarSession_AJAX() {
    session_start();
    $_SESSION = array();
    session_destroy(); // eliminar la sesion
    setcookie(session_name(), 123, time() - 1000);
}
