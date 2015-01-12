<?php
/**
 * Created by PhpStorm.
 * User: Domagoj
 * Date: 4.1.2015.
 * Time: 19:39
 */
class UserV {

    public function displayView() {
        ?>

        <script src="js/user.js" type="text/javascript"></script>
        <link href="css/user.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

        <div ng-app="userApp" ng-controller="userCtrl" class="mainHolder">
            <div class="mainContent">
                <div class="editUser">
                    <h3>Settings</h3>

                    <p ng-bind="error"></p>
                    <br>

                    <label>Name</label>
                    <input type="text" ng-model="userData.name" />
                    <br>

                    <label>Lastname</label>
                    <input type="text" ng-model="userData.lastName" />
                    <br>

                    <label>Password</label>
                    <input type="password" ng-model="userData.password" />
                    <br>

                    <label>Contact</label>
                    <input type="text" ng-model="userData.contact" />
                    <br>

                    <label>Credit card</label>
                    <input type="text" ng-model="userData.creditCard" />
                    <br>
                    <br>
                    <span>Please confirm changes with current password</span>
                    <br>
                    <input type="password" ng-model="oldPassword" placeholder="Current password"/>
                    <br>
                    <button class="saveBtn" ng-click="saveUserChanges()">Save</button>
                </div>

                <div ng-repeat="reservation in reservations">
                    <p> {{ reservation.restaurantName }} {{ reservation.time }} {{ reservation.numberOfSeats }} {{ reservation.totalPrice }}</p>
                    <div ng-repeat="meal in reservation.meals"> {{ meal.mealName }} => {{ meal.mealAmount }} {{meal.mealPrice}}</div>
                    <button ng-click="cancelReservation(reservation)">Cancel</button>
                </div>

            </div>

        </div>

    <?php
    }
}