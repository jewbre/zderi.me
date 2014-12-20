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
            <div class="reservationContent">
                <div class="datetimeHolder">
                    <div class="datetimePart">
                        <h2>Select time and date</h2>

                        <label>Date</label>
                        <input type="date" ng-model="date" min="2014-12-16" ng-change="getFreeSeats()" /><br>

                        <label>Time</label>
                        <input type="number" ng-model="time" min="8" max="20"  ng-change="getFreeSeats()"/> <label>h</label>
                    </div>

                    <div class="datetimePart">
                        <h2>Select seating places</h2>
                        <h3>{{ seatError }}</h3>
                        <div ng-repeat="seat in freeSeats" class="freeTables">
                            <span>Table for {{ seat.index }}, still {{ seat.free }} free. Take </span>
                            <input type="number" min="0" ng-max="{{seat.free}}" value="0" ng-model="seat.occupy" ng-change="occupySeat(this)"/>
                        </div>
                    </div>
                </div>

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
                    <div class="reservationDetails">
                        <div class="date">
                            {{ date }} at {{ time }}:00h
                        </div>
                        <b>Tables:</b><br>
                        <div ng-repeat="(index,occupy) in occupied" class="reservationsTables">
                            Table for {{index}} x {{ occupy }}
                        </div>
                    </div>
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
                    <div class="confirmation">
                        <button class="reserveBtn" ng-click="reserve()">Confirm reservation</button>
                    </div>
                </div>
            </div>
            <div class="barcodeContent">
                <label>Thank You for Your reservation.</label>
                <br>
                <label>Your reservation number is: </label>
                <span>{{ barcode }}</span>
            </div>
        </div>

    <?php
    }

} 