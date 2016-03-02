<?php
require_once '../../database/dbOperation.php';
require_once '../Session.php';
$SessionObj=new Session('Magzhub');
echo "inphp";
Class activateUsers{
    
    function __construct() {
        ;
    }
    function activateSingleUser($userid)
    {
        $dboperationobj=new dboperation();
        $result=$dboperationobj->activateUser_Admin($userid);
        return $result;
    }
    function activateUsers()
    {
        $dboperationobj=new dboperation();
        $result=$dboperationobj->activeUserAll_Admin();
        return $result;
    }
    
    
    
}
if($SessionObj->checkIssetSessionAdmin())
{
    if($_POST['id'])
    {
        echo "in single";
       $admininactiveobj=new activateUsers();
       $result=$admininactiveobj->activateSingleUser($_POST['id']);
       echo json_encode($result);
    }
    else
    {
        echo "in all";
       $admininactiveobj=new activateUsers();
       $result=$admininactiveobj->activateUsers();
       echo json_encode($result);
    }
    
}