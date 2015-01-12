/**
 * Created by Vilim Stubičan on 14.12.2014..
 */

var app = angular.module("hostApp",[]);

app.controller("hostCtrl",function($scope){

    //////////////////////////////////////////////
    // RESTAURANTS
    // Following is the logic for implementing
    // restaurants functionality of the SPA
    //////////////////////////////////////////////


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
        // 4 - show add new meal
        // 5 - hide add new meal and empty it
        // 6 - show edit meal
        switch(index){
            case 1:
                $(".newResBtn").fadeOut("normal");
                $(".newRestaurantHolder").slideDown("slow");
                $(".saveResBtn").fadeIn("fast");
                $(".saveResEditBtn").fadeOut("fast");
                break;
            case 2:
                $(".newResBtn").fadeIn("normal");
                $(".newRestaurantHolder").slideUp("slow");
                $scope.newRestaurant = $scope.undefinedEmptyRestaurant;
                $scope.seatingPlaces = JSON.parse("{}");
                break;
            case 3:
                $(".newResBtn").fadeOut("normal");
                $(".newRestaurantHolder").slideDown("slow");
                $(".saveResBtn").fadeOut("fast");
                $(".saveResEditBtn").fadeIn("fast");
                break;
            case 4:
                $(".newMealBtn").fadeOut("normal");
                $(".newMealHolder").slideDown("slow");
                $(".saveMealBtn").fadeIn("fast");
                $(".saveMealEditBtn").fadeOut("fast");
                break;
            case 5:
                $(".newMealBtn").fadeIn("normal");
                $(".newMealHolder").slideUp("slow");
                $scope.newMeal = $scope.undefinedEmptyMeal;
                $scope.normative = JSON.parse("{}");
                break;
            case 6:
                $(".newMealBtn").fadeOut("normal");
                $(".newMealHolder").slideDown("slow");
                $(".saveMealBtn").fadeOut("fast");
                $(".saveMealEditBtn").fadeIn("fast");
                break;
        }
    }




    // Restaurant preview and adding new
    $scope.undefinedEmptyRestaurant = $scope.newRestaurant;
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



    //////////////////////////////////////////////
    // MEALS
    // Following is the logic for implementing
    // meals functionality of the SPA
    //////////////////////////////////////////////

    // Preparing the data
    $scope.undefinedEmptyMeal = $scope.newMeal;
    $scope.normative = JSON.parse("{}");
    $scope.ingredientUnit = "g";
    $scope.ingredientAmount = 1;

    //Get ingredients
    $.ajax({
        url : "php/admin/",
        type : "POST",
        data : {
            calltype : 3
        }
    }).success(function(msg){
        $scope.ingredients = JSON.parse(msg);
        $scope.$apply();
    });

    // Get categories
    $.ajax({
        url : "php/admin/",
        type : "POST",
        data : {
            calltype : 6
        }
    }).success(function(msg){
        $scope.categories = JSON.parse(msg);
        $scope.$apply();
    });

    $scope.check = function() {
        console.log($scope.newMeal.category);
    }

    // Get meals for restaurant
    $scope.getMeals = function() {
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype: 5,
                restaurantId : $scope.selectMealRestaurant.id
            }
        }).success(function(msg){
            $scope.meals = JSON.parse(msg);
            $scope.$apply();
        })
    };


    // Add normative to the list
    $scope.addNormative = function() {
        if(angular.isUndefined($scope.ingredient)) return;

        $scope.normative[$scope.ingredient.name] = JSON.parse("{}");
        $scope.normative[$scope.ingredient.name]["id"] = $scope.ingredient.id;
        $scope.normative[$scope.ingredient.name]["amount"] = parseInt($scope.ingredientAmount);
        $scope.normative[$scope.ingredient.name]["unit"] = $scope.ingredientUnit;
    }

    // Delete provided normative
    $scope.removeNormative = function(index) {
        var newArray = JSON.parse("{}");
        for(key in $scope.normative) {
            if(key == ""+index) {
                continue;
            }
            newArray[key] = $scope.normative[key];
        }
        $scope.normative = newArray;
    }


    // Save new meal into database
    $scope.saveMeal = function() {
        $scope.newMealError = "";
        $scope.newNormativeError = "";
        if(angular.isUndefined($scope.selectMealRestaurant)){
            $scope.newMealError = "You must select restaurant !";
            return;
        }

        // validate input [validation as AngularJS object] -> different than array
        if(angular.isUndefined($scope.newMeal) ||
            angular.isUndefined($scope.newMeal.name) ||
            angular.isUndefined($scope.newMeal.price)) {
            $scope.newMealError = "Please insert all data."
        }

        // validate seating places [validation as Javascript array]
        var noElems = true;
        for(key in $scope.normative) {
            noElems = false;
            break;
        }
        if(noElems) {
            $scope.newNormativeError = "Please define normative for Your meal."
        }

        // Check validation
        if(noElems || $scope.newMealError != "") {
            return;
        }

        // Group data
        var data = $scope.newMeal;
        if(angular.isUndefined($scope.newMeal.available)) {
            data["available"] = 0;
        }
        data["normative"] = $scope.normative;

        // Send data to php script
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 6,
                obj : JSON.stringify(data),
                restaurantId : $scope.selectMealRestaurant.id
            }
        }).success(function(msg){
            // Receive sent restaurant with added id field
            // and push it to the existing array
            $scope.meals.push(JSON.parse(msg));
            $scope.$apply();
            $scope.toggleShow(5);
        })
    };

    // Bind existing meal's data to form
    $scope.editMeal = function(elem) {
        console.log(elem.meal);
        $scope.newMeal = elem.meal;
        $scope.normative = elem.meal.normative;
        $scope.toggleShow(6);
    };


    // Save edited meal into database
    $scope.saveEditedMeal = function() {
        $scope.newMealError = "";
        $scope.newNormativeError = "";
        if(angular.isUndefined($scope.selectMealRestaurant)){
            $scope.newMealError = "You must select restaurant !";
            return;
        }

        // validate input [validation as AngularJS object] -> different than array
        if(angular.isUndefined($scope.newMeal) ||
            angular.isUndefined($scope.newMeal.name) ||
            angular.isUndefined($scope.newMeal.price)) {
            $scope.newMealError = "Please insert all data."
        }

        // validate seating places [validation as Javascript array]
        var noElems = true;
        for(key in $scope.normative) {
            noElems = false;
            break;
        }
        if(noElems) {
            $scope.newNormativeError = "Please define normative for Your meal."
        }

        // Check validation
        if(noElems || $scope.newMealError != "") {
            return;
        }

        // Group data
        var data = $scope.newMeal;
        if(angular.isUndefined($scope.newMeal.available)) {
            data["available"] = 0;
        }
        data["normative"] = $scope.normative;

        // Send data to php script
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 7,
                obj : JSON.stringify(data),
                restaurantId : $scope.selectMealRestaurant.id
            }
        }).success(function(msg){
            // Receive sent restaurant with added id field
            // and push it to the existing array
            $scope.meals = JSON.parse(msg);
            $scope.$apply();
            $scope.toggleShow(5);
        })
    };

    // Help function for description of the mail = ingredients list
    $scope.getMealDescription = function(normative) {
        var output = "";
        for(key in normative) {
            if(output != "") output+=", ";

            output+= key + " " + normative[key]["amount"] + " " + normative[key]["unit"];
        }

        return output;
    }

    // Nicer display of preview
    $scope.availability = function(available){
        switch(parseInt(available)){
            case 0 : return "Not available.";
            case 1 : return "Available";
        }
    }



    //////////////////////////////////////////////
    // RESERVATIONS
    // Following is the logic for implementing
    // reservations functionality of the SPA
    //////////////////////////////////////////////


    $scope.reservationLimit = 10;
    $scope.showMoreReservations = function(){
        $scope.reservationLimit+=10;
    }
    $scope.getReservations = function() {
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 8,
                restaurantId : parseInt($scope.selectReservationRestaurant.id)
            }
        }).success(function(msg){
            $scope.reservations = JSON.parse(msg);
            $scope.$apply();
        });
    }

    $scope.checkMeals = function(elem){
        var empty = true;
        for(key in elem.reservation.meals) {
            empty = false;
            break;
        }
        return empty && elem.reservation.status != "canceled";
    }

    $scope.openAddMealToReservation = function(elem){
        $scope.activeReservation = elem;
        $scope.getMealsForReservation();
        $(".reservationMealsInput").slideDown("normal");
    }

    $scope.getMealsForReservation = function(){
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 9,
                restaurantId : parseInt($scope.selectReservationRestaurant.id)
            }
        }).success(function(msg){
            $scope.mealsForReservation = JSON.parse(msg);
            $scope.$apply();
        });
    }

    $scope.addMealsToReservation = function(){
        if(confirm("Are you sure this is everything?")){
            var hasAny = false;
            for(key in $scope.mealsForReservation){
                hasAny = true;
                if($scope.mealsForReservation[key].mealAmount > 0) {
                    $scope.activeReservation.meals.push($scope.mealsForReservation[key]);
                }
            }
        }

        if(hasAny) {
            $.ajax({
                url: "php/host/",
                type: "POST",
                data: {
                    calltype: 10,
                    reservationId: $scope.activeReservation.id,
                    meals: JSON.stringify($scope.mealsForReservation)
                }
            });

            $(".reservationMealsInput").slideUp("normal");
        } else {
            alert("You haven't added a single meal to the reservation !");
        }
    }

    $scope.changeReservationStatus = function(status, elem) {
        switch(status) {
            case 0: var stat = "canceled"; break;
            case 1: var stat = "confirmed"; break;
        }

        $.ajax({
            url: "php/host/",
            type: "POST",
            data: {
                calltype: 11,
                reservationId: elem.reservation.id,
                restaurantId: parseInt($scope.selectReservationRestaurant.id),
                status: stat
            }
        }).success(function(msg){
            $scope.reservations = JSON.parse(msg);
            $scope.$apply();
        });
    }



    //////////////////////////////////////////////
    // STOCK
    // Following is the logic for implementing
    // stock functionality of the SPA
    //////////////////////////////////////////////

    $scope.stockMessage = "";
    $scope.getStock = function(){
        $.ajax({
            url : "php/host/",
            type : "POST",
            data : {
                calltype : 12,
                restaurantId : parseInt($scope.selectStockRestaurant.id)
            }
        }).success(function(msg){
            $scope.stock = JSON.parse(msg);
            $scope.$apply();
        })
    }

    $scope.saveStock = function(){
        $scope.stockMessage = "";
        if(confirm("Are you sure?")) {
            $.ajax({
                url: "php/host/",
                type: "POST",
                data: {
                    calltype: 13,
                    restaurantId: parseInt($scope.selectStockRestaurant.id),
                    ingredients: JSON.stringify($scope.stock)
                }
            }).success(function (msg) {
                $scope.stock = JSON.parse(msg);
                $scope.stockMessage = "Stock changed successfully saved.";
                $scope.$apply();
            })
        }
    }

    //////////////////////////////////////////////
    // ORDERS
    // Following is the logic for implementing
    // stock functionality of the SPA
    //////////////////////////////////////////////

    $.ajax({
        url: "php/host/",
        type: "POST",
        data: {
            calltype: 14
        }
    }).success(function(msg) {
        $scope.hostSuppliers = JSON.parse(msg);
        $scope.$apply();
    });

    $scope.getSupplierIngredients = function() {
        $.ajax({
            url: "php/host/",
            type: "POST",
            data: {
                calltype: 15,
                id: $scope.selectedSupplier.id
            }
        }).success(function(msg) {
            $scope.supplierIngredients = JSON.parse(msg);
            $scope.$apply();
        });
    }

    $scope.showOrdersInputForm = function() {
        $(".newOrderHolder").slideDown("normal");
        $(".newOrderBtn").fadeOut("normal");
    }

    $scope.cancelOrdersInputForm = function() {
        $(".newOrderHolder").slideUp("normal");
        $(".newOrderBtn").fadeIn("normal");
    }

    $.ajax({
        url: "php/host/",
        type: "POST",
        data: {
            calltype: 17
        }
    }).success(function(msg){
        $scope.orders = JSON.parse(msg);
        $scope.$apply();
    });

    $scope.insertNewOrder = function() {
        if ( angular.isUndefined($scope.selectedSupplier) || angular.isUndefined($scope.selectOrderRestaurant)) {
            $scope.error = "Please select restaurant and supplier.";
        }
        else {
            $.ajax({
                url: "php/host/",
                type: "POST",
                data: {
                    ingredients: JSON.stringify($scope.supplierIngredients),
                    restaurantId: $scope.selectOrderRestaurant.id,
                    supplierId: $scope.selectedSupplier.id,
                    calltype: 16
                }
            }).success(function(msg) {
                $scope.orders = JSON.parse(msg);
                $scope.error = "";
                $scope.cancelOrdersInputForm();
                $scope.$apply();
            });
        }

    }

    $.ajax({
        url: "php/host/",
        type: "POST",
        data: {
            calltype: 18
        }
    }).success(function(msg) {
        $scope.quickIngredients = JSON.parse(msg);
        $scope.$apply();
    });

    $scope.getQuickSuppliers = function() {
        $.ajax({
            url: "php/host/",
            type: "POST",
            data: {
                calltype: 19,
                ingredientId: $scope.selectedIngredient.id
            }
        }).success(function(msg){
            $scope.quickSuppliers = JSON.parse(msg);
            $scope.$apply();
        });
    }

    $scope.deleteOrder = function(elem) {
        var ask = true;
        if (elem.status == "Pending") {
            ask = confirm("Are you sure you want to cancel this order?");
        }
        if (ask) {
            $.ajax({
                url: "php/host/",
                type: "POST",
                data: {
                    calltype: 20,
                    orderId: elem.orderId
                }
            }).success(function(msg) {
                $scope.orders = JSON.parse(msg);
                $scope.$apply();
            });
        }
    }
})