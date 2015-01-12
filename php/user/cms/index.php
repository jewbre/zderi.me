<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 20:32
 */
session_start();
include_once "Settings.php";
$settings = new Settings();
switch (intval($_POST["calltype"])) {

    case 1: $settings->getUserData(); break;

    case 2: $settings->saveUserData(); break;

    case 3: $settings->getReservations();break;

    case 4:
        $settings->deleteReservation();
        $settings->getReservations();
        break;
}