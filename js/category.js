// JavaScript source code
var countMagazine=0;
var magIdOfCategory=0;
var catIdForCategory=0;
$(document).ready(function (e) {
    $('[data-toggle="tooltip"]').tooltip();
    $("#containermain").niceScroll({ autohidemode: false });
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
        catIdForCategory=catId;
        getMagazines();
    });
    $(document).on('mouseenter', '.category', function () {

        $('.category').css('cursor', 'pointer');
    });
    $(document).on('click', '.btn-primary', function () {
       //	alert('you cliked for subscription');

        //alert(this.closest('.subAndRead').id);

        //subscription(this.closest('.subAndRead'));
        
        if($(this).html()=='Unsubscribe')
        {
            var id =this;
             $.confirm({
    title: 'Confirmation',
    content: 'Do you really want to unsubscribe',
    confirm: function(){
        subscription(id);
    },
    cancel: function(){
        
    }
});
        }
         else
         {
             subscription(this);
         }
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
           // alert(response);
            var categories = $.parseJSON(response);
            if(categories!=null){
            for (i = 0; i < categories.length; i++) {
                var category = '<div class="category col-lg-3 col-md-4 col-xs-6 thumb">' +'<strong>'+ categories[i].name +'</strong>'
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
var getMagazines = function () {
    
     $('#loadingImg').removeClass('hide');
    $('#loadingImg').addClass('show');
    var div = "";
    $.ajax({
        url: "services/ClassMagazine.php",
        type: "post",
        data: { catid: catIdForCategory ,magIdForCategory:magIdOfCategory},
        success: function (response) {
     
            var magazines = $.parseJSON(response);
            if(magazines!=null){

            for (i = 0; i < magazines.length; i++) {

                var magdiv = '<div id="magazines"><!-- Title -->'
                + '<div class="col-md-3'
                + ' col-sm-6 ">'

                + '<img  src="data:image/jpeg;base64,' + magazines[i].magazineThumbnail + '"  class="img-responsive"/>'

                + '<h3 id="magazineHeadline" data-toggle="tooltip" title="'+ magazines[i].MagazineName +'">' + magazines[i].MagazineName + '</h3>'
                + '<p><button id="' + magazines[i].MagazineId + '" class="btn btn-primary" >' + magazines[i].subscriptionstatus + '</button>'

                + '</p></div>';
                //	alert(magazines[i].subscriptionstatus);
                $('#issuesList').append(magdiv);
                magIdOfCategory=magazines[i].MagazineId;
                
            }
             countMagazine=magazines.length;
             if(countMagazine==8)
             {
                 getMagazines();
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
            //alert(response);
            var status=$.parseJSON(response);
           // alert(status);
            if ($(btn).html() == 'Subscribe' && status['resultSubscribe']==1) {
                 $.dialog({
        title: 'Successfully Subscribed',
        content:'Enjoy!',
        
    });
                $(btn).html('Unsubscribe').button("refresh");
                $('.read').html('Read').button("refresh");
            }
            else
                if ($(btn).html() == 'Subscribe' && status['resultSubscribe']==0) {
                    $.dialog({
        title: 'Cannot Subscribe',
        content: 'You can only subscribe 10 magazines in one month',
    });
    
                }
            else
                if ($(btn).html() == 'Subscribe' && status['resultSubscribe']==4) {
                    $.dialog({
        title: 'Cannot Subscribe',
        content: 'Your account is not active for subscribing',
    });
    
                }
                
            else  if ($(btn).html() == 'Unsubscribe' && status['resultSubscribe']==2){
                $.dialog({
        title: 'Successfully  unsubscribed',
        content:'Hope you enjoyed it.',
        
    });
                $(btn).html('Subscribe').button("refresh");
                $('.read').html('Preview').button("refresh");
            }
            else
                if ($(btn).html() == 'Unsubscribe' && status['resultSubscribe']==3) {
                    $.dialog({
        title: 'Cannot Unsubscribe',
        content: 'You can only unsubscribe magazine after 30 days from date of subscription',
    });
                }
            

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }

    });

}

