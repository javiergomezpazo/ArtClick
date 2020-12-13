<?php

require_once 'Actions/InsertData.php';
require_once 'Actions/Correo.php';
require_once 'Actions/Validation.php';
require_once 'Actions/cookies.php';
require_once 'Actions/sendData.php';
require_once 'Actions/session.php';

if(isset($_POST['function'])){
    $_POST['function']();
}


  