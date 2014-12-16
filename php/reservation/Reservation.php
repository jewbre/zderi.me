<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 23:58
 */
include_once "../../resources/constants.php";
class Reservation {


    public function getFreeSeats(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $parts1 = explode(" ",$_POST["timestamp"]);
        $time = explode("-",$parts1[0]);

        $timestamp = mktime(intval($parts1[1]),0,0,intval($time[1]),intval($time[2]),intval($time[0]));
        if($timestamp < mktime(date("h"),date("m"),date("s"),date("m"),date("d"),date("Y"))){
            echo "invalid";
            die();
        }
        $startTimestamp = $timestamp-3*3600;
        $endTimestamp = $timestamp+3*3600;

        $sql = $db->prepare("
            SELECT capacity.seatingNumber as sn, (capacity.amount - IFNULL(reservationsseats.amount,0)) as free FROM restaurant
            INNER JOIN capacity
            ON restaurant.id = capacity.restaurantId
            LEFT JOIN (SELECT * FROM reservation WHERE timestamp >= ? AND timestamp <= ? AND restaurantId = ?) as reservation
            ON reservation.restaurantId = restaurant.id
            LEFT JOIN reservationSSeats
            ON reservation.id = reservationsSeats.reservationId AND capacity.seatingNumber = reservationsSeats.seatingNumber
            WHERE restaurant.id = ?
        ");
        $sql->bindParam(1,$_POST["restaurantId"]);
        $sql->bindParam(2,$startTimestamp);
        $sql->bindParam(3,$endTimestamp);
        $sql->bindParam(4,$_POST["restaurantId"]);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $data = array();
        foreach($sql as $seating) {
            $set = array();
            $set["index"] = $seating->sn;
            $set["free"] = intval($seating->free);
            $set["occupy"] = 0;

            $data[] = $set;
        }

        echo json_encode($data);
    }
} 