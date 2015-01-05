<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 1:39
 */
include_once "../../../resources/constants.php";

class Login {

    private static function getDB() {
        try{
            $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die("Unable to connect with database.\n" . $e->errorInfo);
        }

        return $db;
    }

    public function userLogin(){
        $db = Login::getDB();
        $sql = $db->prepare("SELECT id, privilege FROM user WHERE email = ? AND password = ?");
        $sql->bindParam(1, $_POST["email"]);
        $sql->bindParam(2, $_POST["password"]);
        $sql->execute();

        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        if (count($results) == 0) {
            echo "false";
        }
        else {
            $_SESSION["userId"] = $results[0]->id;
            $_SESSION["userType"] = $results[0]->privilege;
            echo "true";
        }

    }
}