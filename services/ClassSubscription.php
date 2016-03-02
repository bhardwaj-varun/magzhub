<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassSubscription
 *
 * @author radha
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
class ClassSubscription {
    //put your code here
    private $dbOperationObj,$magid;
    function __construct() {
        $this->dbOperationObj=new dboperation()  ;
    }
    function setMagid(){
        $this->magid=$_POST['magID'];
    }
    function subscribeOrUnsubscribe($userid){
        $result=$this->dbOperationObj->subscribeOrUnsubscribe($userid, $this->magid);
        echo json_encode($result);
    }
    
}
$SubscriptionObj=new ClassSubscription();
$SubscriptionObj->setMagid();
$SubscriptionObj->subscribeOrUnsubscribe($SessionObj->getSessionUserId());
?>