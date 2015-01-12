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

    public function getReservations() {
        $db = Settings::getDB();
        $sql = $db->prepare("SELECT reservation.id as reservationId, restaurant.name as restaurantName, reservation.timestamp as time,
                            meal.name as mealName, reservationmenu.amount as mealAmount, reservationmenu.price as mealPrice,
                            (SELECT SUM(seatingNumber*amount) as numberOfSeats FROM reservationsseats WHERE reservationId = reservation.id GROUP BY reservationId) as numberOfSeats
                            FROM reservation
                            LEFT JOIN reservationmenu ON reservation.id = reservationmenu.reservationId
                            LEFT JOIN meal ON reservationmenu.mealId = meal.id
                            JOIN restaurant ON restaurant.id = reservation.restaurantId
                            WHERE reservation.userId = ? AND status = 'pending'
                            ORDER BY reservation.id ASC");

        $sql->bindParam(1,$_SESSION["userId"]);
        $sql->execute();
        $results = $sql->fetchAll(PDO::FETCH_OBJ);


        $data = array();
        $set = array();
        $lastId = -1;
        foreach ($results as $result) {
            $meal = array();
            if ($result->reservationId != $lastId) {
                if ($lastId != -1) $data[] = $set;
                $set = array();
                $lastId = $result->reservationId;
                $set["reservationId"] = $result->reservationId;
                $set["restaurantName"] = $result->restaurantName;
                $set["time"] = $result->time;
                $set["numberOfSeats"] = $result->numberOfSeats;
                $set["totalPrice"] = 0;
            }
            $meal["mealName"] = $result->mealName;
            $meal["mealAmount"] = $result->mealAmount;
            $meal["mealPrice"] = $result->mealPrice;
            $set["meals"][] = $meal;
            $set["totalPrice"] = $set["totalPrice"] + $result->mealPrice * $result->mealAmount;
        }
        if (count($results) != 0) $data[] = $set;
        echo json_encode($data);
    }

    public function deleteReservation() {
        $db = Settings::getDB();

        $sql = $db->prepare("DELETE FROM reservation WHERE id = ? ");
        $sql->bindParam(1, $_POST["reservationId"]);
        $sql->execute();
    }
}