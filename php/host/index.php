<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 0:21
 */

include_once "Host.php";
session_start();
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


    case 5:
        $host = new Host();
        $host->getMeals();
        break;
    case 6:
        $host = new Host();
        $host->saveNewMeal();
        break;
    case 7:
        $host = new Host();
        $host->updateMeal();
        $host->getMeals();
        break;



    case 8:
        $host = new Host();
        $host->getReservations();
        break;
    case 9:
        $host = new Host();
        $host->getMealsForReservation();
        break;
    case 10:
        $host = new Host();
        $host->saveMealsForReservation();
        break;
    case 11:
        $host = new Host();
        $host->changeReservationStatus();
        $host->getReservations();
        break;

    case 12:
        $host = new Host();
        $host->getStock();
        break;
    case 13:
        $host = new Host();
        $host->updateStock();
        $host->getStock();
        break;
    case 14:
        $host = new Host();
        $host->getSuppliers();
        break;
    case 15:
        $host = new Host();
        $host->getSupplierIngredients();
        break;
    case 16:
        $host = new Host();
        $host->insertOrder();
        $host->getOrders();
        break;
    case 17:
        $host = new Host();
        $host->getOrders();
        break;
    case 18:
        $host = new Host();
        $host->getAllIngredients();
        break;
    case 19:
        $host = new Host();
        $host->getQuickSuppliers();
        break;
    case 20:
        $host = new Host();
        $host->deleteOrder();
        $host->getOrders();
        break;
}