<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 14.12.2014.
 * Time: 0:14
 */
include_once "../../../resources/constants.php";


class Registration {
    private static function getDB() {
        try{
            $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die("Unable to connect with database.\n" . $e->errorInfo);
        }

        return $db;
    }

    public function register() {

        $db = Registration::getDB();
        $sql = $db->prepare("INSERT INTO user (username,password,email,name,lastName,privilege)
                              VALUES (?,?,?,?,?,?)");
        $sql->bindParam(1, $_POST["username"]);
        $sql->bindParam(2, $_POST["password"]);
        $sql->bindParam(3, $_POST["email"]);
        $sql->bindParam(4, $_POST["firstName"]);
        $sql->bindParam(5, $_POST["lastName"]);
        $sql->bindParam(6, $_POST["userType"]);
        $sql->execute();
    }

    public function checkUsernameAndEmail(){
        $db = Registration::getDB();
        $sql = $db->prepare("SELECT username,email FROM user WHERE username = ? OR email = ?");
        $sql->setFetchMode(PDO::FETCH_OBJ);

        echo "true";
    }
}