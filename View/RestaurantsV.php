<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.12.2014.
 * Time: 2:39
 */

class RestaurantsV {
    function displayList() {
        ?>

        <script src="js/restaurant.js"></script>
        <link href="css/restaurant.css" rel="stylesheet" type="text/css" />

        <div ng-app = "restaurantsApp" ng-controller="restaurantsCtrl" class="restaurantsList">
            <div class="search">
                <input type="text" class="searchInput" ng-model="search" placeholder="Filter results..." />
                <img src="resources/images/searchIcon.png" class="searchIcon" />
            </div>

            <div ng-repeat="(index,restaurant) in restaurants | filter:search | limitTo:10 | orderBy:'name'" class="restaurantPreview">
                <img ng-src="{{restaurant.img}}" class="restaurantImagePreview" />
                <div class="restaurantDetails">
                    <h2 class="restaurantName">{{ restaurant.name }}</h2>
                    <p class="restaurantDescription">
                        {{ restaurant.address + ", " + restaurant.city}} <br>
                        {{ restaurant.contact }} <br>
                        {{ restaurant.description.substr(0,50) + "..." }}
                    </p>
                </div>
                <button class="mealMenuBtn" ng-click="showMenu(this)">Check restaurant menu</button>
            </div>






            <div class="mealMenuHolder" ng-click="hideMenu()">
                <div class="mealMenu">
                    <div ng-repeat="meal in restaurantMenu | orderBy:'name'" class="meal">
                        <div class="mealName">{{ meal.name }}</div>
                        <div class="mealDescription">{{ meal.description }}</div>
                        <div class="mealPrice">{{ meal.price }} kn</div>
                    </div>
                </div>
            </div>

        </div>
    <?php
    }
} 