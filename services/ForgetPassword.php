<?php

require_once '../database/dbOperation.php';
class ForgetPassword
{
    private $password;
    function __construct() {
        ;
    }
    function setPassword(){
        $this->password=mt_rand(1000, 10000);
    }
    function getPassword()
    {
        return $this->password;
    }
    function forget($email,$password){
        $hash= sha1($password);
        $dboperationobj=new dboperation();
        $dboperationobj->forgetPassword($email, $hash);
        $to      = $email; // Send email to our user
        $subject = 'Password reset'; // Give the email a subject 
        $message = '
                    Hi there,
                    You have requested a password reset.
                        Your temporary password is '.$password.'. '
                . ''.
                
 
                        'Please change your password after login';
        // Our message above including the link
                     
        $headers = 'From: Magzhub <support@magzhub.com>' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email
    }
}
$forgetPasswordObj=new ForgetPassword();
$dboperationObj=new dboperation();
$result=$dboperationObj->checkEmailExists($_POST['email']);
if($result['result']==1)
{
    $forgetPasswordObj->setPassword();
    $forgetPasswordObj->forget($_POST['email'], $forgetPasswordObj->getPassword());
    echo "password has been sent to your registered email";
}
else
    echo 'email does not exists';