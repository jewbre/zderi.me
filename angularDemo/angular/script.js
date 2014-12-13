/**
 * Created by Vilim Stubičan on 9.11.2014..
 */

var app = angular.module("demoApp",[]);

app.controller("demoController", function($scope) {

    $scope.displayImage = "http://nancyharmonjenkins.com/wp-content/plugins/nertworks-all-in-one-social-share-tools/images/no_image.png";

    $scope.refreshView = function() {
        $.ajax({
            url: "../ajax.php",
            type : "POST",
            data : {
            }
        }).success(function (msg){
            $scope.data = JSON.parse(msg);
            $scope.$apply();
        })
    }

    $scope.clickMe = function(element) {
        var url = element.obj.url;
        $scope.displayImage = "../images/" + url;
    }


})

function test() {
    console.log("poruka");
}