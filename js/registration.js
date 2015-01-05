/**
 * Created by Domagoj on 13.12.2014..
 */

var app = angular.module("registrationApp", []);

app.controller("registrationCtrl", function($scope) {
    $scope.username = "";
    $scope.password = "";
    $scope.email = "";
    $scope.userType = 1;

   $scope.validateForm = function () {


       $scope.error = "";
       var usernameOK = $scope.username.match("^[a-zA-Z][a-zA-Z0-9_]{2,15}$");
       var passwordOK = $scope.password != "" &&
                        $scope.password == $scope.repeatPassword;
       var emailOK = $scope.email.match("^[A-Za-z][A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$");
       if (!usernameOK) {
           $scope.error += " Username invalid!"
       }
       if (!passwordOK) {
           $scope.error += " Password invalid!";
       }
       if (!emailOK) {
           $scope.error += " Email invalid!";
       }
       if (emailOK && passwordOK && usernameOK) {
           $.ajax({
               url: "php/user/registration/",
               type: "POST",
               data: {
                   calltype: 1,
                   username: $scope.username,
                   email: $scope.email
               }

           }).success(function (msg) {
              if(msg=="true") {
                  $.ajax({
                      url: "php/user/registration/",
                      type: "POST",
                      data: {
                          calltype: 2,
                          username: $scope.username,
                          password: $scope.password,
                          email: $scope.email,
                          firstName: $scope.firstName,
                          lastName: $scope.lastName,
                          userType: $scope.userType
                      }
                  }).success(function (msg) {

                      $scope.error = "Registration successful. You'll be redirected to home page in few seconds.";
                      $scope.$apply();
                      setTimeout(function() {
                          window.location.href = "index.php";
                      }, 10000);
                    })
                  } else {
                    $scope.error = "Username or email duplication.";
              }
           });
       }
       else {

       }
   }



});