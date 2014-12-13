/**
 * Created by Vilim Stubičan on 21.10.2014..
 */

function setupListeners() {

    $("#username").on("change",function() {
        $("#usernameErrorOutput").html("");
        validateUsername();
    })

    $("#password").on("change",function(){
        validatePassword();
    })

    $("#repeatPassword").on("change",function(){
        validatePassword();
    })

    $("#email").on("change",function() {
        validateEmail();
    })

    $("#name").on("change",function(){
        validateName();
    })
    $("#lastname").on("change",function(){
        validateLastname();
    })

}

function validateUsername() {
    var username = $("#username").val();
    if(username.match("^[a-zA-Z][a-zA-Z0-9_-]{2,15}$")) {
        $.ajax({
            url: "php/ajax.php",
            method: "POST",
            data: {
                username : username,
                callAction : 1
            }
        }).success(function(msg){
            if(msg == "ok") {
                $("#usernameErrorOutput").html("<img src=\"resources/images/confirm.png\" width=10 />");
            } else {
                $("#usernameErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
            }
        })
    } else {
        $("#usernameErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
    }
}

function validateEmail(){
    var email = $("#email").val();
    if(email.match("^[a-zA-Z][a-zA-Z0-9._]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$")) {
        $.ajax({
        url: "php/ajax.php",
        method: "POST",
        data: {
            email : email,
            callAction : 2
        }
    }).success(function(msg){
        if(msg == "ok") {
            $("#emailErrorOutput").html("<img src=\"resources/images/confirm.png\" width=10 />");
        } else {
            $("#emailErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
        }
    })
    } else {
        $("#emailErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
    }
}

function validatePassword() {
    var password = $("#password").val();
    var repeatPassword = $("#repeatPassword").val();

    if(password == repeatPassword && password.length >=4) {
        $("#passwordErrorOutput").html("<img src=\"resources/images/confirm.png\" width=10 />");
    } else {
        $("#passwordErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
    }
}

function validateName() {
    var name = $("#name").val();

    if(name.match("^[a-zA-Z]*$")) {
        $("#nameErrorOutput").html("<img src=\"resources/images/confirm.png\" width=10 />");
    } else {
        $("#nameErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
    }
}

function validateLastname() {
    var lastname = $("#lastname").val();

    if(lastname.match("^[a-zA-Z]*$")) {
        $("#lastnameErrorOutput").html("<img src=\"resources/images/confirm.png\" width=10 />");
    } else {
        $("#lastnameErrorOutput").html("<img src=\"resources/images/invalid.png\" width=10 />");
    }
}

