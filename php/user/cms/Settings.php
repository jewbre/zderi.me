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
            WHERE reservation.userId = ?
            ORDER BY timestamp desc, seatingNumber, mealId
        ");
        $sql->bindParam(1,$_SESSION["userId"]);
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

    public function deleteReservation() {
        $db = Settings::getDB();

        $sql = $db->prepare("DELETE FROM reservation WHERE id = ? ");
        $sql->bindParam(1, $_POST["reservationId"]);
        $sql->execute();
    }
}