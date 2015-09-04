// JavaScript source code
$(document).ready(function (e) {
     $("#containerOfMagazine").niceScroll({ autohidemode: true });
    showMessage();
    listMagazines();
    $(document).on('click', '.unSubscribe', function () {
        // 	alert('you cliked for subscription');

        //alert(this.id);

        var id = this;

        $.confirm({
            'title': 'Confirmation',
            'message': 'Do you really want to Unsubscribe?',
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        subscription(id);
                        $('#magazinelist').empty();
                        listMagazines();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () { }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });

    });
    $(document).on('click', '.read', function () {

        readPdf(this);
        //$('div').hide();
        $("#myModal").modal('show');
    });
    $(document).on('click', '.readIssues', function () {

        readPreviousPdf(this);
        //$('div').hide();
        $("#myModal").modal('show');
    });
    $(document).on('click', '.issue', function () {
        //alert(this.id);
        $('#subscription').hide();
        $('#magazinelist').hide();
        $('#issueList').addClass('show');
		$('#backAnchor').addClass('show');
        getIssues(this);


        //$('div.issuesList').show();
    })

    $("#logout").click(function (e) {
        //alert('logout');
        logout();
    });
    $('#changePassword').click(function (e) {
        $('#password').modal('show');
    });
    $('#changePasswordSubmit').click(function (e) {
        var pass1 = $.trim($('#newPassword').val());
        var pass2 = $.trim($('#reenterPassword').val());
        var pass3 = $.trim($('#oldPassword').val());
        if (pass1.length === 0 || pass2.length === 0 || pass3.length === 0) {

            $("#passwordMessage").html("Password cannot be empty");
        }
        else {
            if (pass1 === pass2)
                changePassword();
            else {
                $("form")[0].reset();
                $("#passwordMessage").html("Password did not match");
            }
        }

        return false;
    });

});


var listMagazines = function () { 
    $('#loadingImg1').removeClass('hide');
    $('#loadingImg1').addClass('show');
    $.ajax({
        url: "services/displaySubscribedMagazineOfUser.php",
        type: "post",
        success: function (response) {
            //alert(response);
            var magazines = $.parseJSON(response);
            if(magazines!=null)
            {
            for (i = 0; i < magazines.length; i++) {
                var magazine =
            '<div class="col-md-3'
                + ' col-sm-3">'
                + '<img  src="data:image/jpeg;base64,' + magazines[i].thumbnail + '" class="img-responsive" style="padding-top:15px;"/>'
                + '<h3>' + magazines[i].MagazineName + '</h3>'
                + '<p><button id="' + magazines[i].Magazineid + '" class="read btn btn-primary  col-sm-6" >Read</button> <button id="' + magazines[i].Magazineid + '" class="issue btn btn-primary  col-sm-5 pull-right" >Issues</button><button id="' + magazines[i].Magazineid + '" class="btn unSubscribe btn-primary  col-sm-12" style="margin-top:5px;">Unsubscribe</button> '
                + '</p></div>';

                $("#magazinelist").append(magazine);
            }
        }
        },
          complete: function(){
       $('#loadingImg1').removeClass('show');
        $('#loadingImg1').addClass('hide');    
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            alert(errorThrown);
        }
    });
}
var subscription = function (btn) {

    $.ajax({
        url: "services/ClassSubscription.php",
        type: "post",
        data: { magID: btn.id },
        success: function (response) {

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            alert(errorThrown);
        }

    });

}

var getIssues = function (btn) {
        $('#loadingImg2').removeClass('hide');
            $('#loadingImg2').addClass('show');
    var div = "";
    $.ajax({
        url: "services/IssuesOfMagazine.php",
        type: "post",
        data: { MagazineId: btn.id },
        success: function (response) {
            
            var issues = $.parseJSON(response);
             if(issues!=null)
             {
            for (i = 0; i < issues.length; i++) {

                var issuediv = '<div id="issues"><!-- Title -->'
                + '<div class="col-md-3'
                + ' col-sm-6 ">'

                + '<img  src="data:image/jpeg;base64,' + issues[i].issueThumbnail + '"  class="img-responsive"/>'

                + '<h3>' + issues[i].issueName + '</h3>'
                + '<p> <button id="' + issues[i].issueid + '" class="readIssues btn btn-primary">Read</button>'

                + '</p></div>';
                //	alert(magazines[i].subscriptionstatus);
                $('#issueList').append(issuediv);
            }
            }
        },
          complete: function(){
       $('#loadingImg2').removeClass('show');
        $('#loadingImg2').addClass('hide');    
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            alert(errorThrown);
        }
    });

}
var readPreviousPdf = function (btn) {

    $.ajax({
        url: "services/IssuesOfMagazine.php",
        type: "post",
        data: { issueId: btn.id },
        success: function (response) {
            //alert(response);
            var result = $.parseJSON(response);

            var path = $.parseJSON(response);
            if (path['url'])
                $('#ifrm').attr('src', path['url']);

        },
        error: function (response, status, errorThrown) {
            //alert(response);

            console.log(response.status);
            //alert(errorThrown);
        }

    });


}
var changePassword = function () {

    var formData = new FormData($("form")[0]);

    $.ajax({
        url: "services/changePasswordUser.php",
        type: 'POST',
        data: formData,
        async: false,
        success: function (response) {
            $("form")[0].reset();
            $("#passwordMessage").html(response);



        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}