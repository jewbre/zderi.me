/**
 * Created by Vilim Stubičan on 14.12.2014..
 */

var app = angular.module("adminApp",[]);

app.controller("adminCtrl",function($scope){

    // Preparing the data
    $.ajax({
        url : "php/admin/",
        type : "POST",
        data : {
            calltype : 1
        }
    }).success(function(msg){
        $scope.users = JSON.parse(msg);
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


    $scope.undefinedEmpty = $scope.editedUser;
    $scope.toggleShow = function(index) {
        // 1 - show edit user
        // 2 - hide add new restaurant and empty it
        // 3 - show edit restoraunt
        switch(index){
            case 1:
                $(".editUser").slideDown("slow");
                break;
            case 2:
                $(".editUser").slideUp("slow");
                $scope.newRestaurant = $scope.undefinedEmpty;
                break;
        }
    }


    // Bind user data to the form
    $scope.editUser = function(elem){
        $scope.editedUser = elem.user;
        $scope.toggleShow(1);
    }


    // Save changes to the user
    $scope.saveUserChanges = function() {
        $.ajax({
            url : "php/admin/",
            type : "POST",
            data : {
                calltype : 2,
                obj : JSON.stringify($scope.editedUser)
            }
        }).success(function(msg){
            $scope.users = JSON.parse(msg);
            $scope.$apply();
            $scope.toggleShow(2);
        })
    }


    // Helper function for prettier display
    $scope.definePrivilege = function(index){
        switch (parseInt(index)){
            case 1 : return "User";
            case 2 : return "Host";
            case 3 : return "Supplier";
            case 4 : return "Admin";
        }
    }



    // INGREDIENTS

    // Prepare the data
    $.ajax({
        url : "php/admin/",
        type : "POST",
        data : {
            calltype : 3
        }
    }).success(function(msg){
        $scope.ingredients = JSON.parse(msg);
        $scope.$apply();
    })

    $scope.addNewIngredient = function() {
        if(angular.isUndefined($scope.newIngredient)) return;
        $.ajax({
            url : "php/admin/",
            type : "POST",
            data : {
                calltype : 4,
                name : $scope.newIngredient
            }
        }).success(function(msg){
            $scope.ingredients = JSON.parse(msg);
            $scope.$apply();
        })
    }

    $scope.deleteIngredient = function(elem){
        if(confirm("Are you sure?")){
            $.ajax({
                url : "php/admin/",
                type : "POST",
                data : {
                    calltype : 5,
                    id : elem.ingredient.id
                }
            }).success(function(msg){
                $scope.ingredients = JSON.parse(msg);
                $scope.$apply();
            })
        }
    }



    // CATEGORIES

    // Prepare the data
    $.ajax({
        url : "php/admin/",
        type : "POST",
        data : {
            calltype : 6
        }
    }).success(function(msg){
        $scope.categories = JSON.parse(msg);
        $scope.$apply();
    })

    $scope.addNewCategory = function() {
        if(angular.isUndefined($scope.newCategory)) return;
        $.ajax({
            url : "php/admin/",
            type : "POST",
            data : {
                calltype : 7,
                name : $scope.newCategory
            }
        }).success(function(msg){
            $scope.categories = JSON.parse(msg);
            $scope.$apply();
        })
    }

    $scope.deleteIngredient = function(elem){
        if(confirm("Are you sure?")){
            $.ajax({
                url : "php/admin/",
                type : "POST",
                data : {
                    calltype : 8,
                    id : elem.category.id
                }
            }).success(function(msg){
                $scope.categories = JSON.parse(msg);
                $scope.$apply();
            })
        }
    }






})