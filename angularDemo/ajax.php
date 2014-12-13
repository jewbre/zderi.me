<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 9.11.2014.
 * Time: 15:46
 */

    $data = array();

    for($i=1;$i<=15;$i++) {

        $set = array();
        $set["url"] = "logo".$i.".png";
        $set["name"] = "Logo " . $i;
        $set["owner"] = "Nobody " . $i;

        $data[] = $set;
    }


    echo json_encode($data);