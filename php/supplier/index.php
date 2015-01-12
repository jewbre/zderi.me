<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 7.1.2015.
 * Time: 0:22
 */
session_start();
include_once "Supplier.php";
switch(intval($_POST["calltype"])) {

    case 1:
        $supplier = new Supplier();
        $supplier->getSupplierIngredients();
        break;

    case 2:
        $supplier = new Supplier();
        $supplier->saveIngredient();
        break;

    case 3:
        $supplier = new Supplier();
        $supplier->getIngredients();
        break;

    case 4:
        $supplier = new Supplier();
        $supplier->deleteIngredients();
        break;

    case 5:
        $supplier = new Supplier();
        $supplier->updateIngredients();
        break;

    case 6:
        $supplier = new Supplier();
        $supplier->getOrders();
        break;

    case 7:
        $supplier = new Supplier();
        $supplier->acceptOrder();
        $supplier->getOrders();
        break;

    case 8:
        $supplier = new Supplier();
        $supplier->declineOrder();
        $supplier->getOrders();
        break;
}