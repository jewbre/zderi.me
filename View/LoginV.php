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

        <div ng-app="loginApp" ng-controller="loginCtrl" class="loginWindow">
            <p ng-bind="error"></p>
            <br>
            <label>Email:</label>
            <br>
            <input type="text" ng-model="email" placeholder="Email..."/>
            <br>
            <label>Password:</label>
            <br>
            <input type="password" ng-model="password" placeholder="Password..."/>
            <br>
            <button ng-click="validateLogin()" class="loginBtn">Login</button>
        </div>
    <?php
    }
}