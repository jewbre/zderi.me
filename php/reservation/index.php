<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 23:58
 */
include_once "Reservation.php";

switch(intval($_POST["calltype"])) {
    case 1:
        $reservation = new Reservation();
        $reservation->getFreeSeats();
        break;
    case 2:
        $reservation = new Reservation();
        $reservation->makeReservation();
        break;
}