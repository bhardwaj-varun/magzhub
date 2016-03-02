<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CLassCategory
 *
 * @author radha
 */
require_once 'Session.php';
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
class ClassCategory {
    //put your code here
   private  $sessionObj,$dbOperationObj;
    function __construct() {
    //    $this->sessionObj=new Session();
    $this->dbOperationObj=new dboperation();
   
    }
    function __destruct() {
        ;
    }
    function ListCategories(){
        return $this->dbOperationObj->ListCategories();
    }
   
    function listThumbnailForCategories(){
    $dboperationObj=new dboperation();
    return $dboperationObj->listThumbnailForCategories();
    }
}
    if($SessionObj->checkIssetSessionUserId() || $SessionObj->checkIssetSessionPublisherId()){
    $categoryObj=new ClassCategory();
    $result=$categoryObj->ListCategories();
    $resultForThumbnail=$categoryObj->listThumbnailForCategories();
     $lenght=count($resultForThumbnail);
     for($i=0;$i<$lenght;$i++)
     {
         $result[$i]['thumbnail']=base64_encode( $resultForThumbnail[$i]['thumbnail'] );
     }
     //echo '<img src="data:image/jpeg;base64,'.base64_encode( $resultForThumbnail[1]['thumbnail'] ).'"/>';
    echo json_encode($result);
}

else{
     $page='index.html';
   $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/../';
        header('Location: '.url.$page);
}