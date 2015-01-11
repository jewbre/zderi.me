<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 7.1.2015.
 * Time: 0:22
 */
session_start();
include_once "Supplier.php";
$supplier = new Supplier();
switch(intval($_POST["calltype"])) {

    case 1:
        $supplier->getSupplierIngredients();
        break;

    case 2:
        $supplier->saveIngredient();
        break;

    case 3:
        $supplier->getIngredients();
        break;

    case 4:
        $supplier->deleteIngredients();
        break;

    case 5:
        $supplier->updateIngredients();
        break;

    case 6:
        $supplier->getOrders();
        break;

    case 7:
        $supplier->acceptOrder();
        $supplier->getOrders();
        break;
}