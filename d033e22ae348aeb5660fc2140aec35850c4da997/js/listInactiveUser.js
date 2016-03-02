$(document).ready(function(){
    
     $(document).on('click', "#listInactiveUser", function () {
        $('#activateAllDiv').removeClass('hide');
        $('#activateAllDiv').addClass('show');
       listInactiveUser();

    });
    $(document).on('click','#activate',function(){
       var id=this.value; 
      
       activateUser(id);
    });
    $(document).on('click','#activateAll',function(){
       
       activateAllUsers();
    });
    $("#logout").click(function (e) {
        //alert('logout');
        logout();
    });
});
var listInactiveUser = function (id) {
    //$('#magazineList').html("");
    //var div="";
  
    $.ajax({
        url: "services/AdminInactiveUser.php",
        type: "post",
       
        success: function (response) {

            $('#inactiveUser').empty();
           var inactiveUsers = $.parseJSON(response);

           if(inactiveUsers!==null)
           {
               $('#activateAll').removeClass('hide');
               $('#activateAll').addClass('show');
            for (i = 0; i < inactiveUsers.length; i++) {

                var inactiveUserdiv = '<p>' + inactiveUsers[i].first_name + ' ' + inactiveUsers[i].last_name+' <button id="activate" value="'+ inactiveUsers[i].userid + '">Activate</button> </p>';
                $('#inactiveUser').append(inactiveUserdiv);
            }
            }
           else if(inactiveUsers===null)
            {
                 $('#activateAll').removeClass('show');
                $('#activateAll').addClass('hide');
                 $('#inactiveUser').html('<p> There are no inactive users</p>');
            }  
           
    
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            
        }
    });
   

}
 var activateUser = function (userId) {
    $.ajax({
        url: "services/activateUsers.php",
        type: "post",
        data: { id: userId },
        
        success: function (response) {
            listInactiveUser();
            
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            
        }
    });

}
 var activateAllUsers = function () {
    $.ajax({
        url: "services/activateUsers.php",
        type: "post",
        
        success: function (response) {
         listInactiveUser();
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            //alert('in magazine else');
            //alert(errorThrown);
        }
    });

}
