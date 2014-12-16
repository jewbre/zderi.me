
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
});

$(document).ready(function(){
    $(".mealMenu").click(function(event){
        event.stopPropagation();
    });
})
/**
 * Created by Vilim Stubičan on 14.12.2014..
 */
