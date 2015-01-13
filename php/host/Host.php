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
        $user = $_SESSION["userId"];
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
        $user = $_SESSION["userId"];

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
                  category.id as category, category.name as categoryName, meal.available as available,
                  ingredient.id as ingredientId, ingredient.name as ingredientName,
                  mealconsistsof.units as unit, mealconsistsof.amount as amount
            FROM meal
            INNER JOIN mealconsistsof
            ON meal.id = mealconsistsof.mealId
            INNER JOIN ingredient
            ON ingredient.id = mealconsistsof.ingredientId
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
                $set["category"] = $meal->category;
                $set["categoryName"] = $meal->categoryName;
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

        $meal->category = (isset($meal->category) ? $meal->category : 0);
        $sql = $db->prepare("INSERT INTO meal(name,price,categoryId,restaurantId,available)
                              VALUES(?,?,?,?,?)");
        $sql->bindParam(1, $meal->name);
        $sql->bindParam(2, $meal->price);
        $sql->bindParam(3, intval($meal->category));
        $sql->bindParam(4, intval($_POST['restaurantId']));
        $sql->bindParam(5, $meal->available);
        $sql->execute();

        $sql = $db->prepare("SELECT meal.id as id, category.name as categoryName
                            FROM meal
                            INNER JOIN category
                            ON meal.categoryId = category.id
                            WHERE meal.name = ? AND meal.restaurantId = ? ORDER BY meal.id DESC");
        $sql->bindParam(1, $meal->name);
        $sql->bindParam(2, intval($_POST["restaurantId"]));
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        foreach($sql as $row) {
            $meal->id = $row->id;
            $meal->categoryName = $row->categoryName;
        }

        foreach($meal->normative as $norm) {
            $sql = $db->prepare("INSERT INTO mealconsistsof
                                  VALUES(?,?,?,?)");
            $sql->bindParam(1, $meal->id);
            $sql->bindParam(2, $norm->id);
            $sql->bindParam(3, $norm->unit);
            $sql->bindParam(4, $norm->amount);
            $sql->execute();
        }

        $meal->price = intval($meal->price);
        $meal->category = intval($meal->category);
        echo json_encode($meal);
    }


    public function updateMeal(){
        $meal = json_decode($_POST["obj"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $meal->category = (isset($meal->category) ? $meal->category : 0);

        $sql = $db->prepare("UPDATE meal
                            SET price = ?, categoryId = ?, available = ?
                            WHERE id = ?");
        $sql->bindParam(1, $meal->price);
        $sql->bindParam(2, $meal->category);
        $sql->bindParam(3, $meal->available);
        $sql->bindParam(4, $meal->id);
        $sql->execute();


        $sql = $db->prepare("DELETE FROM mealconsistsof WHERE mealId = ?");
        $sql->bindParam(1, $meal->id);
        $sql->execute();


        foreach($meal->normative as $norm) {
            $sql = $db->prepare("INSERT INTO mealconsistsof
                                  VALUES(?,?,?,?)");
            $sql->bindParam(1, $meal->id);
            $sql->bindParam(2, $norm->id);
            $sql->bindParam(3, $norm->unit);
            $sql->bindParam(4, $norm->amount);
            $sql->execute();
        }

    }



    public function getReservations(){
        $restaurantId = intval($_POST["restaurantId"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("
            SELECT reservation.id as id, reservation.barcode as barcode,
              reservation.timestamp as timestamp, reservation.status as status,
              reservationsseats.seatingNumber as seatingNumber, reservationsseats.amount as seatingAmount,
              reservationmenu.mealId as mealId, reservationmenu.amount as mealAmount,
              reservationmenu.price as price, meal.name as name
            FROM reservation
            INNER JOIN reservationsseats
            ON reservation.id = reservationsseats.reservationId
            LEFT JOIN reservationmenu
            ON reservation.id = reservationmenu.reservationId
            LEFT JOIN meal
            ON meal.id = reservationmenu.mealId
            WHERE reservation.restaurantId = ?
            ORDER BY timestamp desc, seatingNumber, mealId
        ");
        $sql->bindParam(1,$restaurantId);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        $set["id"] = -1;
        $meals = array();
        $seats = array();

        foreach($sql as $reservation) {
            if(intval($reservation->id) != intval($set["id"])) {
                if($set["id"]>0){
                    $set["meals"] = $meals;
                    $set["seats"] = $seats;
                    $data[] = $set;
                }

                $set = array();
                $meals = array();
                $seats = array();

                $set["id"] = intval($reservation->id);
                $set["barcode"] = $reservation->barcode;
                $set["timestamp"] = $reservation->timestamp;
                $set["status"] = $reservation->status;

                $seats[$reservation->seatingNumber]["seatingNumber"] = $reservation->seatingNumber;
                $seats[$reservation->seatingNumber]["seatingAmount"] = $reservation->seatingAmount;

                if($reservation->mealId != null){
                    $meals[$reservation->mealId]["mealId"] = $reservation->mealId;
                    $meals[$reservation->mealId]["mealAmount"] = $reservation->mealAmount;
                    $meals[$reservation->mealId]["price"] = $reservation->price;
                    $meals[$reservation->mealId]["name"] = $reservation->name;
                }
            } else {
                $seats[$reservation->seatingNumber]["seatingNumber"] = $reservation->seatingNumber;
                $seats[$reservation->seatingNumber]["seatingAmount"] = $reservation->seatingAmount;

                if($reservation->mealId != null){
                    $meals[$reservation->mealId]["mealId"] = $reservation->mealId;
                    $meals[$reservation->mealId]["mealAmount"] = $reservation->mealAmount;
                    $meals[$reservation->mealId]["price"] = $reservation->price;
                    $meals[$reservation->mealId]["name"] = $reservation->name;
                }
            }

        }

        $set["meals"] = $meals;
        $set["seats"] = $seats;
        $data[] = $set;

        echo json_encode($data);

    }


    public function getMealsForReservation(){
        $restaurantId = intval($_POST["restaurantId"]);
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);


        $sql = $db->prepare("SELECT * FROM meal WHERE restaurantId = ? AND available = 1");
        $sql->bindParam(1, $restaurantId);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        foreach($sql as $meal){
            $set = array();
            $set["id"] = $meal->id;
            $set["name"] = $meal->name;
            $set["price"] = $meal->price;
            $set["mealAmount"] = 0;
            $data[] = $set;
        }

        echo json_encode($data);

    }

    public function saveMealsForReservation(){
        $reservationId = intval($_POST["reservationId"]);
        $meals = json_decode($_POST["meals"]);

        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("INSERT INTO reservationmenu VALUES(?,?,?,?)");
        $sql->bindParam(2, $reservationId);
        foreach($meals as $meal){
            if(intval($meal->mealAmount) < 1) continue;
            $sql->bindParam(1, intval($meal->id));
            $sql->bindParam(3, intval($meal->mealAmount));
            $sql->bindParam(4, intval($meal->price));
            $sql->execute();
        }

    }

    public function changeReservationStatus(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("UPDATE reservation SET status = ? WHERE id = ?");
        $sql->bindParam(1, $_POST["status"]);
        $sql->bindParam(2, intval($_POST["reservationId"]));
        $sql->execute();

        if($_POST["status"] == "confirmed") {
            $sql = $db->prepare("
                SELECT stock.units as units, reservation.restaurantId as restaurantId, mealconsistsof.ingredientid as ingredientId, (IFNULL(stock.amount,0) - SUM(mealconsistsof.amount * reservationmenu.amount)) as total
                FROM reservation
                JOIN reservationmenu on reservation.id = reservationmenu.reservationid
                JOIN mealconsistsof on mealconsistsof.mealid = reservationmenu.mealid
                LEFT JOIN stock on stock.ingredientid = mealconsistsof.ingredientid
                WHERE reservation.id = ?
                GROUP BY mealconsistsof.ingredientid, stock.amount, reservation.restaurantid, stock.units
                UNION
                SELECT stock.units as units, stock.restaurantId as restaurantId, stock.ingredientId as ingredientId, stock.amount as total
                FROM stock
                WHERE stock.ingredientId NOT IN(
                        SELECT DISTINCT mealconsistsof.ingredientId
                        FROM reservation
                        JOIN reservationmenu on reservation.id = reservationmenu.reservationid
                        JOIN mealconsistsof on mealconsistsof.mealid = reservationmenu.mealid
                        WHERE reservation.id = ?)
            ");
            $sql->bindParam(1,$_POST["reservationId"]);
            $sql->bindParam(2,$_POST["reservationId"]);
            $sql->setFetchMode(PDO::FETCH_OBJ);
            $sql->execute();

            $stock = array();
            foreach($sql as $item){
                $set = array();
                $restaurantId = $item->restaurantId;
                $set["restaurantId"] = $item->restaurantId;
                $set["ingredientId"] = $item->ingredientId;
                $set["units"] = $item->units;
                $set["total"] = $item->total;
                $stock[] = $set;
            }

            $sql = $db->prepare("DELETE FROM stock WHERE restaurantId = ?");
            $sql->bindParam(1, $restaurantId);
            $sql->execute();

            $sql = $db->prepare("INSERT INTO stock VALUES(?,?,?,?)");
            $sql->bindParam(2,$restaurantId);
            foreach($stock as $item){
                $sql->bindParam(1,$item["ingredientId"]);
                $sql->bindParam(3,$item["units"]);
                $sql->bindParam(4,$item["total"]);
                $sql->execute();
            }
        }
    }


    public function getStock() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("
            SELECT ingredient.id as id,ingredient.name as name, IFNULL(stock.amount,0) as amount, IFNULL(stock.units,'g') as unit
            FROM ingredient
            LEFT JOIN (SELECT * FROM stock WHERE restaurantId = ?) as stock
            ON ingredient.id = stock.ingredientId
        ");
        $sql->bindParam(1, intval($_POST["restaurantId"]));
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();

        foreach($sql as $stock){
            $set = array();
            $set["id"] = intval($stock->id);
            $set["name"] = $stock->name;
            $set["amount"] = intval($stock->amount);
            $set["unit"] = $stock->unit;
            $set["changed"] = 0;
            $data[] = $set;
        }

        echo json_encode($data);

    }

    public function updateStock(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $deleteSql = $db->prepare("DELETE FROM stock WHERE ingredientId = ? AND restaurantId = ?");
        $insertSql = $db->prepare("INSERT INTO stock VALUES(?,?,?,?)");

        $deleteSql->bindParam(2, intval($_POST["restaurantId"]));
        $insertSql->bindParam(2, intval($_POST["restaurantId"]));

        $ingredients = json_decode($_POST["ingredients"]);

        foreach($ingredients as $ingredient){
            if($ingredient->changed == 0) continue;

            $deleteSql->bindParam(1, intval($ingredient->id));
            $deleteSql->execute();

            if(intval($ingredient->amount > 0)) {
                $insertSql->bindParam(1, intval($ingredient->id));
                $insertSql->bindParam(3, $ingredient->unit);
                $insertSql->bindParam(4, intval($ingredient->amount));
                $insertSql->execute();
            }
        }
    }

    public function getSuppliers() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("SELECT id,username,name,lastName FROM user WHERE privilege = 3");

        $sql->execute();

        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        $data = array();

        foreach($results as $res) {
            $set = array();
            $set["username"] = $res->username;
            $set["id"] = $res->id;
            $data[] = $set;

        }
        echo json_encode($data);

    }

    public function getSupplierIngredients() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT name, price,unit, id FROM ingredient
                            JOIN hasingredient ON hasingredient.ingredientId = ingredient.id AND supplierId = ?");

        $sql->bindParam(1, $_POST["id"]);
        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);

        $data = array();
        foreach($results as $res) {
            $set = array();
            $set["id"] = $res->id;
            $set["name"] = $res->name;
            $set["price"] = $res->price;
            $set["unit"] = $res->unit;
            $set["amount"] = 0;
            $data[] = $set;
        }
        echo json_encode($data);

    }

    public function insertOrder() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $orderItems = json_decode($_POST["ingredients"]);
        $flagOk = false;
        foreach($orderItems as $item) {
            if (intval($item->amount) > 0 ) {
                $flagOk = true;
                break;
            }
        }

        if (!$flagOk) {
            die();
        }
        $sql = $db->prepare("INSERT INTO orders (restaurantId,supplierId) VALUES (?,?)");
        $sql->bindParam(1, $_POST["restaurantId"]);
        $sql->bindParam(2, $_POST["supplierId"]);
        $sql->execute();

        $sql = $db->prepare("SELECT id FROM orders WHERE restaurantId = ? AND supplierId = ? ORDER BY id DESC LIMIT 1");
        $sql->bindParam(1, $_POST["restaurantId"]);
        $sql->bindParam(2, $_POST["supplierId"]);
        $sql->execute();
        $order = $sql->fetch(PDO::FETCH_OBJ);
        $sql = $db->prepare("INSERT INTO orderitems (ingredientId, orderId, amount, price, unit) VALUES (?,?,?,?,?)");
        $sql->bindParam(2, $order->id);

        foreach($orderItems as $item) {
            if (intval($item->amount) > 0) {
                $sql->bindParam(1, $item->id);
                $sql->bindParam(3, intval($item->amount));
                $sql->bindParam(4, $item->price);
                $sql->bindParam(5, $item->unit);
                $sql->execute();
            }
        }

    }

    public function getOrders() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
        $sql = $db->prepare("SELECT orders.id as orderId,orders.supplierId as supplierId, username as supplierName,ingredient.name as ingredientName,orderitems.amount as ingredientAmount,
                            orderitems.price as ingredientPrice, restaurant.name as restaurantName, orderitems.unit as ingredientUnit, orders.date as date, orders.status as status
                            FROM orders
                            JOIN orderitems ON orders.id = orderitems.orderId
                            JOIN ingredient ON orderitems.ingredientId = ingredient.id
                            JOIN restaurant ON restaurant.id = orders.restaurantId
                            JOIN user ON user.id = orders.supplierId
                            WHERE restaurant.host = ?
                            ORDER BY orders.id DESC");
        $sql->bindParam(1, intval($_SESSION["userId"]));
        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach($results as $result) {
            $data[$result->orderId]["orderId"] = $result->orderId;
            $data[$result->orderId]["supplierName"] = $result->supplierName;
            $data[$result->orderId]["supplierId"] = $result->supplierId;
            $data[$result->orderId]["restaurantName"] = $result->restaurantName;
            $data[$result->orderId]["date"] = $result->date;

            switch(intval($result->status)) {
                case 0: $data[$result->orderId]["status"] = "Pending"; break;
                case 1: $data[$result->orderId]["status"] = "Paid"; break;
                case 2: $data[$result->orderId]["status"] = "Canceled"; break;
            }
            $set = array();
            $set["ingredientName"] = $result->ingredientName;
            $set["ingredientAmount"] = $result->ingredientAmount;
            $set["ingredientPrice"] = $result->ingredientPrice;
            $set["ingredientUnit"] = $result->ingredientUnit;
            $data[$result->orderId]["ingredients"][] = $set;
        }
        $final = array();
        foreach($data as $key=>$value) {
            $final[] = $value;
        }
        echo json_encode($final);
    }

    public function getAllIngredients() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("SELECT id,name FROM ingredient");
        $sql->execute();

        $results = $sql->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach($results as $result) {
            $set = array();
            $set["id"] = $result->id;
            $set["name"] = $result->name;
            $data[] = $set;
        }

        echo json_encode($data);
    }

    public function getQuickSuppliers() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("SELECT username, price,unit FROM hasingredient
                            JOIN user ON supplierId = id WHERE ingredientId = ?");
        $sql->bindParam(1, $_POST["ingredientId"]);
        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);

        $data = array();

        foreach ($results as $result) {
            $set = array();
            $set["username"] = $result->username;
            $set["price"] = $result->price;
            $set["unit"] = $result->unit;
            $data[] = $set;
        }

        echo json_encode($data);
    }

    public function deleteOrder() {
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $sql = $db->prepare("DELETE FROM orders WHERE id = ?");
        $sql->bindParam(1, $_POST["orderId"]);
        $sql->execute();
    }
} 