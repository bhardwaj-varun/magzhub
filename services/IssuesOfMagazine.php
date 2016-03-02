<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
class IssuesOfMagazine{
    private $magazineId, $issueId ,$dboperationObj;
    function __construct() {
       $this->dboperationObj=new dboperation(); ;
    }
    function setMagazineId(){
        $this->magazineId=$_POST['MagazineId'];
    }
    function getMagazineId(){
      return  $this->magazineId;
    }
    function setIssueId(){
        $this->issueId=$_POST['issueId'];
    }
     function getIssueId(){
       return $this->issueId;
    }
    function getDifferentIssuesOfMagazine($magazineId, $userId, $issueId){
       
      $result=$this->dboperationObj->getDifferentIssuesOfMagazine($magazineId, $userId,$issueId);
      $length=  count($result);
      for($i=0;$i<$length;$i++)
      {
          $result[$i]['issueThumbnail']= $result[$i]['issueThumbnail'];
      }
      return $result;
    }
     function getFileIdOfIssue($issueId)
    {
        
        $result=$this->dboperationObj->getFileIdOfIssue($issueId);
        return $result;
    }
}
$Issues=new IssuesOfMagazine();
if(isset($_POST['MagazineId']))
{
    if($SessionObj->checkIssetSessionUserId())
    {
       
       $Issues->setMagazineId();
       $result= $Issues->getDifferentIssuesOfMagazine($Issues->getMagazineId(), $SessionObj->getSessionUserId(),$_POST['issueIdOfMag']);
       
       echo json_encode($result);
       
    }
}
else if(isset ($_POST['issueId'])){
    if($SessionObj->checkIssetSessionUserId())
    {
    $Issues->setIssueId();
     $fileId=$Issues->getFileIdOfIssue($Issues->getIssueId());
    
     if($fileId)
     {
         $fileUrl['url']="https://drive.google.com/file/d/".$fileId['fileId']."/preview?pli=1";
         echo json_encode($fileUrl);
     }
    }
     
 }

