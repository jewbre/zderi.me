<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 7.1.2015.
 * Time: 0:23
 */
include_once "../../resources/constants.php";

class Supplier {

    public function getSupplierIngredients() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT ingredient.name, hasingredient.price, hasingredient.unit, hasingredient.ingredientid
                            FROM hasingredient
                             JOIN ingredient ON ingredient.id = hasingredient.ingredientId
                             WHERE hasingredient.supplierId = ?");
        $sql->bindParam(1, $_SESSION["userId"]);
        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach($results as $ingredient) {
            $set = array();
            $set["name"] = $ingredient->name;
            $set["price"] = $ingredient->price;
            $set["unit"] = $ingredient->unit;
            $set["ingredientId"] = $ingredient->ingredientid;
            $set["fullPrice"] = $ingredient->price . " kn/" . $ingredient->unit;
            $data[] = $set;
        }
        echo json_encode($data);
    }

    public function getIngredients() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT name, id
                            FROM ingredient
                             WHERE ingredient.id NOT IN (SELECT ingredientid FROM hasingredient WHERE supplierid = ?)");
        $sql->bindParam(1, $_SESSION["userId"]);
        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach($results as $ingredient) {
            $set = array();
            $set["name"] = $ingredient->name;
            $set["id"] = $ingredient->id;
            $data[] = $set;
        }
        echo json_encode($data);
    }

    public function saveIngredient() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("INSERT INTO hasingredient (ingredientid, supplierid, price, unit) VALUES (?,?,?,?)");
        $sql->bindParam(1, $_POST["ingredientId"]);
        $sql->bindParam(2, $_SESSION["userId"]);
        $sql->bindParam(3, $_POST["price"]);
        $sql->bindParam(4, $_POST["unit"]);
        $sql->execute();

        $set=array();
        $set["ingredientId"] = $_POST["ingredientId"];
        $set["price"] = $_POST["price"];
        $set["unit"] = $_POST["unit"];
        $set["fullPrice"] = $_POST["price"] . " kn/" . $_POST["unit"];
        $set["name"] = $_POST["name"];
        echo json_encode($set);
    }


    public function deleteIngredients() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("DELETE FROM hasingredient WHERE supplierid = ? AND ingredientid = ?");
        $sql->bindParam(2, $_POST["ingredientId"]);
        $sql->bindParam(1, $_SESSION["userId"]);
        $sql->execute();

        $set=array();
        $set["id"] = $_POST["ingredientId"];
        $set["name"] = $_POST["name"];
        echo json_encode($set);
    }

    public function updateIngredients() {
        $ingredient = json_decode($_POST["ingredient"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("UPDATE hasingredient SET price = ?, unit = ? WHERE supplierid = ? AND ingredientid = ?");
        $sql->bindParam(1, $_POST["price"]);
        $sql->bindParam(2, $_POST["unit"]);
        $sql->bindParam(3, $_SESSION["userId"]);
        $sql->bindParam(4, $ingredient->ingredientId);
        $sql->execute();
    }
}