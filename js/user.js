/**
 * Created by Domagoj on 4.1.2015..
 */

var app = angular.module("userApp", []);

app.controller("userCtrl", function($scope) {

    $scope.keepPassword="";
    $scope.error = "";
    $.ajax({
        url: "php/user/cms/",
        type: "POST",
        data: {
            calltype: 1
        }
    }).success(function(msg) {
        $scope.userData = JSON.parse(msg);
        $scope.keepPassword = $scope.userData.password;
        $scope.$apply();
    })

    $scope.saveUserChanges = function() {

        if ($scope.userData.password != "") {
            if($scope.keepPassword == $scope.oldPassword) {
                $.ajax({
                    url: "php/user/cms/",
                    type: "POST",
                    data: {
                        calltype: 2,
                        user: $scope.userData
                    }
                }).success(function(msg){
                    $scope.error = "Successfully changed info.";
                    $scope.keepPassword = $scope.userData.password;
                    $scope.oldPassword="";
                    $scope.$apply();
                })
            }
            else {
                $scope.error = "Incorrect old password, please try again.";
                $scope.oldPassword = "";
            }
        }
        else {
            $scope.error = "Password field is empty. Can't update data.";
            $scope.$apply();
        }

    }


});