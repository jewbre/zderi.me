<?php

class RestaurantsList {

    function displayList() {
        ?>
        <div ng-controller="restaurantsList" class="restaurantsList">
            <div class="search">
                <input type="text" class="searchInput" ng-model="search" placeholder="Filter results..." />
                <img src="resources/images/searchIcon.png" class="searchIcon" />
            </div>

            <div ng-repeat="restaurant in restaurants | filter:search" class="restaurantPreview">
                <img ng-src="{{restaurant.img}}" class="restaurantImagePreview" />
                <div class="restaurantDetails">
                    <h2 class="restaurantName">{{ restaurant.name }}</h2>
                    <p class="restaurantDescription">
                        {{ restaurant.address + ", " + restaurant.city}} <br>
                        {{ restaurant.contact }} <br>
                        {{ restaurant.description.substr(0,50) + "..." }}
                    </p>
                </div>
            </div>

        </div>
<?php
    }
} 