<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 11.1.2015.
 * Time: 22:13
 */
session_start();
session_destroy();
header("Location: ./");