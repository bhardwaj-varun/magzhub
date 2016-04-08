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
        $("#addMagSuccess").html("");
        
        
       
    });
    $("#addCategoryPlusbutton").click(function (e) {
        $("#addCatLabel").removeClass('hide');
        $("#addCatLabel").addClass('show');
        $("#divAddCategory").removeClass('hide');
        $("#divAddCategory").addClass('show');
    });
    $(document).on('click', '#addMag', function () {
        //alert('mag');
        getCategories();
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


