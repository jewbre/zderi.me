/**
 * Created by Domagoj on 4.1.2015..
 */

var app = angular.module("loginApp", []);

app.controller("loginCtrl", function($scope) {
    $scope.email = "";
    $scope.password = "";

    $scope.validateLogin = function () {
        $scope.error = "";
        var emailOK = $scope.email != "";
        var passwordOK = $scope.password != "";
        if (!emailOK) {
            $scope.error += "Email is empty."
        }
        if (!passwordOK) {
           $scope.error += " Password is empty.";
        }
        if (passwordOK && emailOK) {
            $.ajax({
                url: "php/user/login/",
                type: "POST",
                data: {
                    email: $scope.email,
                    password: $scope.password
                }

            }).success(function (msg) {
                if (msg != "true") {
                    $scope.error = "Wrong email or password.";
                    $scope.$apply();
                } else {
                    $scope.error = "Login successful. You'll be redirected to main page in a few seconds.";
                    $scope.$apply();
                    setTimeout(function () {
                        window.location.href = "index.php";
                    }, 3000)
                }
            })

        }
    }

});