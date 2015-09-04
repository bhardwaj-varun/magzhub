// JavaScript source code
var showMessage = function () {
    $.ajax({
        url: "services/showMessage.php",
        type: "post",
        success: function (response) {
            //alert(response);
            var result = $.parseJSON(response);
            //result['custommessage'];
            $("#message").html(result['custommessage']);
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }

    });
}