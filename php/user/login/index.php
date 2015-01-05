<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 1:56
 */
session_start();
include_once "Login.php";
$login = new Login();
$login->userLogin();
