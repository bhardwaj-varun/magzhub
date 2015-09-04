<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
require_once 'ImageManipulator.php';
$SessionObj=new Session('Magzhub');
    

Class Publisher{
    private $categoryName,$magazineName,$categoryId,$magazineId,$issueDescription,$issueName;
    function __construct() {
        ;
    }
    
    function setCategoryName(){
        $this->categoryName=$_POST['categoryName'];
    }
     function setMagazineName(){
        $this->magazineName=$_POST['newMagazine'];
        
    }
    function setCategoryId(){
        $this->categoryId=$_POST['categoryId'];
    }
    function setMagazineId(){
        $this->magazineId=$_POST['magazineId'];
    }
    function setIssueDescription(){
        $this->issueDescription=$_POST['Description'];
    }
    function setIssueName(){
        $this->issueName=$_POST['issueName'];
    }
    function getCategoryName(){
        return $this->categoryName;
    }
    function getMagazineName(){
        return $this->magazineName;
    }
    function getCategoryId(){
        return $this->categoryId;
    }
    function getMagazineId(){
        return $this->magazineId;
    }
    function getIssueDescription(){
        return $this->issueDescription;
    }
    function getIssueName(){
       return $this->issueName;
    }
            
    
    
    function addCategory($categoryName){
        $addCategoryObj=new dboperation();
        $addCategoryObj->addCategory($categoryName);
        
    }
   
    function addMagazine($magazineName,$categoryId,$publisherId,$description,$magazineFrequency){
        $addMagazineObj=new dboperation();
        $addMagazineObj->addMagazine($magazineName,$categoryId,$publisherId,$description,$magazineFrequency);
    }
    function addIssue($magazinename)
    {
        $addIssueObj=new dboperation();
        $addIssueObj->addIssue($magazinename);
    }
    function changePassword($publisherId,$oldPassword,$newPassword)
    {
        $dboperationObj=new dboperation();
       $result= $dboperationObj->changePasswordPublisher($publisherId, $newPassword, $oldPassword);
       return $result;
    }
    function uploadIssue($magazineId,$issueDescription,$issueName,$issueId)
    {
      
        if(isset($_FILES['file']['name']))
            
   {    
     
 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 $validExtensions = array('.jpg', '.jpeg', '.png','.JPG', '.JPEG', '.PNG');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['file']['name'], ".");
    if (in_array($fileExtension, $validExtensions)) {
 
 
 // new file size in KB
 $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 
 $final_file=str_replace(' ','-',$new_file_name);
 $filepathName=$folder.$final_file;
 
    if(move_uploaded_file($file_loc,$folder.$final_file))
    {
          $manipulator = new ImageManipulator($folder.$final_file);
        // resizing to 200x200
        $newImage = $manipulator->resample(200, 250);
        // saving file to uploads folder
        $manipulator->save('uploads/'.$file);
        $imgData= base64_encode(file_get_contents('uploads/'.$file));
         $dboperationObj=new dboperation();
         $dboperationObj->uploadIssue($magazineId,$issueDescription,$issueName,$imgData,$issueId);
         $result['message']='uploaded Succesfully';
         echo json_encode($result) ;
         
  
    }
    else
    {
        $result['message']='error in move';
         echo json_encode($result) ;
         
    }
    }
    else
    {
        $result['message']='Invalid Image format';
         echo json_encode($result) ;
    }
         
       
}
else{
    $result['message']='error in file upload';
         echo json_encode($result) ;
         
  
}
    }
    
}
$publisherObj=new Publisher();
    
if(isset($_POST['categoryName']))
{
    echo $_POST['CategoryName'];
$publisherObj->setCategoryName();
$publisherObj->addCategory($publisherObj->getCategoryName());
}
else if(isset($_POST['newMagazine']) && isset($_POST['categoryId']) && isset($_POST['Description']) && isset($_POST['magazineFrequency']))
{
     
    if($SessionObj->checkIssetSessionPublisherId())
   {
    $publisherId=$SessionObj->getSessionPublisherId();
    print_r($publisherId);
    $publisherObj->setMagazineName();
    $publisherObj->setCategoryId();
    $publisherObj->addMagazine($publisherObj->getMagazineName(),$publisherObj->getCategoryId(),$publisherId,$_POST['Description'],$_POST['magazineFrequency']);
   }
    else
    {
        echo null;
    }

 }

else if(isset($_POST['magazineId']) && isset($_FILES['file']['name']) && isset ($_POST['Description']) &&isset ($_POST['issueName']) )
{
   
    $publisherObj->setMagazineId();
    $publisherObj->setIssueDescription();
    $publisherObj->setIssueName();
    $issueId=$SessionObj->getSessionIssueIdPublisher();
    $publisherObj->uploadIssue($publisherObj->getMagazineId(),$publisherObj->getIssueDescription(),$publisherObj->getIssueName(),$issueId);
    $SessionObj->setSessionIssueIdPublisher(NULL);
   
}
else if(isset ($_POST['oldPassword']) && isset ($_POST['newPassword']))
{
    if($SessionObj->checkIssetSessionPublisherId())
    {
    $resultPassword=$publisherObj->changePassword($SessionObj->getSessionPublisherId(), $_POST['oldPassword'], $_POST['newPassword']);
        if($resultPassword['result'])
            echo 'Password updated Successfully';
        else
            echo 'Password is Incorrect';
            
    }
}


?>