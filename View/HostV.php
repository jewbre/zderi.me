<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.12.2014.
 * Time: 17:43
 */

class HostV {
    public function displayView(){
        ?>

        <link href="css/host.css" rel="stylesheet" type="text/css" xmlns="http://www.w3.org/1999/html"/>
        <script src="js/host.js" type="text/javascript"></script>
        <div ng-app="hostApp" ng-controller="hostCtrl" class="mainHolder">

            <div class="menu">
                <div class="menuItem" ng-click="toggleFunc(1)">
                    Restaurants
                </div>
                <div class="menuItem" ng-click="toggleFunc(2)">
                    Meals
                </div>
                <div class="menuItem" ng-click="toggleFunc(3)">
                    Reservations
                </div>
            </div>

            <div class="mainContent">
                <!-- First functionality : Adding, editing and deleting restaurants -->
                <div class="functionalityWindow func1">

                    <!-- Add new restaurant button, red -->
                    <button class="newBtn" ng-click="toggleShow(1)">Add new restaurant</button>

                    <!-- Form for entering information about new restaurant -->
                    <div class="newRestaurantHolder">

                        <!-- Part 1 : info about restaurant -->
                        <div class="newRestaurantPart">
                            <h4>Add new restaurant</h4>
                            <p>{{newRestaurantError}}</p><br>
                            <label>Name</label>
                            <input type="text" ng-model="newRestaurant.name" /><br>


                            <label>Description</label>
                            <textarea ng-model="newRestaurant.description"></textarea><br>


                            <label>Contact</label>
                            <input type="text" ng-model="newRestaurant.contact" /><br>


                            <label>Address</label>
                            <input type="text" ng-model="newRestaurant.address" /><br>

                            <label>City</label>
                            <input type="text" ng-model="newRestaurant.city" /><br>

                            <label>Picture URL</label>
                            <input type="text" ng-model="newRestaurant.picture" /><br>

                        </div>

                        <!-- Part 2 : capacity information -->
                        <div class="newRestaurantPart">
                            <h4>Capacity</h4>
                            <p>{{newRestaurantCapacityError}}</p><br>
                            <label>Table capacity</label>
                            <!-- How many chairs are at the table -->
                            <input type="number" min=1 ng-model="tableCapacity"/><br>

                            <label>Number of tables</label>
                            <!-- How many exact tables are there -->
                            <input type="number" min=1 ng-model="numberOfTables"/>
                            <br>
                            <button ng-click="addSeating()" class="addBtn">Add seating</button>
                            <br><br>

                            <!-- Table icons -->
                            <div class="tables" ng-repeat="(index,place) in seatingPlaces">
                                <div class="table">{{index}}</div>
                                <div class="seatingNumber">= {{place}}</div>
                                <img src="resources/images/delete.png" ng-click="removeSeating(index)" />
                            </div>
                        </div>
                        <br>

                        <!-- Confirmation buttons -->
                        <button class="saveBtn" ng-click="saveNewRestaurant()">Save</button>
                        <button class="saveEditBtn" ng-click="saveEditedRestaurant()">Update</button>
                        <button class="cancelBtn" ng-click="toggleShow(2)">Cancel</button>
                    </div>

                    <!-- List of existing restaurants -->
                    <div class="restaurantsHolder">
                        <div ng-repeat="restaurant in restaurants" class="restaurantPreview">
                            <img ng-src="{{restaurant.picture}}" class="restaurantImagePreview" />
                            <div class="restaurantDetails">
                                <h2 class="restaurantName">{{ restaurant.name }}</h2>
                                <p class="restaurantDescription">
                                    {{ restaurant.address + ", " + restaurant.city}} <br>
                                    {{ restaurant.contact }} <br>
                                    {{ restaurant.description.substr(0,50) + "..." }}
                                </p>
                            </div><br>
                            <button class="editBtn" ng-click="editRestaurant(this)">Edit</button>
                            <button class="cancelBtn" ng-click="deleteRestaurant(this)">Delete</button>
                        </div>
                    </div>
                </div>


                <!-- Adding, updating and deleting meals -->
                <div class="functionalityWindow func2">
                    Meals
                </div>

                <!-- Reservations functionality -->
                <div class="functionalityWindow func3">
                    Reservations
                </div>
            </div>
        </div>





<?php
    }
} 