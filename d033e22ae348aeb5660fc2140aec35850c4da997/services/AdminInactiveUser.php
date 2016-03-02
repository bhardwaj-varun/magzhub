<?php
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
Class AdminInactiveUser{
    
    function __construct() {
        ;
    }
    function listOfInactiveMembers_Admin ()
    {
        $dboperationobj=new dboperation();
        $result=$dboperationobj->listOfInactiveMembers_Admin();
        return $result;
    }
    
    
    
}
if($SessionObj->checkIssetSessionAdmin())
{
    if($_POST['id'])
    {
       $dboperationObj=new dboperation();
       $result=$dboperationObj->activateUser_Admin($_POST['id']);
    }
    $admininactiveobj=new AdminInactiveUser();
    $result=$admininactiveobj->listOfInactiveMembers_Admin();
    echo json_encode($result);
}