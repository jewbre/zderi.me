/**
 * Created by Domagoj on 6.1.2015..
 */

var app = angular.module("supplierApp", []);

app.controller("supplierCtrl",function($scope){

    $scope.ingredientUnit = "g";
    $scope.ingredient= "";
    $scope.show = false;
    $scope.currentFunc = -1;
    $scope.toggleFunc = function(index) {
        if (index == $scope.currentFunc) {
            return;
        }
        else {
            if ($scope.currentFunc > 0) {
                $(".func"+$scope.currentFunc).css("top","550px");
                $(".func"+$scope.currentFunc).css("opacity","0");
            }

            $scope.currentFunc = index;

            $(".func"+$scope.currentFunc).css("top","0");
            $(".func"+$scope.currentFunc).css("opacity","1");

        }
    };

    /*
    Preparing ingredients
     */
    $.ajax({
        url : "php/supplier/",
        type : "POST",
        data : {
            calltype : 3
        }
    }).success(function(msg){
        $scope.ingredients = JSON.parse(msg);
        $scope.$apply();
    });

    /*
    Getting supplier ingredients
     */

    $.ajax({
        url: "php/supplier/",
        type: "POST",
        data: {
            calltype: 1
        }
    }).success(function(msg) {
        $scope.supplierIngredients = JSON.parse(msg);
        $scope.$apply();
    });

    $scope.addIngredient = function() {
        if ($scope.ingredient != undefined && $scope.ingredientPrice != "" && !isNaN($scope.ingredientPrice)) {
            $.ajax({
                url: "php/supplier/",
                type: "POST",
                data: {
                    calltype: 2,
                    name: $scope.ingredient.name,
                    ingredientId: $scope.ingredient.id,
                    price: $scope.ingredientPrice,
                    unit: $scope.ingredientUnit
                }
            }).success(function(msg){
                var ingredient = JSON.parse(msg);
                $scope.supplierIngredients.push(ingredient);

                /*
                Ako postoji jednostavniji nacin da se izbaci iz JSONa jedna vrijednost,a on bude sortiran lijepo
                onda super. Ja nisam nasao pa sam ovako to rjesio. Ako samo deletas onda ostane undefined polje
                i sjebe mi se kod.
                 */
                var tempField = [];
                for(var i= 0,j=0 ;i<$scope.ingredients.length; i++) {
                    if (ingredient.ingredientId != $scope.ingredients[i].id) {
                        tempField[j] = $scope.ingredients[i];
                        j++;
                    }
                }
                $scope.ingredients = tempField;
                $scope.ingredient = "";
                $scope.ingredientPrice = "";
                $scope.ingredientUnit = "g";
                $scope.$apply();
            });
        }
    }

    $scope.removeIngredient = function(elem,call) {
        $scope.show = false;
        $.ajax({
            url: "php/supplier/",
            type: "POST",
            data: {
                ingredientId: elem.supplierIngredient.ingredientId,
                name: elem.supplierIngredient.name,
                calltype: 4
            }
        }).success(function(msg) {
            var ingredient = JSON.parse(msg);
            $scope.ingredients.push(ingredient);
            var tempField = [];
            for(var i= 0,j=0; i<$scope.supplierIngredients.length; i++) {
                if (ingredient.id != $scope.supplierIngredients[i].ingredientId) {
                    tempField[j] = $scope.supplierIngredients[i];
                    j++;
                }
            }
            $scope.supplierIngredients = tempField;
            $scope.$apply();

        })
    }

    $scope.editIngredient = function(elem) {
        $scope.ingredient = elem.supplierIngredient;
        $scope.ingredientUnit = elem.supplierIngredient.unit;
        $scope.show = true;
    };

    $scope.cancelEdit = function() {
        $scope.ingredientPrice = "";
        $scope.ingredientUnit = "g";
        $scope.ingredient = "";
        $scope.show = false;
    };

    $scope.updateIngredient = function(elem) {
        $.ajax({
            url: "php/supplier/",
            type: "POST",
            data: {
                calltype: 5,
                ingredient: JSON.stringify($scope.ingredient),
                price: $scope.ingredientPrice,
                unit: $scope.ingredientUnit
            }
        }).success(function(msg) {
            for (var i =0; i<$scope.supplierIngredients.length; i++) {
                if ($scope.supplierIngredients[i].ingredientId == $scope.ingredient.ingredientId) {
                    $scope.supplierIngredients[i].price = $scope.ingredientPrice;
                    $scope.supplierIngredients[i].unit = $scope.ingredientUnit;
                    $scope.supplierIngredients[i].fullPrice = $scope.ingredientPrice+" kn/"+$scope.ingredientUnit;
                }
            }
            $scope.ingredientPrice = "";
            $scope.ingredientUnit= "g";
            $scope.show = false;
            $scope.$apply();


        });

    };

    $.ajax({
        url: "php/supplier/",
        type: "POST",
        data: {
            calltype: 6
        }
    }).success(function(msg){
        $scope.orders = JSON.parse(msg);
        $scope.$apply();
    });

    $scope.acceptOrder = function(elem) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "php/supplier/",
                type: "POST",
                data: {
                    calltype: 7,
                    order: JSON.stringify(elem)
                }
            }).success(function(msg){
                $scope.orders = JSON.parse(msg);
                $scope.$apply();
            });
        }
    }

    $scope.declineOrder = function(elem) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "php/supplier/",
                type: "POST",
                data: {
                    calltype: 8,
                    order: JSON.stringify(elem)
                }
            }).success(function(msg){
                $scope.orders = JSON.parse(msg);
                $scope.$apply();
            });
        }
    }



});