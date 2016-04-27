<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbOperation
 *
 * @author radha
 */
require_once 'database.php';
class dboperation {
    //put your code here
    private  $databaseObj,$result;
    
    function __construct() {
        $this->databaseObj=new database();
    }
    function validateUser($email,$passwd){
      $this->databaseObj->query="call ValidateUser(?,?)";  
      $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
      if(!$this->databaseObj->stmt)
           echo 'stmt error';
      $this->databaseObj->stmt->bind_param('ss', $email,$passwd);
      $this->databaseObj->stmt->execute();
      $this->result=  $this->getResultantRow();
        return $this->result;
    }
    function  validatePublisher($email,$passwd){
      $this->databaseObj->query="call ValidatePublisher(?,?)";  
      $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
      if(!$this->databaseObj->stmt)
           echo 'stmt error';
      $this->databaseObj->stmt->bind_param('ss', $email,$passwd);
      $this->databaseObj->stmt->execute();
       $this->result=  $this->getResultantRow();
        return $this->result;
    }
    function ListCategories(){
         $this->databaseObj->query="call ListCategories()";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
    }
    function getFileIdOfIssue($issueId){
         $this->databaseObj->query="call getFileIdOfIssue(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
         $this->databaseObj->stmt->bind_param('i', $issueId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
    }
    function listThumbnailForMagazine ($catId){
         $this->databaseObj->query="call listThumbnailForMagazine (?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
         $this->databaseObj->stmt->bind_param('i', $catId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
    }
    function listMagazineThumbnailPublisher  ($publisherId){
         $this->databaseObj->query="call listMagazineThumbnailPublisher (?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
         $this->databaseObj->stmt->bind_param('i', $publisherId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
    }
     function listThumbnailForSubscribedMagazine ($userId){
         $this->databaseObj->query="call listThumbnailForSubscribedMagazine (?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
         $this->databaseObj->stmt->bind_param('i', $userId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
    }
     function listThumbnailForCategories (){
         $this->databaseObj->query="call listThumbnailForCategories ()";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
    }
    function ListMagazines($catId,$magId){
        $this->databaseObj->query="call ListMagazines(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ii', $catId,$magId);
        $this->databaseObj->stmt->execute();
        $this->databaseObj->res=$this->databaseObj->stmt->get_result();
        
        
        for($i=0;($this->databaseObj->row=  $this->databaseObj->res->fetch_assoc());$i++)
        {
         $this->databaseObj->rows[$i]=  $this->databaseObj->row;
        }
       return $this->databaseObj->rows;
    }
    function ListMagazinePublisher($catId,$publisherId){
        $this->databaseObj->query="call listMagazinesPublisher(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ii', $catId,$publisherId);
        $this->databaseObj->stmt->execute();
        $this->databaseObj->res=$this->databaseObj->stmt->get_result();
        
        
        for($i=0;($this->databaseObj->row=  $this->databaseObj->res->fetch_assoc());$i++)
        {
         $this->databaseObj->rows[$i]=  $this->databaseObj->row;
        }
       return $this->databaseObj->rows;
    }
    function getSubscriptionStatus($userid,$magid){
        $this->databaseObj->query="call CheckSusbscriptionStatus(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        if(!$this->databaseObj->stmt)
            echo $this->databaseObj->stmt->error;
       //echo $magid;
        $this->databaseObj->stmt->bind_param('ii', $userid,$magid);
        $this->databaseObj->stmt->execute();
        $this->databaseObj->tempres=  $this->databaseObj->stmt->get_result();
        $this->databaseObj->temprow=$this->databaseObj->tempres->fetch_assoc();
        if($this->databaseObj->temprow['subscriptionID'])return 'Unsubscribe';
         else  return 'Subscribe';
    }
    function subscribeOrUnsubscribe($userid,$magid){
        $this->databaseObj->query="call SubscribeOrUnsubscribeMagazine(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ii',$userid,$magid );
        $this->databaseObj->stmt->execute();
        $this->result=$this->getResultantRow();
        return $this->result;
   }
   function addCategory($categoryName){
       $this->databaseObj->query="call addCategory(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('s',$categoryName);
        $this->databaseObj->stmt->execute();
   }
   function addMagazine($magazineName,$categoryId,$publisherId,$description,$magazineFrequency){
       
       $this->databaseObj->query="call addMagazine(?,?,?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('siiss',$magazineName,$categoryId,$publisherId,$description,$magazineFrequency);
        $this->databaseObj->stmt->execute();
   }
   function addIssue($magazineId)   {
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$magazineId);
        $this->databaseObj->stmt->execute();
   }
   function uploadBigFilePathIssue ($filePath,$name)   {
        $this->databaseObj->query="call uploadBigFilePathIssue(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ss',$filePath,$name);
        $this->databaseObj->stmt->execute();
   }
     function getIssueIdForInsertingDetails($filePath){       
        $this->databaseObj->query="call getIssueIdForInsertingDetails(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('s',$filePath);
        $this->databaseObj->stmt->execute();
         $this->result=$this->getResultantRow();
        return $this->result;
       
   }
   function uploadIssue($magazineId,$issueDescription,$issueName,$imgdata,$issueId)
   {
       
       $this->databaseObj->query="call uploadIssue(?,?,?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('isssi',$magazineId,$issueDescription,$issueName,$imgdata,$issueId);
        $this->databaseObj->stmt->execute();
   }
      function getFileIdOfLatestIssue($magazineId,$userId)
   {
       $this->databaseObj->query="call getFileIdOfLatestIssue(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ii',$magazineId,$userId);
        $this->databaseObj->stmt->execute();
        $this->result=$this->getResultantRow();
        return $this->result;
       
   }
      function getFileIdOfLatestIssuePublisher($magazineId,$publisherId)
   {
       $this->databaseObj->query="call getFileIdOfLatestIssuePublisher(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ii',$magazineId,$publisherId);
        $this->databaseObj->stmt->execute();
        $this->result=$this->getResultantRow();
        return $this->result;
       
   }
   function getDetailsForUploadingInGoogleDrive($issueId)
   {
       
         $this->databaseObj->query="call getDetailsForUploadingInGoogleDrive(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$issueId);
        $this->databaseObj->stmt->execute();
        $result=$this->getResultantRow();
        return $result;
   }
  function insertFileIdInTempIssueUpload($driveFileId,$issueId)
   {    print $driveFileId;
        print $issueId;
       
         $this->databaseObj->query="call insertFileIdInTempIssueUpload(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('si',$driveFileId,$issueId);
        $this->databaseObj->stmt->execute();
        
   }
    function insertDetailsIntoIssuesTable($issueId)
   {
       
        $this->databaseObj->query="call insertDetailsIntoIssuesTable(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$issueId);
        $this->databaseObj->stmt->execute();
   }
   function getSubscribedMagazineOfUser($userId)
   {
        $this->databaseObj->query="call getSubscribedMagazineOfUser(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$userId);
        $this->databaseObj->stmt->execute();
        $result=$this->getMultipleResultantRows();
        return $result;
   }
     function getDifferentIssuesOfMagazine($magId, $userId,$issueId)
   {
      
        $this->databaseObj->query="call getDifferentIssuesOfMagazine(?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('iii',$magId,$userId,$issueId);
        $this->databaseObj->stmt->execute();
        $this->result=$this->getMultipleResultantRows();
        return $this->result;
       
   }
    function changePasswordPublisher($publisherId,$newPassword,$oldPassword)
   {
      
         $this->databaseObj->query="call changePasswordPublisher(?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('iss',$publisherId,$oldPassword,$newPassword);
        $this->databaseObj->stmt->execute();
         $this->result=$this->getResultantRow();
        return $this->result;
       
   }
   function changePasswordUser($userId,$newPassword,$oldPassword)
   {
      
         $this->databaseObj->query="call changePasswordUser(?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('iss',$userId,$oldPassword,$newPassword);
        $this->databaseObj->stmt->execute();
         $this->result=$this->getResultantRow();
        return $this->result;
       
   }
   function showMessageUser($userId){
         $this->databaseObj->query="call showMessageUser (?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$userId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
    }
    function showMessagePublisher ($publisherId){
         $this->databaseObj->query="call showMessagePublisher (?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$publisherId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
    }
      
    function getResultantRow(){
        $this->databaseObj->res=$this->databaseObj->stmt->get_result();
        $this->databaseObj->row=$this->databaseObj->res->fetch_assoc();
        
        if(is_null($this->databaseObj->row))
            echo 'null returned';
        return $this->databaseObj->row;
    }
    function getMultipleResultantRows(){
       $this->databaseObj->res=$this->databaseObj->stmt->get_result();
       for($i=0;($this->databaseObj->row=  $this->databaseObj->res->fetch_assoc());$i++)
       {
           $this->databaseObj->rows[$i]=  $this->databaseObj->row;
       }
       return $this->databaseObj->rows;
    }
    function createUser($firstname,$lastname,$email,$password,$url){
       
       $this->databaseObj->query="call createUser(?,?,?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('sssss',$firstname,$lastname,$email,$password,$url);
        $this->databaseObj->stmt->execute();
        
   }
   function insertIntoUser($url){
       
       $this->databaseObj->query="call insertIntoUser(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('s',$url);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
        
   }
   function checkEmailExists($email){
       
       $this->databaseObj->query="call checkEmailExists(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('s',$email);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
        
   }
   function firstlogin ($userid){
       
       $this->databaseObj->query="call firstlogin(?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$userid);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
        
   }
   function authenticateAdmin ($emailid,$password){
       
       $this->databaseObj->query="call authenticateAdmin (?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ss',$emailid,$password);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
        
   }
   function listOfInactiveMembers_Admin (){
       $this->databaseObj->query="call listOfInactiveMembers_Admin()";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
       
   }
   function activateUser_Admin  ($userid){
       $this->databaseObj->query="call activateUser_Admin (?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('i',$userid);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
       
   }
     function activeUserAll_Admin (){
       $this->databaseObj->query="call activeUserAll_Admin  ()";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getResultantRow();
         return $this->result;
       
   }  
   function DisplayPublisherMagazine($publisherid,$magazineid)
   {
       $this->databaseObj->query="call displayPublisherMagazines(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ii', $publisherid,$magazineid);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
   }
    function getSubscribedMagOfUserInParts($userId,$subId){
         $this->databaseObj->query="call getSubscribedMagOfUserInParts(?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
         $this->databaseObj->stmt->bind_param('ii', $userId,$subId);
        $this->databaseObj->stmt->execute();
        $this->result=  $this->getMultipleResultantRows();
         return $this->result;
    }
     function forgetPassword($email,$password)
   {
       $this->databaseObj->query="call forgetPassword (?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
         $this->databaseObj->stmt->bind_param('ss', $email,$password);
        $this->databaseObj->stmt->execute();
   }
   function entryInUser($firstname,$lastname,$password,$emailid){
       
       $this->databaseObj->query="call entryInUserTable(?,?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('ssss',$firstname,$lastname,$emailid,$password);
        $this->databaseObj->stmt->execute();
   }
   function entryInPublisher($firstname, $lastname, $password, $email,$companyname){
       
       $this->databaseObj->query="call EntryInPublisherTable(?,?,?,?,?)";
        $this->databaseObj->stmt=$this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('sssss',$email,$password,$firstname,$lastname,$companyname);
        $this->databaseObj->stmt->execute();
   }
}
