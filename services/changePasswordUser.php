<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');

class changePasswordUser 
{
     
    function __construct() {
        ;
    }
    function changePassword($userId,$oldPassword,$newPassword)
    {
        $dboperationObj=new dboperation();
       $result= $dboperationObj->changePasswordUser($userId, $newPassword, $oldPassword);
       return $result;
    }
}
if(isset ($_POST['oldPassword']) && isset ($_POST['newPassword']))
{
    if($SessionObj->checkIssetSessionUserId())
    {
        $userObj=new changePasswordUser();
    $resultPassword=$userObj->changePassword($SessionObj->getSessionUserId(), $_POST['oldPassword'], $_POST['newPassword']);
        if($resultPassword['result'])
            echo 'Password updated Successfully';
        else
            echo 'Password is Incorrect';
            
    }
}

