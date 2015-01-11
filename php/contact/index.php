<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 11.1.2015.
 * Time: 3:02
 */

$to = "jewbre18@gmail.com";
$from = $_POST["email"];
$subject = (isset($_POST["subject"]) ? $_POST["subject"] : "Message from zderi.me");
$message = "From: ".$from ."\n".$_POST["message"];

$headers = 'From: '.$from;
if(mail($to,$subject,$message,$headers)){
    echo "Your message has been sent successfully";
} else {
    echo "Something went wrong, please try again";
}