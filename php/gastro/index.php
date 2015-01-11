<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.1.2015.
 * Time: 2:43
 */
header("Access-Control-Allow-Origin:*");

include_once "Gastro.php";

switch(intval($_POST["calltype"])) {
    case 1: // create new link
        $gastro = new Gastro();
        $gastro->createLink();
        break;
    case 2: // code for gastroinspection
        $gastro = new Gastro();
        $gastro->getContent();
        break;
    case 3: // public vote
        $gastro = new Gastro();
        $gastro->savePublicRank();
        break;
    case 4: // user vote
        $gastro = new Gastro();
        $gastro->saveUserRank();
        break;
}