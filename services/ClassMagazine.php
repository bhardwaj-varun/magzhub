<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassMagazine
 *
 * @author radha
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');

class ClassMagazine {
    //put your code here
    
    private $dbOperationObj,$catId,$originalMagsWithoutSubscriptionStatus,$magazineIdPDF;
    public function __construct() {
      $this->dbOperationObj=new dboperation()  ;
    
    }
    function getOriginalMagsWithoutSubscriptionStatus(){
        return $this->originalMagsWithoutSubscriptionStatus;
    }
    function setOriginalMagsWithoutSubscriptionStatus($status){
        $this->originalMagsWithoutSubscriptionStatus=$status;
    }
    function listMagazine()
    {
        return $this->dbOperationObj->ListMagazines($this->catId,$_POST['magIdForCategory']);
    }
    function readMagazine()
    {
        return $this->dbOperationObj->getFileIdOfLatestIssue($this->magazineId);
    }
    function ListMagazinePublisher($publisherId){
        
        return $this->dbOperationObj->ListMagazinePublisher($this->catId,$publisherId);
    }
    function setCatId(){
        $this->catId=$_POST['catid'];
    }
    function setMagazineId()
    {
        $this->magazineIdPDF=$_POST['magId'];
    }
    function getSubscriptionId($userid){
        
    
  
        $length= count($this->originalMagsWithoutSubscriptionStatus);
        
        for($i=0;$i<$length;$i++){
            $dbOperation=new dboperation();
            $magid=$this->originalMagsWithoutSubscriptionStatus[$i]['MagazineId'];
            $result=$dbOperation->getSubscriptionStatus($userid, $magid);
            
            $this->originalMagsWithoutSubscriptionStatus[$i]['subscriptionstatus']=$result;
            
        }
        
        
        
    }
    function getFileIdOfLatestIssue($userId)
    {
        
        $this->result=$this->dbOperationObj->getFileIdOfLatestIssue($this->magazineIdPDF, $userId);
        return $this->result;
    }
      function getFileIdOfLatestIssuePublisher($publisherId)
    {
        
        $this->result=$this->dbOperationObj->getFileIdOfLatestIssuePublisher($this->magazineIdPDF, $publisherId);
        return $this->result;
    }
    
    
}
$magazineObj=new ClassMagazine();
if($SessionObj->checkIssetSessionUserId()){
 if(isset($_POST['catid'])){
     
    $magazineObj->setCatId();
    $magazineObj->setOriginalMagsWithoutSubscriptionStatus($magazineObj->listMagazine());
//echo 'before subsciption';
//echo $SessionObj->getSessionUserId();
    $magazineObj->getSubscriptionId($SessionObj->getSessionUserId());
//echo 'after subsciption';
    echo json_encode($magazineObj->getOriginalMagsWithoutSubscriptionStatus());
 }
 else if(isset ($_POST['magId'])){
     
    $magazineObj->setMagazineId();
     $fileId=$magazineObj->getFileIdOfLatestIssue($SessionObj->getSessionUserId());
    
     if($fileId)
     {
         $fileUrl['url']="https://drive.google.com/file/d/".$fileId['fileId']."/preview?pli=1";
         echo json_encode($fileUrl);
     }
    
     
 }

 }
else if($SessionObj->checkIssetSessionPublisherId()){
    
    if(isset($_POST['catid'])){
    $magazineObj->setCatId();
    $magazineObj->setOriginalMagsWithoutSubscriptionStatus($magazineObj->ListMagazinePublisher($SessionObj->getSessionPublisherId()));
    echo json_encode($magazineObj->getOriginalMagsWithoutSubscriptionStatus());
    }
    else if(isset ($_POST['magId'])){
        
    $magazineObj->setMagazineId();
     $fileId=$magazineObj->getFileIdOfLatestIssuePublisher($SessionObj->getSessionPublisherId());
    
     if($fileId)
     {
         $fileUrl['url']="https://docs.google.com/a/bpsk12.org/file/d/".$fileId['fileId']."/preview?pli=1";
         echo json_encode($fileUrl);
     }
    }
}

 else {
     $page='index.html';
   $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/../';
        header('Location: '.$this->url.$page);
}