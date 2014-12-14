<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.12.2014.
 * Time: 2:38
 */


include_once "Restaurant.php";
$restaurant = new Restaurant();
switch(intval($_POST["calltype"])) {
    case 1: $restaurant->getRestaurantsList(); break;
    case 2: $restaurant->getRestaurantMenu(intval($_POST['restaurantId'])); break;
}