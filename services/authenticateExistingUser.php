<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'ClassAuthenticateExistingUser.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
if(!$SessionObj->checkIssetSessionUserId()){
    if(isset($_POST['email'])&&isset($_POST['password'])){
        $email=$_POST['email'];
        $passwd=$_POST['password'];

        $authenticateUserObj=new ClassAuthenticateExistingUser();
        $result=$authenticateUserObj->authenticateUser($email,$passwd);

        if($result['messagestatus']==1){
            $SessionObj->setSessionUserId($result['userid']);
        }
        echo json_encode($result);
    }
       
}
else{
    $page='home.html';
   $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/../';
        header('Location: '.$url.$page);
}




?>
