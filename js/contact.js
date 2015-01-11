/**
 * Created by Vilim Stubičan on 11.1.2015..
 */

var app = angular.module("contactApp",[]);

app.controller("contactCtrl",function($scope,$filter){
    $scope.email = "";
    $scope.message = "";
    $scope.subject = "";

    $scope.sendMessage = function(){
        var formOk = true;

        if(!(($scope.email).match("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6}$"))){
            formOk = false;
        }

        console.log(formOk);
        if($scope.message == "") {
            formOk = false;
        }

        console.log(formOk);
        if(!formOk) {
            $scope.output = "Fill your form correctly. Email has to be valid and you have to enter some message.";
            return;
        }
        $.ajax({
            url : "php/contact/",
            type : "POST",
            data : {
                email : $scope.email,
                subject : $scope.subject,
                message : $scope.message
            }
        }).success(function(msg){
            $scope.email = "";
            $scope.subject = "";
            $scope.message = "";
            $scope.output = msg;
            $scope.$apply();
        })
    }
})