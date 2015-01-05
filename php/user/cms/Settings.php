<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 20:33
 */
include_once "../../../resources/constants.php";

class Settings {

    private static function getDB() {
        try {
            $db = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die("Unable to connect with database.\n" . $e->errorInfo);
        }
        return $db;
    }

    public function getUserData() {
        $db = Settings::getDB();
        $sql = $db->prepare("SELECT * FROM user WHERE id = ?");
        $sql->bindParam(1, $_SESSION["userId"]);
        $sql->execute();

        $user = $sql->fetch(PDO::FETCH_OBJ);
        $set = array();
        $set["id"] = $user->id;
        $set["username"] = $user->username;
        $set["email"] = $user->email;
        $set["name"] = $user->name;
        $set["password"] = $user->password;
        $set["lastName"] = $user->lastName;
        $set["contact"] = $user->contact;
        $set["creditCard"] = $user->creditCard;
        $set["privilege"] = $user->privilege;
        echo json_encode($set);
    }

    public function saveUserData() {
        $user = $_POST["user"];
        $db = Settings::getDB();
        $sql = $db->prepare("UPDATE user SET name = ?, lastName = ?, password = ?, contact = ?, creditCard = ?
                             WHERE id = ?");

        $sql->bindParam(1, $user["name"]);
        $sql->bindParam(2, $user["lastName"]);
        $sql->bindParam(3, $user["password"]);
        $sql->bindParam(4, $user["contact"]);
        $sql->bindParam(5, $user["creditCard"]);
        $sql->bindParam(6, $user["id"]);
        $sql->execute();

    }
}