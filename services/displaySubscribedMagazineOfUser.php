<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');

class DisplaySubscribedMagazineOfuser
{
    function __construct() {
        ;
    }
    
    function displaySubscribedMagazineOfuser($isUserAlive,$userId,$subId)
    {
        $result='You are not Logged In';
        $dboperationObj= new dboperation();
        //$SessionObj=new Session('Magzhub');
        if($isUserAlive){
       $result= $dboperationObj->getSubscribedMagOfUserInParts($userId,$subId);
        }
        return $result;
        // print   $SessionObj->getSessionUserId();
    }
}
$displaySubscribedMagazine=new DisplaySubscribedMagazineOfuser();
$displayMagazine=$displaySubscribedMagazine->displaySubscribedMagazineOfuser($SessionObj->checkIssetSessionUserId(),$SessionObj->getSessionUserId(),$_POST['subId']);
echo json_encode($displayMagazine);
if(isset($_POST['magID']))
{
    $dboperationObj=new dboperation();
    $dboperationObj->subscribeOrUnsubscribe($SessionObj->getSessionUserId(), $_POST['magID']);
}
//print $SessionObj->getSessionUserId();
?>