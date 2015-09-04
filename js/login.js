$(document).ready(function (e) {
    $("#userbuttonsmall").click(function (e) {
        e.preventDefault();
        var info = { email: $("#useremailsmall").val(), password: $("#userpasswordsmall").val() }
        UserLoginSmall(info);
       
    });
    $("#userbutton").click(function (e) {
        e.preventDefault();
        var info = { email: $("#useremail").val(), password: $("#userpassword").val() }
        UserLogin(info);
        
    });
    $("#publishersubmitsmall").click(function (e) {
        e.preventDefault();
        var info = { email: $("#publisheremailsmall").val(), password: $("#publisherpasswordsmall").val() }
        var result = PublisherLogin(info);
        

    });
    $("#publishersubmit").click(function (e) {
        e.preventDefault();
        var info = { email: $("#publisheremail").val(), password: $("#publisherpassword").val() }
        PublisherLogin(info);
       
       
    });
});
var UserLogin = function (info) {
    var msg = "";
    $.ajax({
        url: "services/authenticateExistingUser.php",
        type: "post",
        async: false,
        data: info,
        success: function (response) {
            
            var result = $.parseJSON(response);
            if (result.messagestatus == 1) {
                var path = "userDashboard.php";
                $(location).attr('href', path);
            }
            else if (result.messagestatus == 0)
              
            $("#userwrong").html(result['custommessage']);

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }
    });
    return msg;
}
var UserLoginSmall = function (info) {
    var msg = "";
    $.ajax({
        url: "services/authenticateExistingUser.php",
        type: "post",
        async: false,
        data: info,
        success: function (response) {

            var result = $.parseJSON(response);
            if (result.messagestatus == 1) {
                var path = "userDashboard.php";
                $(location).attr('href', path);
            }
            else if (result.messagestatus == 0)
               
            $("#userwrongsmall").html(result['custommessage']);

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }
    });
    return msg;
}

var PublisherLogin = function (info) {
    $.ajax({
        url: "services/authenticateExistingPublisher.php",
        type: "post",
        data: info,
        success: function (response) {
            var result = $.parseJSON(response);
            if (result['messagestatus'] == 1) {
                var path = "publisherDashboard.php";
                $(location).attr('href', path);
            }
            else
               $("#publisherwrong").html(result['custommessage']);
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }
    });
}
var PublisherLoginSmall = function (info) {
    $.ajax({
        url: "services/authenticateExistingPublisher.php",
        type: "post",
        data: info,
        success: function (response) {
            var result = $.parseJSON(response);
            if (result['messagestatus'] == 1) {
                var path = "publisherDashboard.php";
                $(location).attr('href', path);
            }
            else {
                $("#publisherwrongsmall").html(result['custommessage']);
                //alert(result['custommessage']);
            }
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
           // alert(errorThrown);
        }
    });
}
