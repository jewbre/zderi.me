<?php

    switch((int) $_POST["callAction"]) {
        case 1: validateUsername($_POST['username']); break;
        case 2: validateEmail($_POST['email']); break;
    }


function validateUsername($username) {
    include_once "../resources/constants.php";
    include_once "../resources/databaseConnection.php";

    $sql = $db->prepare("SELECT COUNT(*) as amount FROM user WHERE username = ?");
    $sql->setFetchMode(PDO::FETCH_OBJ);
    $sql->bindParam(1, $username);

    $sql->execute();

    $row = $sql->fetch();

    if($row->amount == 0) echo "ok";
        else echo "notOk";

}

function validateEmail($email) {
    include_once "../resources/constants.php";
    include_once "../resources/databaseConnection.php";

    $sql = $db->prepare("SELECT COUNT(*) as amount FROM user WHERE email = ?");
    $sql->setFetchMode(PDO::FETCH_OBJ);
    $sql->bindParam(1, $email);

    $sql->execute();

    $row = $sql->fetch();

    if($row->amount == 0) echo "ok";
    else echo "notOk";

}