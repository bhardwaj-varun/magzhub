// JavaScript source code
var magazineIdForPublisher=0;
var countMagazineForPublisher=8;
$(document).ready(function (e) {
     $('[data-toggle="tooltip"]').tooltip();
    $("#magazineContainer").niceScroll({ autohidemode: false });
    showMessage();
    listMagazines();
    $(document).on('click', '#addIssue', function () {
        
        getCategoriesForIssue();
        $("#magazineContainer").addClass('hide');
        $("#divAddIssuePdf").removeClass('hide');
        $("#divAddIssueDetails").removeClass('hide');
        $("#addMagDiv").addClass('hide');
        $('#divSubscriptionStat').removeClass('show');
        $('#divSubscriptionStat').addClass('hide');
        $("#addMagSuccess").html("");
    });
    
    $("#addCategoryPlusbutton").click(function (e) {
        $('#divSubscriptionStat').removeClass('show');
        $('#divSubscriptionStat').addClass('hide');
        $("#addCatLabel").removeClass('hide');
        $("#addCatLabel").addClass('show');
        $("#divAddCategory").removeClass('hide');
        $("#divAddCategory").addClass('show');
    
    });
    $(document).on('click', '#addMag', function () {
        //alert('mag');
        getCategories();
        $('#divSubscriptionStat').removeClass('show');
        $('#divSubscriptionStat').addClass('hide');
        $("#magazineContainer").addClass('hide');
        $("#divAddIssuePdf").addClass('hide');
        $("#divAddIssueDetails").addClass('hide');
        $("#addMagDiv").removeClass('hide');
        $("#issueSuccess").html("");
    });
    
    $(document).on('click', '#myMagazine', function () {
        $('#myMagazine').prop('disabled', true);
        $("#divAddIssuePdf").addClass('hide');
        $("#divAddIssueDetails").addClass('hide');
        $("#addMagDiv").addClass('hide');
        $('#divSubscriptionStat').removeClass('show');
        $('#divSubscriptionStat').addClass('hide');
        $("#magazineContainer").removeClass('hide');
        $("#addMagSuccess").html("");
        $("#issueSuccess").html("");
        magazineIdForPublisher=0;
        countMagazineForPublisher=8;
        $("#form_container").removeClass('show');
        $("#form_container").addClass('hide');
        $("#addMagDiv").removeClass('show');
        $("#addMagDiv").addClass('hide');
        $("#magazinelist").empty();
        $("#magazinelist").html('<img id="loadingImg"src="img/ajax-loader.gif" style="padding-left:43%;padding-top: 12%;"class="hide"></img>');
         listMagazines();
        $("#magazinelist").show();
    });
    $(document).on('click','#subscriptionStatus',function(){
        $('#magazineContainer').removeClass('show');
        $('#magazineContainer').addClass('hide');
        $('#divAddIssuePdf').removeClass('show');
        $('#divAddIssuePdf').addClass('hide');
        $('#divAddIssueDetails').removeClass('show');
        $('#divAddIssueDetails').addClass('hide');
        $('#addMagDiv').removeClass('show');
        $('#addMagDiv').addClass('hide');
        $('#divSubscriptionStat').removeClass('hide');
        $('#divSubscriptionStat').addClass('show');
        listAllMagazines();
        
    });
    $(document).on('click','#fetchListOfMagazines',function(e){
            var selectedVal=$('#listOfMagazines').val();
            if(!selectedVal=="")
                publisherStats(selectedVal);
        });
    $("#CatListInissue").on('change', function (e) {
        //	var optionSelected=$("#CatListInissue option:selected",this);
        var selectedValue = this.selectedOptions[0].value;
        //alert('selected');
        getMagazines(selectedValue);
    });
    $("#buttonAddNewMagazine").click(function (e) {
		var newMag=$.trim($('#newMagazine').val());
		var catList=$.trim($('#catList').val());
		var description=$.trim($('#textAreaMag').val());
		var magazineFrequency=$.trim($('#magazineFrequency').val());
		if(newMag.length===0 ||catList.length===0 ||description.length===0 ||magazineFrequency.length===0)
		$('#addMagSuccess').html('Field(s) cannot be empty');
		else
		{
        AddMagazine();
		
		}
        return false;
    });
    $("#logout").click(function (e) {
        logout();
    });
    $('#changePassword').click(function (e) {
        $('#password').modal('show');
    });
    $('#changePasswordSubmit').click(function (e) {
		var pass1=$.trim($('#newPassword').val());
		var pass2=$.trim($('#reenterPassword').val());
		var pass3=$.trim($('#oldPassword').val());
		if(pass1.length===0 || pass2.length===0 || pass3.length===0)
		{
		
		$("#passwordMessage").html("Password cannot be empty");
		}
		else
		{
		if(pass1===pass2)
        changePassword();
		else 
		{
			$("form")[0].reset();
		$("#passwordMessage").html("Password did not match");
		}}
		
		return false;
    });

    $("#buttonAddNewIssue").click(function (e) {
		
		var magList=$.trim($('#magazineList').val());
		var issueName=$.trim($('#issueName').val());
		var description=$.trim($('#textAreaDes').val());
		var catList=$.trim($('#CatListInissue').val());
		if(magList.length===0 || issueName.length===0 || description.length===0 || catList.length===0)
		 $("#issueSuccess").html("Field(s) cannot be empty");
		 else
		 {
                     var ext = $('#addIssueImage').val().split('.').pop().toLowerCase();
                        if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
                        $("#issueSuccess").html("Invalid image extension");
                        }
                        else
                          AddIssue();
		 }
        return false;
    });
    $(document).on('click', '.read', function () {

        readPdf(this);
        $("#myModal").modal('show');
    });
    
    $(".list-group-item").click(
       function () {
           $('.list-group-item').removeClass('active');
           $(this).addClass('active');  
       }
   );


    
});
var thumbnailUpload = function () {
    var filename = $("input[type=file]")[1].files[0].name;
    $("#thumbnail-info").html(filename);
}
var fileName = function () {
    
    var filename=$("input[type=file]")[0].files[0].name;
    $("#upload-file-info").html(filename);
}
var getCategoriesForIssue = function () {
    $.ajax({

        url: "services/ClassCategory.php",
        type: "post",
        success: function (response) {
            $("#CatListInissue").html("");//set it to empty
            var opt = '<option value="" selected="selected">Categories</option>';
            //alert(opt);

            //alert(response);
            var categories = $.parseJSON(response);
            $("#catListInissue").append(opt);
            for (i = 0; i < categories.length; i++) {
                var category = '<option value="' + categories[i].id + '">' + categories[i].name + '</option>';
                if (i == 0) {
                    opt += category;
                    $("#CatListInissue").append(opt);
                }
                else {
                    $("#CatListInissue").append(category);
                }

            }

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            alert('in else');
            // alert(errorThrown);
        }
    });
}
var getCategories = function () {

    $.ajax({

        url: "services/ClassCategory.php",
        type: "post",
        success: function (response) {
            $("#catList").html("");//set it to empty
            var opt = '<option value="" selected="selected">Categories</option>';
            //	$("#catList").append('<option value="">Categories</option>');
            //alert(response);
            var categories = $.parseJSON(response);
            for (i = 0; i < categories.length; i++) {
                var category = '<option value="' + categories[i].id + '">' + categories[i].name + '</option>';
                if (i == 0) {
                    opt += category;
                    $("#catList").append(opt);
                }
                else
                $("#catList").append(category);
            }

        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert('in else');
           // alert(errorThrown);
        }
    });
}

var getMagazines = function (catId) {
    $('#magazineList').html("");
    //var div="";
    //alert(catId);
    $.ajax({
        url: "services/ClassMagazine.php",
        type: "post",
        data: { catid: catId },
        
        success: function (response) {

            //alert(response);
            var magazines = $.parseJSON(response);

            //alert(magazines.length);

            for (i = 0; i < magazines.length; i++) {

                var magdiv = '<option value="' + magazines[i].MagazineId + '">' + magazines[i].MagazineName + '</option>';
                //	alert(magazines[i].subscriptionstatus);
                $('#magazineList').append(magdiv);
            }
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert('in magazine else');
            //alert(errorThrown);
        }
    });

}

var AddIssue = function () {
	
       
    var formData = new FormData($("form")[2]);

    $.ajax({
        url: "services/Publisher.php",
        type: 'POST',
        data: formData,
        async: false,
        success: function (response) {
          
            $("form")[2].reset();
            $("form")[1].reset();
            var result = $.parseJSON(response);
            $("#upload-file-info").html("");
            $("#thumbnail-info").html("");

            $("#issueSuccess").html(result['message']);
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}
var listMagazines = function () {
    $('#loadingImg').removeClass('hide');
    $('#loadingImg').addClass('show');
    $.ajax({
        url: "services/DisplayPublisherMagazine.php",
        type: "post",
        data:{magId:magazineIdForPublisher},
        success: function (response) {
            //alert(response);
            var magazines = $.parseJSON(response);
            if(magazines!=null)
            {
            for (i = 0; i < magazines.length; i++) {
                var magazine =
            '<div class="col-md-3'
                + ' col-sm-3" >'
                + '<img  src="data:image/jpeg;base64,' + magazines[i].magazineThumbnail + '" class="img-responsive" />'
                + '<h3 id="magazineHeadline" data-toggle="tooltip" title="'+ magazines[i].MagazineName +'">' + magazines[i].MagazineName + '</h3>'
                + '<p> <button id="' + magazines[i].magazineid + '" class="read btn btn-primary">Read</button>'
                + '</p></div>';

                $("#magazinelist").append(magazine);
                magazineIdForPublisher=magazines[i].magazineid;
                
            }
           
       
         //alert(i);
            countMagazineForPublisher=magazines.length;
            
           //alert (magazinesIdForPublisher);
           
           if(countMagazineForPublisher==8)
           {
               
               listMagazines();  
           }
           else
           {
               $('#myMagazine').prop('disabled', false);
           }
            }
        },
        complete: function(){
       $('#loadingImg').removeClass('show');
        $('#loadingImg').addClass('hide');    
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }
    });
}

var AddMagazine = function () {
    var formData = new FormData($("form")[3]);
    //alert(formData);
    $.ajax({
        url: "services/Publisher.php",
        type: "post",
        data: formData,
        async: false,
        success: function (response) {
			
            $("form")[3].reset();
			$("#addMagSuccess").html("Magazine Added Succesfully");
            //alert(res);
            
            
        },
        cache: false,
        contentType: false,
        processData: false,
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert('in else');
            //alert(errorThrown);
        }
    });
}

var changePassword = function () {

    var formData = new FormData($("form")[0]);

    $.ajax({
        url: "services/Publisher.php",
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

var listAllMagazines=function(){
    $('#loadingImgInStats').removeClass('hide');
    $('#loadingImgInStats').addClass('show');
    $.ajax({
        url:"services/ClassPublisherStats.php",
        type: "post",
        success:function(response){
          //alert(response); 
          $("#listOfMagazines").html("");//set it to empty
            var opt = '<option value="" selected="selected">Magazines</option>';

            var magazines = $.parseJSON(response);
           
            for (i = 0; i < magazines.length; i++) {
                var category = '<option value="' + magazines[i].MagazineID + '">' + magazines[i].MagazineName + '</option>';
                if (i == 0) {
                    opt += category;
                    $("#listOfMagazines").append(opt);
                }
                else {
                    $("#listOfMagazines").append(category);
                }

            }
        },
         complete: function(){
       $('#loadingImgInStats').removeClass('show');
        $('#loadingImgInStats').addClass('hide');    
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }
    });
}
var publisherStats=function(magid){
    var countSubscribed=[];
    $('#divCanvas').removeClass('show');
    $('#divCanvas').addClass('hide');
    $('#loadingImgInStats').removeClass('hide');
    $('#loadingImgInStats').addClass('show');
    $.ajax({
        url: "services/ClassPublisherStats.php",
        type: "post",
        data:{magID:magid},
        success:function(response){
           // alert(response);
            var stats=$.parseJSON(response);
            //alert(stats[0].MONTH);
            if(stats==null){
                swal({
                         title: "No Subscription", 
                         text: "Sorry Zero Subscriptions!", 
                         type: "warning",
                         showCancelButton: false,
                         confirmButtonColor: "#DD6B55",
                         confirmButtonText: "OK",
                         closeOnConfirm: true 
                     });
            }
            else{
            for(i=0,j=0;i<12&&j<stats.length;i++){
                if(stats[j].MONTH==i+1)                
                    countSubscribed.push(stats[j++].COUNT_SUBSCRIBED);
                else
                    countSubscribed.push(0);
          }
          if(i<12)
              for(;i<12;i++)
                  countSubscribed.push(0);

            
            drawChart(countSubscribed);
        }
        },
         complete: function(){
       $('#loadingImgInStats').removeClass('show');
       $('#loadingImgInStats').addClass('hide');    
       $('#divCanvas').removeClass('hide');
       $('#divCanvas').addClass('show');
      },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert(errorThrown);
        }
   
        
    });      
}
var drawChart=function(countSubscribed){
    var data = {
    labels: ["January", "February", "March", "April", "May", "June",
        "July", "August", "September","October", "November", "December" ],
    datasets: [
        {
            label:"No. Of Magazines",

            // The properties below allow an array to be specified to change the value of the item at the given index
            // String  or array - the bar color
            backgroundColor: "rgba(40, 53, 147, 0.4)",

            // String or array - bar stroke color
            borderColor: "rgba(26, 35, 126, 1)",

            // Number or array - bar border width
            borderWidth: 1,

            // String or array - fill color when hovered
            hoverBackgroundColor: "rgba(255,99,132,0.4)",

            // String or array - border color when hovered
            hoverBorderColor: "rgba(255,99,132,1)",

            // The actual data
            data: countSubscribed,

            // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.
            yAxisID: "y-axis-0",
        },
        
    ]
    
};
    var ctx=$('#myChart');
    var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
   });
}