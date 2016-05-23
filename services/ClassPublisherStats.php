<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPublisherStats
 *
 * @author radha
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
class ClassPublisherStats {
    //put your code here
    private $dbOpertionObj;
    function __construct() {
        $this->dbOpertionObj=new dboperation();
    }
    /**
     * 
     * @param type $pubid
     * @return type array of magazineid and magazinename for a given publisher
     * 
     */
    function listAllMagazines($pubid){
        return $this->dbOpertionObj->listAllMagazinesOfPublisher($pubid);
    }
    /**
     * This method gets stats of subscription
     * @param type $magid
     * @return type array of count subscribed and month of subscription
     */
    function getStats($magid){
        return $this->dbOpertionObj->getPublisherMagazineSubscriptionStats($magid);
    }
    
}

$publisherStatsObj=new ClassPublisherStats();
if(!empty($_POST['magID'])){
    
    echo json_encode($publisherStatsObj->getStats($_POST['magID']));
}
else{
    echo json_encode($publisherStatsObj->listAllMagazines($SessionObj->getSessionPublisherId()));
}