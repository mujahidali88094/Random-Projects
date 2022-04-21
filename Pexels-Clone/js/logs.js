
function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    if (response.status === 'connected') { 
        return true;
    }
    else 
        return false;
}


function checkLoginState() {               // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) {   // See the onlogin handler
        if(statusChangeCallback(response))
            login();
        else
            window.href.reload(true);
    });
}


window.fbAsyncInit = function() {
    FB.init({
        appId      : '530018688345927',
        cookie     : true,                     // Enable cookies to allow the server to access the session.
        xfbml      : true,                     // Parse social plugins on this webpage.
        version    : 'v11.0'           // Use this Graph API version for this call.
    });


    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
        statusChangeCallback(response);        // Returns the login status.
    });
};

/*if(location.href.includes("logout=yes"))
  {
    location.href = location.href.replace("logout=yes","");
    FB.logout();
  }*/


function login() {                    
    FB.api('/me',{fields:"picture,name,first_name,last_name,email"}, function(response) {
        var formData = {
            signup: "facebook",
            fName: response.first_name,
            lName: response.last_name,
            email: response.email,
            linked: 1,
        };

        $.ajax({
            type: "POST",
            url: "driver.php",
            data: formData,
        }).done(function (data) {
            if(data == "success") location.href = "index.php";
            else alert("Some error occured while signing in.");
            console.log(data);
        });

    });
}
$(document).ready(function(){

    
    
    
    $("#signUpForm").submit(function (event) {
        event.preventDefault();
        var formData = {
            signup : "default",
            fName  : document.querySelector("input[name='fName']").value,
            lName  : document.querySelector("input[name='lName']").value,
            email  : document.querySelector("input[name='email']").value,
            password: document.querySelector("input[name='password']").value,
        };

        $.ajax({
            type: "POST",
            url: "driver.php",
            data: formData,
        }).done(function (data) {
            if(data == "success") location.reload();
            else alert(data);
        });

    });


    $("#logInForm").submit(function (event) {
        event.preventDefault();
        var formData = {
            login : "default",
            loginemail  : document.querySelector("input[name='loginEmail']").value,
            loginpassword: document.querySelector("input[name='loginPassword']").value,
        };

        $.ajax({
            type: "POST",
            url: "driver.php",
            data: formData,
        }).done(function (data) {
            if(data == "success") location.reload();
            else alert(data);
        });

    });



    $("#fpForm").submit(function (event) {
        event.preventDefault();
        var formData = {
            fp : "default",
            forgEmail  : document.querySelector("input[name='forgEmail']").value,
        };

        $.ajax({
            type: "POST",
            url: "driver.php",
            data: formData,
        }).done(function (data) {
            if(data == "success") {
                $("#fpForm").hide();
                $("#mailSent").removeClass("d-none");
            }
            else {
                $("#fpForm").hide();
                $("#accountNotFound").removeClass("d-none"); 
            }
            // alert(data);
        });

    });


    $("#forgetForm").submit(function (event) {
        event.preventDefault();
        var formData = {
            fpf : "default",
            accessToken: document.querySelector("input[name='accessToken']").value, 
            pass: document.querySelector("input[name='pass']").value, 
            confirmPass: document.querySelector("input[name='confirmPass']").value, 
        };

        $.ajax({
            type: "POST",
            url: "driver.php",
            data: formData,
        }).done(function (data) {
            if(data == "success") {
                $("#forgetForm").remove();
                $("#errors").addClass("d-none"); 
                $("#passwordChanged").removeClass("d-none");
                $("#passwordChanged").html("Your Password has been successfully changed.");

            }
            else {
                $("#errors").removeClass("d-none"); 
                $("#errors").html(data);
            }
            // alert(data);
        });

    });

    $("#editProfile").submit(function (event) {
        $.ajax({
            type: "POST",
            url: "edit-profile.php",
            data: $("#editProfile").serialize(),
        }).done(function (data) {
            if(data.trim() == "success" || data.trim() == "Session Expired!") location.href="profile.php";
            else alert(data);

            // alert(data);
        });
        event.preventDefault();

    });



    $("#changePass").submit(function (event) {
        $.ajax({
            type: "POST",
            url: "change-password.php",
            data: $("#changePass").serialize(),
        }).done(function (data) {
            if(data.trim() == "success") location.href="profile.php";
            else alert(data);

        });
        event.preventDefault();

    });


    $("#deleteAccount").submit(function (event) {
        $.ajax({
            type: "POST",
            url: "delete-account.php",
            data: $("#deleteAccount").serialize(),
        }).done(function (data) {
            if(data.trim() == "success") location.href="index.php";
            else alert(data);

        });
        event.preventDefault();

    });

    

});





