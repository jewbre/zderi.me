<?php
/**
 * Created by PhpStorm.
 * User: OJ
 * Date: 22-Oct-14
 * Time: 5:15 PM
 */
session_start();//notyet nothere?


include_once "../resources/constants.php";
include_once "../resources/databaseConnection.php";

$username = $_POST["username"];
$password = $_POST["password"];


if( $username == "" || $password == "") {
    header("Location: ../index.php?page=login");
    die();
}
/*
$db->query("SELECT FROM user(username, password) WHERE username = ? AND password = ?");

$sql->bindParam(1,$username);
$sql->bindParam(2,$password);

$sql->execute();

//if(ono sto vraca query == 1) onda ovo ispod
*/

    $sql = $db->prepare("SELECT password FROM user WHERE username = ?");
    $sql->bindParam(1, $username);
    $sql->setFetchMode(PDO::FETCH_OBJ);
    $sql->execute();

    $row = $sql->fetch();

if($row->password == $password) {
    $_SESSION['username'] = $username;
} else {
    header("Location: ../index.php?page=login");
}

header("Location: ../index.php");
