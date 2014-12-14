/**
 * Created by Vilim Stubičan on 14.12.2014..
 */

var app = angular.module("hostApp",[]);

app.controller("hostCtrl",function($scope){



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
})