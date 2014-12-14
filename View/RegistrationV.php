<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 13.12.2014.
 * Time: 23:41
 */

class RegistrationV {
    public function displayView() {
        ?>
        <script src="js/registration.js"></script>
        <div ng-app="registrationApp" ng-controller="registrationCtrl">
            <input type="radio" ng-model="userType" value="1">User<br/>
            <input type="radio" ng-model="userType" value="2">Host<br/>
            <input type="radio" ng-model="userType" value="3">Supplier<br/>
            <label>Username:</label>
            <input type="text" ng-model="username" placeholder="Username">
            <br>
            <label>Password:</label>
            <input type="password" ng-model="password" placeholder="Password">
            <br>
            <label>Repeat Password:</label>
            <input type="password" ng-model="repeatPassword" placeholder="Repeat Password">
            <br>
            <label>E-mail:</label>
            <input type="text" ng-model="email" placeholder="E-mail">
            <br>
            <label>First Name:</label>
            <input type="text" ng-model="firstName" placeholder="First Name">
            <br>
            <label>Last Name:</label>
            <input type="text" ng-model="lastName" placeholder="Last Name">
            <br>
            <button ng-click="validateForm()">Register</button>
            <p ng-bind="error"></p>
        </div>

    <?php
    }
}