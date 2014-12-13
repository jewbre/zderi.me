<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 11.10.2014.
 * Time: 15:40
 *
 * When including, include after 'constants.php' file.
 * Values for connection are inside that file !
 *
 */

    try{
        $db = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DB_USERNAME, DB_PASSWORD);
    } catch (PDOException $e) {
        die("Unable to connect with database.\n" . $e->errorInfo);
    }