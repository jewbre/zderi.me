/**
 * Created by Vilim Stubičan on 14.12.2014..
 */

var app = angular.module("hostApp",[]);

app.controller("hostCtrl",function($scope){

    // Data preparing
    $.ajax({
        url : "php/host/",
        type : "POST",
        data : {
            calltype : 2
        }
    }).success(function(msg){
        $scope.restaurants = JSON.parse(msg);
        $scope.$apply();
    })


    // Toggling functions
    $scope.currentFunc = -1;
    $scope.toggleFunc = function(index) {
        if(index == $scope.currentFunc) {
            return;
        } else {
            if($scope.currentFunc > 0) {
                $(".func"+$scope.currentFunc).css("top","550px");
                $(".func"+$scope.currentFunc).css("opacity","0");
            }

            $scope.currentFunc = index;
            $(".func"+$scope.currentFunc).css("top","0px");
            $(".func"+$scope.currentFunc).css("opacity","1");
        }
    }

    $scope.toggleShow = function(index) {
        // 1 - show add new restaurant
        // 2 - hide add new restaurant and empty it
        // 3 - show edit restoraunt
        switch(index){
            case 1:
                $(".newBtn").fadeOut("normal");
                $(".newRestaurantHolder").slideDown("slow");
                $(".saveBtn").fadeIn("fast");
                $(".saveEditBtn").fadeOut("fast");
                break;
            case 2:
                $(".newBtn").fadeIn("normal");
                $(".newRestaurantHolder").slideUp("slow");
                $scope.newRestaurant = $scope.undefinedEmpty;
                $scope.seatingPlaces = JSON.parse("{}");
                break;
            case 3:
                $(".newBtn").fadeOut("normal");
                $(".newRestaurantHolder").slideDown("slow");
                $(".saveBtn").fadeOut("fast");
                $(".saveEditBtn").fadeIn("fast");
                break;
        }
    }




    // Restaurant preview and adding new
    $scope.undefinedEmpty = $scope.newRestaurant;
    $scope.seatingPlaces = JSON.parse("{}");
    $scope.tableCapacity = 2;
    $scope.numberOfTables = 1;

    // Add table icon with number of spots around the table
    $scope.addSeating = function() {
        $scope.seatingPlaces[""+$scope.tableCapacity.toString()] = parseInt($scope.numberOfTables);
    }

    // Delete provided table icon
    $scope.removeSeating = function(index) {
        var newArray = JSON.parse("{}");
        for(key in $scope.seatingPlaces) {
            if(key == ""+index) {
                continue;
            }
            newArray[key] = $scope.seatingPlaces[key];
        }
        $scope.seatingPlaces = newArray;
    }


    // Save new restaurant into database
    $scope.saveNewRestaurant = function() {
        $scope.newRestaurantError = "";
        $scope.newRestaurantCapacityError = "";

        // validate input [validation as AngularJS object] -> different than array
        if(angular.isUndefined($scope.newRestaurant) ||
            angular.isUndefined($scope.newRestaurant.name) ||
            angular.isUndefined($scope.newRestaurant.description) ||
            angular.isUndefined($scope.newRestaurant.contact) ||
            angular.isUndefined($scope.newRestaurant.address) ||
            angular.isUndefined($scope.newRestaurant.city) ||
            angular.isUndefined($scope.newRestaurant.picture)) {
            $scope.newRestaurantError = "Please insert all data."
        }

        // validate seating places [validation as Javascript array]
        var noElems = true;
        for(key in $scope.seatingPlaces) {
            noElems = false;
            break;
        }
        if(noElems) {
            $scope.newRestaurantCapacityError = "Please define your capacity."
        }

        // Check validation
        if(noElems || $scope.newRestaurantError != "") {
            return;
        }

        // Group data
        var data = $scope.newRestaurant;
        data["seatingPlaces"] = $scope.seatingPlaces;

        // Send data to php script
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 1,
                obj : JSON.stringify(data)
            }
        }).success(function(msg){
            // Receive sent restaurant with added id field
            // and push it to the existing array
            $scope.restaurants.push(JSON.parse(msg));
            $scope.$apply();
            $scope.toggleShow(2);
        })
    };

    // Bind existing restaurant's data to form
    $scope.editRestaurant = function(elem) {
        $scope.newRestaurant = elem.restaurant;
        $scope.seatingPlaces = elem.restaurant.seatingPlaces;
        $scope.toggleShow(3);
    };


    // Save updates to restaurant, everything as saving new update, except script response
    $scope.saveEditedRestaurant = function() {
        $scope.newRestaurantError = "";
        $scope.newRestaurantCapacityError = "";
        if(angular.isUndefined($scope.newRestaurant) ||
            angular.isUndefined($scope.newRestaurant.name) ||
            angular.isUndefined($scope.newRestaurant.description) ||
            angular.isUndefined($scope.newRestaurant.contact) ||
            angular.isUndefined($scope.newRestaurant.address) ||
            angular.isUndefined($scope.newRestaurant.city) ||
            angular.isUndefined($scope.newRestaurant.picture)) {
            $scope.newRestaurantError = "Please insert all data."
        }

        var noElems = true;
        for(key in $scope.seatingPlaces) {
            noElems = false;
            break;
        }

        if(noElems) {
            $scope.newRestaurantCapacityError = "Please define your capacity."
        }

        if(noElems || $scope.newRestaurantError != "") {
            return;
        }

        var data = $scope.newRestaurant;
        data["seatingPlaces"] = $scope.seatingPlaces;

        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 3,
                obj : JSON.stringify(data)
            }
        }).success(function(msg){
            // get whole list of restaurants
            $scope.restaurants = JSON.parse(msg);
            $scope.toggleShow(2);
            $scope.$apply();
        })


    }

    // Delete provided restaurant
    $scope.deleteRestaurant = function (elem) {
        if(confirm("Are you sure?")) {
            $.ajax({
                url: "php/host/",
                type : "POST",
                data : {
                    calltype : 4,
                    id : elem.restaurant.id
                }
            }).success(function(msg){
                $scope.restaurants = JSON.parse(msg);
                $scope.$apply();
            })
        }
    }




})