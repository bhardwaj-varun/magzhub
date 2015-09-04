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
    
    function displaySubscribedMagazineOfuser($isUserAlive,$userId)
    {
        $result='You are not Logged In';
        $dboperationObj= new dboperation();
        //$SessionObj=new Session('Magzhub');
        if($isUserAlive){
       $result= $dboperationObj->getSubscribedMagazineOfUser($userId);
        $dboperationThumbnail=new dboperation();
        $resultForThumbnail=$dboperationThumbnail->listThumbnailForSubscribedMagazine($userId);
        $length=count($resultForThumbnail);
        for($i=0;$i<$length;$i++) {
            $result[$i]['thumbnail']= $resultForThumbnail[$i]['magazineThumbnail'];
        }

        }
        return $result;
        // print   $SessionObj->getSessionUserId();
    }
}
$displaySubscribedMagazine=new DisplaySubscribedMagazineOfuser();
$displayMagazine=$displaySubscribedMagazine->displaySubscribedMagazineOfuser($SessionObj->checkIssetSessionUserId(),$SessionObj->getSessionUserId());
echo json_encode($displayMagazine);
if(isset($_POST['magID']))
{
    $dboperationObj=new dboperation();
    $dboperationObj->subscribeOrUnsubscribe($SessionObj->getSessionUserId(), $_POST['magID']);
}
//print $SessionObj->getSessionUserId();
?>