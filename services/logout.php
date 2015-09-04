<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logout
 *
 * @author radha
 */
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
class logout {
    //put your code here
    function __construct() {
        ;
    }
  
    function redirectToIndex(){
        $page='index.php';
       
        
   $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/../';
        header('Location: '.$url.$page);
    }
}
if($SessionObj->checkIssetSessionUserId()){
    $logoutObj=new logout();
    $SessionObj->sessionDestroy();
    $logoutObj->redirectToIndex();
}
else if($SessionObj->checkIssetSessionPublisherId()){
    $logoutObj=new logout();
    $SessionObj->sessionDestroy();
    $logoutObj->redirectToIndex();
}
 else {
$page='index.php';
   $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/../';
        header('Location: '.$url.$page);
  
    
}

