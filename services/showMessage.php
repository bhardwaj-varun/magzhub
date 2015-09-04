<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Session.php';
require_once '../database/dbOperation.php';
$SessionObj=new Session('Magzhub');
class showMessage{
    function __construct() {
        ;
    }
    function showMessageUser($userId)
    {
        $dboperationObj= new dboperation();
        $result=$dboperationObj->showMessageUser($userId);
        $msg['custommessage']='Welcome '.$result['first_name'];
        echo json_encode($msg);
    }
    function showMessagePublisher($publisherId)
    {
        $dboperationObj= new dboperation();
        $result=$dboperationObj->showMessagePublisher($publisherId);
        $msg['custommessage']='Welcome '.$result['first_name'];
        echo json_encode($msg);
    }
    
}
$showMessageObj= new showMessage();
if($SessionObj->checkIssetSessionPublisherId()){
  $showMessageObj->showMessagePublisher($SessionObj->getSessionPublisherId());  
}
elseif ($SessionObj->checkIssetSessionUserId()) {
$showMessageObj->showMessageUser($SessionObj->getSessionUserId()); 
}


?>