<?php
session_start();


include_once "../resources/constants.php";
include_once "../resources/databaseConnection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$repeatPassword = $_POST["repeatPassword"];
$email = $_POST["email"];
$name = $_POST["name"];
$lastname = $_POST["lastname"];

if( $username == "" || $password == "" || $password != $repeatPassword || $email == "") {
    header("Location: ../index.php?page=registration");
    die();
}

$sql = $db->prepare("INSERT INTO user(username, password, email, name, lastname) VALUES(?,?,?,?,?)");
$sql->bindParam(1,$username);
$sql->bindParam(2,$password);
$sql->bindParam(3,$email);
$sql->bindParam(4,$name);
$sql->bindParam(5,$lastname);

$sql->execute();

$_SESSION['username'] = $username;

header("Location: ../index.php");
