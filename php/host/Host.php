<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 0:23
 */

include_once "../../resources/constants.php";

class Host {

    public function addNewRestaurant() {
        $newRestaurant = json_decode($_POST["obj"]);
        $user = 1;
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("INSERT INTO restaurant(name,description,contact,address,city,host,picture)
                            VALUES(?,?,?,?,?,?,?)");
        $sql->bindParam(1, $newRestaurant->name);
        $sql->bindParam(2, $newRestaurant->description);
        $sql->bindParam(3, $newRestaurant->contact);
        $sql->bindParam(4, $newRestaurant->address);
        $sql->bindParam(5, $newRestaurant->city);
        $sql->bindParam(6, $user);
        $sql->bindParam(7, $newRestaurant->picture);
        $sql->execute();


        $sql = $db->prepare("SELECT * FROM restaurant WHERE name = ? AND host = ? ORDER BY id DESC");
        $sql->bindParam(1, $newRestaurant->name);
        $sql->bindParam(2, $user);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();
        $newRestaurant->id = $sql->fetch()->id;


        foreach($newRestaurant->seatingPlaces as $key => $value) {
            $sql = $db->prepare("INSERT INTO capacity VALUES(?,?,?)");
            $sql->bindParam(1, $newRestaurant->id);
            $sql->bindParam(2, intval($key));
            $sql->bindParam(3, intval($value));
            $sql->execute();
        }

        echo json_encode($newRestaurant);

    }



    public function getRestaurants(){
        $user = 1;

        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT restaurant.id as id, restaurant.name as name, restaurant.description as description,
                            restaurant.contact as contact, restaurant.address as address, restaurant.city as city, restaurant.picture as picture,
                            capacity.seatingNumber as seatingNumber, capacity.amount as amount
                            FROM restaurant
                            INNER JOIN capacity
                            ON restaurant.id = capacity.restaurantId
                            WHERE restaurant.host = ?");
        $sql->bindParam(1,$user);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        $set["id"] =-1;
        foreach($sql as $restaurant) {
            if(intval($restaurant->id) != $set["id"]) {
                if($set["id"]>0) {
                    $data[] = $set;
                }
                $set = array();
                $set["id"] = $restaurant->id;
                $set["name"] = $restaurant->name;
                $set["description"] = $restaurant->description;
                $set["contact"] = $restaurant->contact;
                $set["address"] = $restaurant->address;
                $set["city"] = $restaurant->city;
                $set["picture"] = $restaurant->picture;
                $set["seatingPlaces"][strval($restaurant->seatingNumber)] = $restaurant->amount;
            } else {
                $set["seatingPlaces"][strval($restaurant->seatingNumber)] = $restaurant->amount;
            }
        }

        if($set["id"] > 0) {
            $data[] = $set;
        }

        echo json_encode($data);
    }


    public function editRestaurant() {
        $newRestaurant = json_decode($_POST["obj"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("UPDATE restaurant
                            SET description = ?, contact = ?, address = ?, city = ?, picture = ?
                            WHERE id = ?");
        $sql->bindParam(1, $newRestaurant->description);
        $sql->bindParam(2, $newRestaurant->contact);
        $sql->bindParam(3, $newRestaurant->address);
        $sql->bindParam(4, $newRestaurant->city);
        $sql->bindParam(5, $newRestaurant->picture);
        $sql->bindParam(6, $newRestaurant->id);
        $sql->execute();

        $sql = $db->prepare("DELETE FROM capacity WHERE restaurantId = ?");
        $sql->bindParam(1, $newRestaurant->id);
        $sql->execute();


        foreach($newRestaurant->seatingPlaces as $key => $value) {
            $sql = $db->prepare("INSERT INTO capacity VALUES(?,?,?)");
            $sql->bindParam(1, $newRestaurant->id);
            $sql->bindParam(2, intval($key));
            $sql->bindParam(3, intval($value));
            $sql->execute();
        }
    }

    public function deleteRestaurant() {
        $id = $_POST["id"];
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("DELETE FROM restaurant WHERE id = ?");
        $sql->bindParam(1, $id);
        $sql->execute();
    }


    public function getMeals(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("
            SELECT meal.id as id, meal.name as name, meal.price as price,
                  category.id as category, meal.available as available,
                  ingredient.id as ingredientId, ingredient.name as ingredientName,
                  mealConsistsOf.units as unit, mealConsistsOf.amount as amount
            FROM meal
            INNER JOIN mealConsistsOf
            ON meal.id = mealConsistsOf.mealId
            INNER JOIN ingredient
            ON ingredient.id = mealConsistsOf.ingredientId
            LEFT JOIN category
            ON meal.categoryId = category.id
            WHERE meal.restaurantId = ?
        ");
        $sql->bindParam(1, $_POST["restaurantId"]);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        $set["id"] = -1;

        foreach($sql as $meal) {
            if($meal->id != intval($set["id"])) {
                if($set["id"]>0){
                    $data[] = $set;
                }

                $set = array();
                $set["id"] = intval($meal->id);
                $set["name"] = $meal->name;
                $set["price"] = intval($meal->price);
                $set["category"] = intval($meal->category);
                $set["available"] = $meal->available;
                $set["normative"][$meal->ingredientName]["id"] = $meal->ingredientId;
                $set["normative"][$meal->ingredientName]["amount"] = $meal->amount;
                $set["normative"][$meal->ingredientName]["unit"] = $meal->unit;
            } else {
                $set["normative"][$meal->ingredientName]["id"] = $meal->ingredientId;
                $set["normative"][$meal->ingredientName]["amount"] = $meal->amount;
                $set["normative"][$meal->ingredientName]["unit"] = $meal->unit;
            }
        }

        if($set["id"] > 0) {
            $data[] = $set;
        }

        echo json_encode($data);
    }

    public function saveNewMeal(){
        $meal = json_decode($_POST["obj"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $meal->category = (isset($meal->category)? $meal->category->id : "");
        $sql = $db->prepare("INSERT INTO meal(name,price,categoryId,restaurantId,available)
                              VALUES(?,?,?,?,?)");
        $sql->bindParam(1, $meal->name);
        $sql->bindParam(2, $meal->price);
        $sql->bindParam(3, $meal->category);
        $sql->bindParam(4, intval($_POST['restaurantId']));
        $sql->bindParam(5, $meal->available);
        $sql->execute();

        $sql = $db->prepare("SELECT * FROM meal WHERE name = ? ORDER BY id DESC");
        $sql->bindParam(1, $meal->name);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();
        $meal->id = $sql->fetch()->id;

        foreach($meal->normative as $norm) {
            $sql = $db->prepare("INSERT INTO mealConsistsOf
                                  VALUES(?,?,?,?)");
            $sql->bindParam(1, $meal->id);
            $sql->bindParam(2, $norm->id);
            $sql->bindParam(3, $norm->unit);
            $sql->bindParam(4, $norm->amount);
            $sql->execute();
        }

        echo json_encode($meal);
    }


    public function updateMeal(){
        $meal = json_decode($_POST["obj"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("UPDATE meal
                            SET price = ?, categoryId = ?, available = ?
                            WHERE id = ?");
        $sql->bindParam(1, $meal->price);
        $sql->bindParam(2, $meal->category);
        $sql->bindParam(3, $meal->available);
        $sql->bindParam(4, $meal->id);
        $sql->execute();


        $sql = $db->prepare("DELETE FROM mealConsistsOf WHERE mealId = ?");
        $sql->bindParam(1, $meal->id);
        $sql->execute();


        foreach($meal->normative as $norm) {
            $sql = $db->prepare("INSERT INTO mealConsistsOf
                                  VALUES(?,?,?,?)");
            $sql->bindParam(1, $meal->id);
            $sql->bindParam(2, $norm->id);
            $sql->bindParam(3, $norm->unit);
            $sql->bindParam(4, $norm->amount);
            $sql->execute();
        }

    }
} 