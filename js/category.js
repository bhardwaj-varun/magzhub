// JavaScript source code
$(document).ready(function (e) {
    $("#containermain").niceScroll({ autohidemode: true });
    showMessage();
    getCategories();
    $(".page-header").click(function (e) {
        
    });
    $(".thumb").click(function (e) {
        
    });
    $(document).on('click', '.category', function (e) {
        // your code
        //alert("you clicked thumnail");
        var catId = $(this).find('input').attr('id')
        //	alert(catId);
        $('#cotegoriesList').hide();
        $("#header").html('MAGAZINES');
        $("#backAnchor").removeClass('hide');
        $("#backAnchor").addClass('show');
        getMagazines(catId);
    });
    $(document).on('mouseenter', '.category', function () {

        $('.category').css('cursor', 'pointer');
    });
    $(document).on('click', '.btn-primary', function () {
        // 	alert('you cliked for subscription');

        //alert(this.closest('.subAndRead').id);

        //subscription(this.closest('.subAndRead'));
        subscription(this);
    });
    $(document).on('click', '.issue', function () {
       // alert(this.id);
        $('#innercontainer').empty();

        getIssues(this);
        //$('div.issuesList').show();
    });
    $(document).on('click', '.read', function () {

        //alert("Hey you clicked read");
        readPdf(this);
    });

    $("#logout").click(function (e) {
        logout();
    });
});

var getCategories = function () {
    $('#loadingImgCat').removeClass('hide');
    $('#loadingImgCat').addClass('show');
    $.ajax({
        url: "services/ClassCategory.php",
        type: "post",
        success: function (response) {
            
            var categories = $.parseJSON(response);
            if(categories!=null){
            for (i = 0; i < categories.length; i++) {
                var category = '<div class="category col-lg-3 col-md-4 col-xs-6 thumb">' + categories[i].name
                            + '<input type="hidden" id="' + categories[i].id + '"/>'
                    + '<img  src="data:image/jpeg;base64,' + categories[i].thumbnail + '" class="img-responsive"/>'
                + '</div>';

                $("#cotegoriesList").append(category);
            }
        }
        },
          complete: function(){
       $('#loadingImgCat').removeClass('show');
        $('#loadingImgCat').addClass('hide');    
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
           // alert(errorThrown);
        }
    });
}
var getMagazines = function (catId) {
     $('#loadingImg').removeClass('hide');
    $('#loadingImg').addClass('show');
    var div = "";
    $.ajax({
        url: "services/ClassMagazine.php",
        type: "post",
        data: { catid: catId },
        success: function (response) {
            // alert(response);
            var magazines = $.parseJSON(response);
            if(magazines!=null){

            for (i = 0; i < magazines.length; i++) {

                var magdiv = '<div id="magazines"><!-- Title -->'
                + '<div class="col-md-3'
                + ' col-sm-6 ">'

                + '<img  src="data:image/jpeg;base64,' + magazines[i].magazineThumbnail + '"  class="img-responsive"/>'

                + '<h3>' + magazines[i].MagazineName + '</h3>'
                + '<p><button id="' + magazines[i].MagazineId + '" class="btn btn-primary" >' + magazines[i].subscriptionstatus + '</button>'

                + '</p></div>';
                //	alert(magazines[i].subscriptionstatus);
                $('#issuesList').append(magdiv);
            }
        }
        },
         complete: function(){
       $('#loadingImg').removeClass('show');
        $('#loadingImg').addClass('hide');    
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
           // alert(errorThrown);
        }
    });

}
var subscription = function (btn) {

    $.ajax({
        url: "services/ClassSubscription.php",
        type: "post",
        data: { magID: btn.id },
        success: function (response) {
            //var status=$.parseJSON(response);
            if ($(btn).html() == 'Subscribe') {
                $(btn).html('Unsubscribe').button("refresh");
                $('.read').html('Read').button("refresh");
            }
            else {
                $(btn).html('Subscribe').button("refresh");
                $('.read').html('Preview').button("refresh");
            }

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }

    });

}

