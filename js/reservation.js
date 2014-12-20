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

    // Get meals
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
    });







    // Prepare todays date for bindind
    $scope.time = 8;
    var today = new Date();
    $scope.date = today.getFullYear() + "-"+ (today.getMonth()+1).toString() + "-" + today.getDate();


    // Aquire free seats for provided timestamp
    $scope.getFreeSeats = function(){
        $scope.occupied = JSON.parse("{}");
        $.ajax({
            url: "php/reservation/",
            type: "POST",
            data: {
                calltype: 1,
                restaurantId: getUrlVars()["id"],
                timestamp: $scope.date + " " + $scope.time
            }
        }).success(function (msg) {
            // User could theoretically choose a time in the past.
            if(msg == "invalid") {
                alert("You can't make reservation in the past !");
            } else {
                $scope.freeSeats = JSON.parse(msg);
                $scope.$apply();
            }
        })
    };



    // Menu for the order
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

    // Calculate total sum of every item in menu
    $scope.totalPrice = function(){
        var sum = 0;
        for(key in $scope.menu) {
            sum+=parseInt($scope.menu[key].price)*parseInt($scope.menu[key].amount);
        }
        return sum;
    }


    // Chosen tables for reservation
    $scope.occupied = JSON.parse("{}");

    // Occupy a seat
    $scope.occupySeat = function(elem) {
        $scope.seatError = "";
        // If 0, set it freeeeeee
        if(elem.seat.occupy == 0) {
            var newArray = JSON.parse("{}");
            for(key in $scope.occupied){
                if(key == elem.seat.index){
                    continue;
                }
                newArray[key] = $scope.occupied[key];
            }
            $scope.occupied = newArray;
        } else {
            $scope.occupied[elem.seat.index] = elem.seat.occupy;
            // We can't reserve more than we have
            if (elem.seat.free < elem.seat.occupy) {
                elem.seat.occupy = elem.seat.free;
                $scope.occupied[elem.seat.index] = elem.seat.free;
            }
        }
    }



    $scope.reserve = function() {
        var notEmpty = false;
        for(key in $scope.occupied){
            notEmpty = true;
            break;
        }

        if(notEmpty) {
            $.ajax({
                url: "php/reservation/",
                type: "POST",
                data: {
                    calltype: 2,
                    date: $scope.date,
                    time: $scope.time,
                    tables : JSON.stringify($scope.occupied),
                    menu : JSON.stringify($scope.menu),
                    restaurantId : getUrlVars()["id"]
                }
            }).success(function(msg){
                if(msg == "invalidTime") {
                    alert("Please choose time in the future.");
                } else {
                    $scope.barcode = msg;
                    $scope.$apply();
                    $(".barcodeContent").slideDown("normal");
                    $(".reservationContent").slideUp("normal");
                }
            })
        } else {
            $scope.seatError = "Please choose at least one table.";
        }
    }

})