<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 12:41
 */

include_once "../../resources/constants.php";

class Admin {

    function getUsers(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT * FROM user");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();


        $data = array();
        foreach($sql as $user) {
            $set = array();
            $set["id"] = $user->id;
            $set["username"] = $user->username;
            $set["email"] = $user->email;
            $set["name"] = $user->name;
            $set["lastName"] = $user->lastName;
            $set["contact"] = $user->contact;
            $set["creditCard"] = $user->creditCard;
            $set["privilege"] = $user->privilege;

            $data[] = $set;
        }

        echo json_encode($data);

    }

    function updateUser(){
        $user = json_decode($_POST["obj"]);
        $user->name = isset($user->name)? $user->name : "";
        $user->lastName = isset($user->lastName)? $user->lastName : "";
        $user->contact = isset($user->contact)? $user->contact : "";
        $user->creditCard = isset($user->creditCard)? $user->creditCard : "";


        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("
            UPDATE user
            SET name = ?, lastName = ?, contact = ?, creditCard = ?, privilege = ?
            WHERE id = ?
            ");

        $sql->bindParam(1, $user->name);
        $sql->bindParam(2, $user->lastName);
        $sql->bindParam(3, $user->contact);
        $sql->bindParam(4, $user->creditCard);
        $sql->bindParam(5, $user->privilege);
        $sql->bindParam(6, $user->id);
        $sql->execute();

        if(isset($user->password)){
            $sql = $db->prepare("
            UPDATE user
            SET password = ?
            WHERE id = ?
            ");

            $sql->bindParam(1, $user->password);
            $sql->bindParam(2, $user->id);
            $sql->execute();
        }


    }

    public function getIngredients(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("SELECT * FROM ingredient");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        foreach($sql as $ingredient) {
            $set = array();
            $set["id"] = $ingredient->id;
            $set["name"] = $ingredient->name;

            $data[] = $set;
        }

        echo json_encode($data);
    }

    public function addNewIngredient(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("INSERT INTO ingredient(name) VALUES(?)");
        $sql->bindParam(1, $_POST["name"]);
        $sql->execute();
    }

    public function deleteIngredient(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("DELETE FROM ingredient WHERE id = ?");
        $sql->bindParam(1, $_POST["id"]);
        $sql->execute();
    }

    public function getCategories(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("SELECT * FROM category WHERE id != 0");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        foreach($sql as $category) {
            $set = array();
            $set["id"] = $category->id;
            $set["name"] = $category->name;

            $data[] = $set;
        }

        echo json_encode($data);
    }

    public function addCategory(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("INSERT INTO category(name) VALUES(?)");
        $sql->bindParam(1, $_POST["name"]);
        $sql->execute();
    }

    public function deleteCategory(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("DELETE FROM category WHERE id = ?");
        $sql->bindParam(1, $_POST["id"]);
        $sql->execute();
    }
} 