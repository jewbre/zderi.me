<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 21.10.2014.
 * Time: 21:50
 */

function isSessionActive() {
    return isset($_SESSION['userId']);
}