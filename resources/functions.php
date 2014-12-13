<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 21.10.2014.
 * Time: 21:50
 */

function isSessionActive() {
    if(isset($_SESSION['username'])) {
        if($_SESSION["username"] != "guest") {
            return true;
        } else {
            return false;
        }
    } else {
        $_SESSION['username'] = "guest";
        return false;
    }
}