<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 14.12.2014.
 * Time: 0:13
 */
session_start();
include_once "Registration.php";
$registration = new Registration();
switch(intval($_POST["calltype"])) {
    case 1: $registration->checkUsernameAndEmail(); break;
    case 2: $registration->register(); break;
}
