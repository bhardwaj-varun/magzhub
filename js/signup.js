       var flag=0;
          var flag1=0;
       $(document).ready(function(){
          
          
            $(document).on('click','#submitSignup',function(e){
                var pass=$.trim($("#password").val());
                var pass2 = $.trim($('#repassword').val());
                var email=$.trim($('#email').val());
                var firstname=$.trim($('#firstname').val());
                var lastname=$.trim($('#lastname').val());
              
                if(pass.length===0 || pass2.length===0||email.length===0||firstname.length===0||lastname===0 || flag===1 || flag1===1)
                {  
                    if(flag===1 || flag1===1)
                
              $("#signupMessage").html("either email already exists or  password mismatch.Please check");
              e.preventDefault();
                }
            else{
                e.preventDefault();
                signup();
            }
            });
            $("#email").blur(function(){
                checkEmail();
                //alert ("blur working");
                  //$('#submitSignup').prop('disabled', true);
            });
            $("#repassword").blur(function(){
                var pass1 = $.trim($('#password').val());
                var pass2 = $.trim($('#repassword').val()); 
                if(pass1!=pass2)
                {
                   // alert("password  mismatch");
                   $("#signupMessage").html("password mismatch");
                    $('#submitSignup').prop('disabled', true);
                    flag1=1;
                }   
               else{
                    $('#submitSignup').prop('disabled', false);  
                    $("#signupMessage").html("");
                    flag1=0;
                }
            });
            $('#password').blur(function(){
                
                $("#repassword").val("");
            });
            
        });        
        
        var signup = function () {
                
    var formData = new FormData($("form")[4]);

    $.ajax({
        url: "services/signup.php",
        type: 'POST',
        data: formData,
        async: true,
        success: function (response) {
            
		//alert(response);
                $("#signupMessage").html(response);
                $("form")[4].reset();
                

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;

}
var checkEmail=function(){
    //alert($('#email').val());
    
    $.ajax({
        url: "services/signup.php",
        type: "post",
        data:{ email: $('#email').val()} ,
        success: function (response) {
            //alert(response);
            var result = $.parseJSON(response);
            if(result['result']==2)
            {
                //alert( "email does not exist");
            $('#submitSignup').prop('disabled', false);
            $("#signupMessage").html("");
            flag=0;
        }
            else
            if(result['result']==1){
                $("#signupMessage").html("email already exists.");
                $('#submitSignup').prop('disabled', true);
             flag=1;
            }
        else
            if(result['result']==3){
                $("#signupMessage").html("You have already signed up.Please verify your email");
                $('#submitSignup').prop('disabled', true);
                flag=1;
            }
        },
        error: function (response, status, errorThrown) {
            console.log(response.status);
            alert(errorThrown);
        }

    });
}