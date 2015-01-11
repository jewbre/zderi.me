
var restaurants = angular.module("restaurantsApp",[]);

restaurants.controller("restaurantsCtrl", function($scope){

    // Get starting list of restaurants
    $.ajax({
        url : "php/restaurants/",
        type : "POST",
        data : {
            calltype : 1
        }
    }).success(function(msg){
        // Restaurants are returned in JSON notation
        $scope.restaurants = JSON.parse(msg);
        $scope.$apply();
    })


    //  Show overflow menu
    $scope.showMenu = function(elem) {
        $scope.currentRest = elem.restaurant;
        $.ajax({
            url : "php/restaurants/",
            type : "POST",
            data : {
                calltype : 2,
                restaurantId : elem.restaurant.id
            }
        }).success(function(msg){
            $scope.restaurantMenu = JSON.parse(msg);
            $scope.$apply();
        })

        $(".mealMenuHolder").fadeIn("normal");
    }

    $scope.hideMenu = function() {
        $(".mealMenuHolder").fadeOut("normal");
    }

    // Show gastro code
    $scope.showGastro = function (elem) {
        $.ajax({
            url : "php/gastro/",
            type : "POST",
            data : {
                calltype : 1,
                restaurantId : elem.restaurant.id
            }
        }).success(function (msg){
            $scope.gastroCode = msg;
            $scope.$apply();
        })

        $(".gastroCodeHolder").fadeIn("normal");
    }

    $scope.hideGastro = function() {
        $(".gastroCodeHolder").fadeOut("normal");
    }

    $scope.rate = function(restaurantId, rate) {
        $.ajax({
            url: "php/gastro/",
            type : "POST",
            data : {
                calltype:4,
                restaurantId : restaurantId,
                rate : rate,
                comment : $(".rankComment").val()
            }
        }).success(function(msg){
            $(".ratingHolder").html(msg);
        })
    }
});

$(document).ready(function(){
    $(".mealMenu").click(function(event){
        event.stopPropagation();
    });

    $(".gastroCode").click(function(event){
        event.stopPropagation();
    });
})
/**
 * Created by Vilim Stubičan on 14.12.2014..
 */
