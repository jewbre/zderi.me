<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 23:58
 */
session_start();
include_once "../../resources/constants.php";
class Reservation {


    public function getFreeSeats(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $parts1 = explode(" ",$_POST["timestamp"]);
        if(intval($parts1[1]) < 10) $parts1[1]="0".$parts1[1];
        $requestedTimestamp = $parts1[0]." ".($parts1[1])."-00-00";
        $timestamp = date("Y-m-d H-i-s");
        if($requestedTimestamp < $timestamp){
            echo "invalid";
            die();
        }
        $startTimestamp = $parts1[0]." ".($parts1[1]-3)."-00-00";
        $endTimestamp = $parts1[0]." ".($parts1[1]+3)."-00-00";


        $sql = $db->prepare("
            SELECT capacity.seatingNumber as sn, (capacity.amount - IFNULL(reservationsseats.amount,0)) as free FROM restaurant
            INNER JOIN capacity
            ON restaurant.id = capacity.restaurantId
            LEFT JOIN (SELECT * FROM reservation WHERE timestamp >= '".$startTimestamp."' AND timestamp <= '".$endTimestamp."' AND restaurantId = ?) as reservation
            ON reservation.restaurantId = restaurant.id
            LEFT JOIN reservationsseats
            ON reservation.id = reservationsseats.reservationId AND capacity.seatingNumber = reservationsseats.seatingNumber
            WHERE restaurant.id = ?
        ");
        $sql->bindParam(1,$_POST["restaurantId"]);
        $sql->bindParam(2,$_POST["restaurantId"]);
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


    public function makeReservation(){
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);

        $userId = $_SESSION["userId"];
        $status = "pending";

        $time = explode("-",$_POST["date"]);

        $timestamp = mktime(intval($_POST["time"]),0,0,intval($time[1]),intval($time[2]),intval($time[0]));
        if($timestamp < mktime(date("h"),date("m"),date("s"),date("m"),date("d"),date("Y"))){
            echo "invalidTime";
            die();
        }

        $timestamp = $_POST["date"]." ".$_POST["time"]."-00-00";
        $tables = json_decode($_POST["tables"]);
        $restaurantId = $_POST["restaurantId"];

        $sql = $db->prepare("INSERT INTO reservation(restaurantId, userId, timestamp, status) VALUES (?,?,?,?)");
        $sql->bindParam(1, $restaurantId);
        $sql->bindParam(2, $userId);
        $sql->bindParam(3, $timestamp);
        $sql->bindParam(4, $status);
        $sql->execute();

        $sql = $db->prepare("SELECT * FROM reservation WHERE restaurantId = ? AND userId = ? ORDER BY id DESC");
        $sql->bindParam(1, $restaurantId);
        $sql->bindParam(2, $userId);
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $sql->execute();

        $reservationId = $sql->fetch()->id;

        $sql = $db->prepare("INSERT INTO reservationsseats VALUES(?,?,?)");
        $sql->bindParam(1,$reservationId);
        foreach($tables as $sn => $amount) {
            $sql->bindParam(2,intval($sn));
            $sql->bindParam(3,intval($amount));
            $sql->execute();
        }


        if($_POST["menu"] != "{}") {
            $menu = json_decode($_POST['menu']);
            $sql = $db->prepare("INSERT INTO reservationmenu VALUES(?,?,?,?)");
            $sql->bindParam(2,$reservationId);
            foreach($menu as $key => $meal) {
                $sql->bindParam(1,intval($meal->id));
                $sql->bindParam(3,$meal->amount);
                $sql->bindParam(4,$meal->price);
                $sql->execute();
            }
        }


        $resBarcode = "R".formatTo3($reservationId).(formatTo3($reservationId*$reservationId%997));

        $sql = $db->prepare("UPDATE reservation SET barcode = ? WHERE id = ?");
        $sql->bindParam(1,$resBarcode);
        $sql->bindParam(2,$reservationId);
        $sql->execute();

        echo $resBarcode;
    }

}

function formatTo3($number){
    if($number < 10) {
        return "00".$number;
    } else if($number < 100) {
        return "0".$number;
    } else {
        return $number;
    }
}