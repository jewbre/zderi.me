<?php
/**
 * Created by PhpStorm.
 * User=> Vilim Stubičan
 * Date=> 14.12.2014.
 * Time=> 2=>38
 */

include_once "../../resources/constants.php";

class Restaurant {

    public function getRestaurantsList() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("
            SELECT restaurant.id AS id, restaurant.name AS name, restaurant.description AS description,
            restaurant.address as address, restaurant.city as city, restaurant.picture as picture
            FROM restaurant
            ");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        foreach($sql as $restaurant) {
            $set = array();
            $set["id"] = $restaurant->id;
            $set["name"] = $restaurant->name;
            $set["description"] = $restaurant->description;
            $set["address"] = $restaurant->address;
            $set["city"] = $restaurant->city;
            $set["img"] = $restaurant->picture;
            $data[] = $set;
        }
        echo json_encode($data);
    }


    public function getRestaurantMenu($index) {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("
            SELECT meal.id as id, meal.name as name, meal.price as price, ingredient.name as ingredient, mealconsistsof.amount as amount, mealconsistsof.units as unit
            FROM meal
            INNER JOIN mealconsistsof
            ON meal.id = mealconsistsof.mealId
            INNER JOIN ingredient
            ON mealconsistsof.ingredientId = ingredient.id
            WHERE meal.restaurantId = ? AND meal.available = 1
            ORDER BY meal.categoryId
            ");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->bindParam(1, intval($index));
        $sql->execute();

        $data = array();
        $set["id"] = -1;
        foreach($sql as $meal) {
            if($set["id"] != $meal->id) {
                if($set["id"] > 0) {
                    $data[] = $set;
                }
                $set = array();
                $set["id"] = $meal->id;
                $set["name"] = $meal->name;
                $set["price"] = intval($meal->price);
                $set["amount"] = 1;
                $set["description"] = ($meal->ingredient)."(".($meal->amount)." ".($meal->unit).")";

            } else {
                $set["description"].=", ".($meal->ingredient)."(".($meal->amount)." ".($meal->unit).")";
            }
        }

        $data[] = $set;
        echo json_encode($data);
    }
} 