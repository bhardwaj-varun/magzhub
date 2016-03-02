<?php

require_once '../database/dbOperation.php';
require_once 'Session.php';

$SessionObj=new Session('Magzhub');

class firstlogin
{
    function __construct() {
        ;
    }
    
   

 function firstlogin($userid)
    {
      $dboperationObj=new dboperation();
      $result=$dboperationObj->firstlogin($userid);
      return $result;
    }
}

$fristloginobj=new firstlogin();
$result=$fristloginobj->firstlogin($SessionObj->getSessionUserId());
echo json_encode($result);