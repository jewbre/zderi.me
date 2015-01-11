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
                <div class="restaurantImageHolder">
                <img ng-src="{{restaurant.img}}" class="restaurantImagePreview" />
                </div>
                <div class="restaurantDetails">
                <h2 class="restaurantName">{{ restaurant.name }}</h2>
                <p class="restaurantDescription">
                    {{ restaurant.address + ", " + restaurant.city}} <br>
                    {{ restaurant.contact }} <br>
                    {{ restaurant.description.substr(0,50) + "..." }}
                </p>
                </div>
                <button class="mealMenuBtn" ng-click="showMenu(this)">Check restaurant menu</button>
                <div class="rankHolder">
                    <?php if(isset($_SESSION["userId"])) { ?>
                    <div class="ratingHolder">
                        <div class="rank" ng-click="rate(restaurant.id,1)"></div>
                        <div class="rank" ng-click="rate(restaurant.id,2)"></div>
                        <div class="rank" ng-click="rate(restaurant.id,3)"></div>
                        <div class="rank" ng-click="rate(restaurant.id,4)"></div>
                        <div class="rank" ng-click="rate(restaurant.id,5)"></div>
                        <textarea class="rankComment" placeholder="Insert your comment"></textarea>
                        <br>
                        <p class="commentOnRank">Once you click on a star, rating is done.</p>
                    </div>
                    <?php } ?>
                    <span class="gastroClick" ng-click="showGastro(this)">Rank this restaurant on your site</span>
                </div>
            </div>






            <div class="mealMenuHolder" ng-click="hideMenu()">

                <div class="mealMenu">
                    <?php
                        if(isset($_SESSION["userId"])) {
                    ?>
                    <a ng-href="index.php?page=reservation&id={{currentRest.id}}">
                        <button class="reserveBtn"> Reserve here ! </button>
                    </a>
                    <br>
                    <?php } ?>
                    <div ng-repeat="meal in restaurantMenu | orderBy:'name'" class="meal">
                        <div class="mealName">{{ meal.name }}</div>
                        <div class="mealDescription">{{ meal.description }}</div>
                        <div class="mealPrice">{{ meal.price }} kn</div>
                    </div>
                </div>
            </div>

            <div class="gastroCodeHolder" ng-click="hideGastro()">
                <div class="gastroCode">
                    <h2>Copy this code and paste it to your site at the place where you want to display the ranking system.</h2>
                    <textarea class="codeDisplay" disabled>
                        {{ gastroCode }}
                    </textarea>
                    <h2>You should also have jQuery imported before the main script. If you don't, here it is:</h2>
                    <textarea class="jqueryDisplay" disabled>

        &ltscript src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"&gt
        &lt/script&gt
                    </textarea>
                </div>
            </div>

        </div>
    <?php
    }
} 