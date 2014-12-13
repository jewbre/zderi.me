<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 9.11.2014.
 * Time: 17:03
 */

$user = $_POST["username"];
$pass = $_POST["password"];

$data = array();
    if($user == "jewbre" && $pass=="pass123") {
        $data["success"] = "true";
    } else {
        $data["success"] = "false";
    }

echo json_encode($data);