// JavaScript source code
var logout = function () {
    //e.preventDefault();
    $.ajax({
        url: "services/Logout.php",
        type: "post",
        success: function (response) {
            
            var path = "index.php";
            $(location).attr('href', path);
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
           // alert(errorThrown);
        }

    });
}