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
                             WHERE ingredient.id NOT IN (SELECT ingredientid FROM hasingredient WHERE supplierid = ?)
                             ORDER BY name ASC");
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

    public function getOrders() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT orders.id as orderId, restaurant.id as restaurantId,restaurant.name as name, restaurant.address as address, stock.amount as oldAmount,
                            orderitems.amount as ingredientAmount, orderitems.unit as ingredientUnit, orderitems.price as ingredientPrice,
                            ingredient.name as ingredientName, orderitems.ingredientId as ingredientId, orderitems.amount*orderitems.price as totalPrice, orders.date as date, orders.status as status
                            FROM orders
                            JOIN orderitems ON orders.id = orderitems.orderId
                            JOIN restaurant ON restaurant.id = orders.restaurantId
                            JOIN ingredient ON ingredient.id = orderitems.ingredientId
                            LEFT JOIN stock ON stock.ingredientId = orderitems.ingredientId AND orders.restaurantId = stock.restaurantId
                            WHERE orders.supplierId = ? AND orders.status = 0
                            ORDER BY orders.id ASC, orderitems.ingredientId ASC");
        $sql->bindParam(1, $_SESSION["userId"]);

        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach($results as $result) {
            $data[$result->orderId]["restaurantId"] = $result->restaurantId;
            $data[$result->orderId]["orderId"] = $result->orderId;
            $data[$result->orderId]["name"] = $result->name;
            $data[$result->orderId]["address"] = $result->address;
            $data[$result->orderId]["date"] = $result->date;

            switch(intval($result->status)){
                case 0: $data[$result->orderId]["status"] = "Pending"; break;
                case 1: $data[$result->orderId]["status"] = "Paid"; break;
                case 2: $data[$result->orderId]["status"] = "Canceled"; break;
            }

            $set = array();
            $set["ingredientId"] = $result->ingredientId;
            $set["ingredientName"] = $result->ingredientName;
            $set["ingredientUnit"] = $result->ingredientUnit;
            $set["ingredientAmount"] = $result->ingredientAmount;
            $set["ingredientOldAmount"] = $result->oldAmount;
            if (isset($data[$result->orderId]["totalPrice"])) {
                $data[$result->orderId]["totalPrice"] += $result->ingredientPrice*$result->ingredientAmount;
            }
            else {
                $data[$result->orderId]["totalPrice"] = $result->ingredientPrice*$result->ingredientAmount;
            }
            $data[$result->orderId]["ingredients"][] = $set;

        }
        $final = array();
        foreach($data as $key=>$value) {
            $final[] = $value;
        }
        echo json_encode($final);

    }

    public function acceptOrder() {
        $order = json_decode($_POST["order"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("UPDATE orders SET orders.status = 1 WHERE orders.id = ?");
        $sql->bindParam(1, $order->orderId);
        $sql->execute();

        $sql1 = $db->prepare("INSERT INTO stock (ingredientId,restaurantId,units, amount) VALUES (?,?,?,?)");
        $sql1->bindParam(2, $order->restaurantId);

        $sql2 = $db->prepare("UPDATE stock SET amount = ? WHERE ingredientId = ? AND restaurantId = ?");
        $sql2->bindParam(3, $order->restaurantId);

        foreach($order->ingredients as $o) {
            if ($o->ingredientOldAmount == NULL) {
                $sql1->bindParam(1, $o->ingredientId);
                $sql1->bindParam(3, $o->ingredientUnit);
                $sql1->bindParam(4, $o->ingredientAmount);
                $sql1->execute();
            }
            else {
                $sql2->bindParam(1, intval($o->ingredientAmount + $o->ingredientOldAmount));
                $sql2->bindParam(2, $o->ingredientId);
                $sql2->execute();
            }
        }
    }

    public function declineOrder() {
        $order = json_decode($_POST["order"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("UPDATE orders SET orders.status = 2 WHERE orders.id = ?");
        $sql->bindParam(1, $order->orderId);
        $sql->execute();
    }

}