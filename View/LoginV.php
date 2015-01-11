<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 1:22
 */

class LoginV {
    public function displayView() {
    ?>
        <script src="js/login.js"></script>
        <link href="css/login.css" rel="stylesheet" type="text/css" />


        <div ng-app="loginApp" ng-controller="loginCtrl" class="loginWindow">
            <p ng-bind="error"></p>
            <br>
            <input type="text" ng-model="email" placeholder="Email..."/>
            <br>
            <input type="password" ng-model="password" placeholder="Password..."/>
            <br>
            <button ng-click="validateLogin()" class="saveBtn">Login</button>
        </div>
    <?php
    }
}