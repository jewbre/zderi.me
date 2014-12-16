/**
 * Created by Vilim Stubičan on 15.12.2014..
 */


var app = angular.module("reservationApp", []);

app.controller("reservationCtrl",function($scope){

    // check for restaurant Id, if not set properly, redirect to home.
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    if(typeof getUrlVars()["id"] === "undefined") {
        window.location.href = "index.php";
    }



    $.ajax({
        url : "php/restaurants/",
        type : "POST",
        data : {
            calltype : 2,
            restaurantId : getUrlVars()["id"]
        }
    }).success(function(msg){
        $scope.meals = JSON.parse(msg);
        $scope.$apply();
    })


    $scope.menu = JSON.parse("{}");
    $scope.addToOrder = function(elem){
        $scope.menu[elem.meal.name] = elem.meal;
    }

    $scope.deleteFromOrder = function(elem) {
        var newArray = JSON.parse("{}");
        for(key in $scope.menu) {
            if(key == elem.menuItem.name) {
                continue;
            }

            newArray[key] = $scope.menu[key];
        }

        $scope.menu = newArray;
    }

    $scope.totalPrice = function(){
        var sum = 0;
        for(key in $scope.menu) {
            sum+=parseInt($scope.menu[key].price)*parseInt($scope.menu[key].amount);
        }
        return sum;
    }

})