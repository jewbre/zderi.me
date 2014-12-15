<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 0:21
 */

include_once "Host.php";
switch(intval($_POST["calltype"])) {
    case 1:
        $host = new Host();
        $host->addNewRestaurant();
        break;
    case 2:
        $host = new Host();
        $host->getRestaurants();
        break;
    case 3:
        $host = new Host();
        $host->editRestaurant();
        $host->getRestaurants();
        break;
    case 4:
        $host = new Host();
        $host->deleteRestaurant();
        $host->getRestaurants();
        break;
}