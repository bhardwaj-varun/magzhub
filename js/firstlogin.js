var firstlogin = function () {
    
    $.ajax({
        url: "services/firstlogin.php",
        type:'post',
        success: function (response) {
           // alert(response);
            var result = $.parseJSON(response);
           
            if(result['result']===1) //first time login and account active.
            {
                
               introJs().setOption('doneLabel', 'Next page').start().oncomplete(function() {
          window.location.href = 'category.php?multipage=true';
      });
               
            }
       
        else if(result['result']===2) // first time login and not active
            {
                $.dialog({
        title: 'Welcome to Magzhub',
        content: 'Your account is inactive for subscription. Please contact at support@magzhub.com',
            
   
               }); 
               introJs().setOption('doneLabel', 'Next page').start().oncomplete(function() {
          window.location.href = 'category.php?multipage=true';
      });
    
            }
            else if(result['result']===3) //nothing to do 
            {
                
            }
        },
        error: function (response, status, errorThrown) {
            //alert(response);

            console.log(response.status);
            //alert(errorThrown);
        }

    });
}

