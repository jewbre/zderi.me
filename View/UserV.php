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
        <link href="css/host.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>
        <link href="css/user.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>

        <div ng-app="userApp" ng-controller="userCtrl" class="mainHolder">

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
            <div class="reservationHolder">
            <input ng-model="reservationFilter" placeholder="Quick search"/>
                <table class="reservationTable">
                    <tr>
                        <th>Barcode</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Meals</th>
                        <th>Seats</th>
                        <th></th>
                    </tr>
                    <tr ng-repeat="reservation in reservations | filter:reservationFilter | orderBy:'timestamp':true | limitTo:reservationLimit">
                        <td>{{ reservation.barcode }}</td>
                        <td>{{ reservation.timestamp }}</td>
                        <td>
                            {{ reservation.status }}
                            <img src="resources/images/confirm.png" ng-click="changeReservationStatus(1,this)" ng-show="{{ reservation.status == 'pending' && !checkMeals(this)}}" />
                            <img src="resources/images/delete.png" ng-click="changeReservationStatus(0,this)" ng-show="{{ reservation.status == 'pending' }}" />
                        </td>
                        <td>
                            <button ng-show="checkMeals(this)" class="addBtn" ng-click="openAddMealToReservation(reservation)">Add meals</button>
                            <div ng-show="!checkMeals(this)" ng-repeat="meal in reservation.meals">
                                <label>{{ meal.name }} : {{ meal.price }} kn x {{ meal.mealAmount }} = {{ meal.price * meal.mealAmount }} kn</label>
                            </div>
                        </td>
                        <td>
                            <div class="tables" ng-repeat="(index,value) in reservation.seats">
                                <div class="table">{{index}}</div>
                                <div class="seatingNumber">= {{value.seatingAmount}}</div>
                            </div>
                        </td>
                        <td>
                            <button class="cancelBtn" ng-click="cancelReservation(reservation)" ng-show="reservation.status == 'pending'">Cancel reservation</button>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

    <?php
    }
}