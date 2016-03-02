<?php
require_once '../database/dbOperation.php';

class signup{
    private $firstName, $lastName, $emailId, $password;
    function __construct() {
        ;
    }
    function setFirstName(){
        $this->firstName=$_POST['firstName'];
    }
    function setLastName(){
        $this->lastName=$_POST['lastName'];
    }
    function setEmailId(){
        $this->emailId=$_POST['email'];
    }
    function setPassword(){
        $this->password=sha1($_POST['password']);
    }
    function getFirstName(){
        return $this->firstName;
    }
    function getLastName(){
        return $this->lastName;
    }
    function getEmialId(){
        return $this->emailId;
    }
    function getPassword(){
        return $this->password;
    }
    function signup($firstname,$lastname,$email,$password){
        $url='http://'.$_SERVER['HTTP_HOST'].'/';
        $hash=  md5($email);
        $dboperationobj=new dboperation();
        $dboperationobj->createUser($firstname, $lastname, $email, $password, $hash);
        $to      = $email; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject 
        $message = '
 
                        Thanks for signing up!
                        Your account has been created, you can login with your credentials after you have activated your account by clicking the url below.
 
                        Please click this link to activate your account:'
                        .$url.'verify.php?url='.$hash;
        // Our message above including the link
                     
$headers = 'From: Magzhub <support@magzhub.com>' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email
    }
    
}
if(!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email'] )&& !empty($_POST['password']))
{ 
    //echo "ruchi";
    $signupObj= new signup();
    $signupObj->setFirstName();
    $signupObj->setLastName();
    $signupObj->setPassword();
    $signupObj->setEmailId();
    if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $signupObj->getEmialId())){
    // Return Error - Invalid Email
        {
        $msg = 'The email you have entered is invalid, please try again.';
        echo $msg;
        }
    
}else{
    // Return Success - Valid Email
    //echo 'in else';
     $signupObj->signup($signupObj->getFirstName(), $signupObj->getLastName(), $signupObj->getEmialId(), $signupObj->getPassword());
    
    $msg = 'Your account has been made, <br /> please verify it by clicking the activation link that has been send to your email.';
    echo $msg;
    
}

    
}
 else 
     if(!empty($_POST['email']))
                     {
         $signupObj= new signup();
         $signupObj->setEmailId();
    $dboperationobj=new dboperation();
    $result=$dboperationobj->checkEmailExists($signupObj->getEmialId());
    
   echo json_encode($result);
    
}
