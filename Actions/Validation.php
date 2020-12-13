<?php

/**
 * This file contains common functions used throughout the application.
 *
 * @package    Actions
 * @author     Javier Gomez <gomez.javiergomez11@gmail.com>
 */

spl_autoload_register(function ($class) {
    include "" . $class . '.php';
});

use Clases\Bd as Bd;

