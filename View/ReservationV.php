<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.12.2014.
 * Time: 23:59
 */

class ReservationV {

    public function displayView() {
        ?>
        <script src="js/reservation.js"></script>
        <link href="css/reservation.css" rel="stylesheet" type="text/css" />
        <div ng-app="reservationApp" ng-controller="reservationCtrl" class="mainHolder">

            <input type="text" ng-model="mealsFilter" placeholder="Quick search" />
            <div ng-repeat="meal in meals | filter:mealsFilter | orderBy:'name'" class="meal">
                <div class="mealDefinition">
                    <div class="mealName">{{ meal.name }}</div>
                    <div class="mealDescription">{{ meal.description }}</div>
                </div>
                <div class="mealPrice">
                    <span>{{ meal.price }} kn</span>
                    <input type="number" min="1" ng-model="meal.amount"/>
                    <button class="addBtn" ng-click="addToOrder(this)">Add to order</button>
                </div>
            </div>





            <div class="cart">
                <div class="orderDetails">
                    <div ng-repeat="menuItem in menu">
                        <h4>{{menuItem.name}}</h4>
                        <img src="resources/images/delete.png" ng-click="deleteFromOrder(this)" />
                        <p>
                            {{ menuItem.amount }} x {{ menuItem.price }} kn = {{ menuItem.amount*menuItem.price }} kn
                        </p>
                    </div>
                    <div class="total">
                       TOTAL : {{ totalPrice() }} kn
                    </div>
                </div>
            </div>

        </div>

    <?php
    }

} 