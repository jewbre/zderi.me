<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 12:41
 */

include_once "Admin.php";

switch(intval($_POST["calltype"])) {
    case 1 :
        $admin = new Admin();
        $admin->getUsers();
        break;
    case 2 :
        $admin = new Admin();
        $admin->updateUser();
        $admin->getUsers();
        break;
    case 3 :
        $admin = new Admin();
        $admin->getIngredients();
        break;
    case 4 :
        $admin = new Admin();
        $admin->addNewIngredient();
        $admin->getIngredients();
        break;
    case 5 :
        $admin = new Admin();
        $admin->deleteIngredient();
        $admin->getIngredients();
        break;

}