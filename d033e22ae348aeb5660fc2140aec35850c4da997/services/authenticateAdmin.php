<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
if(!$SessionObj->checkIssetSessionAdmin()){
    if(isset($_POST['email'])&&isset($_POST['password'])){
        $email=$_POST['email'];
        $passwd=$_POST['password'];

        $dboperationObj=new dboperation();
        $result=$dboperationObj->authenticateAdmin($email,$passwd);

        if($result[0]['result']==0){
            $SessionObj->setSessionAdmin($result[1]['result']);
             
        }
        echo json_encode($result);
       
    }
       
}
else{
    $page='index.html';
   $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/../';
        header('Location: '.$url.$page);
}




?>
