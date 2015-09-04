<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Session.php';
$sessionObj=new Session();
$sessionObj->setSessionName('test');
$sessionObj->startSession();
 $arr=array(
   'sessionid'=>$sessionObj->getSessionName()  
 );
 echo json_encode($arr);
?>
