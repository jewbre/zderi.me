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
} 