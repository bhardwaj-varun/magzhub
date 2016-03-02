<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');
class DisplayPublisherMagazine{
   private $dbOpertionObj;
    function __construct() {
        $this->dbOpertionObj=new dboperation();
    }
    
    function listMagazineThumbnailPublisher ($isPublisherAlive,$publisherId,$magazineId){
        $result=null;
        if($isPublisherAlive)
        {
        $result=$this->dbOpertionObj->DisplayPublisherMagazine($publisherId,$magazineId);
       /* $length=  count($result);
       
        for ($i=0;$i<$length;$i++)
            $result[$i]['magazineThumbnail']=  base64_encode($result[$i]['magazineThumbnail']);*/
        }
        return $result;
    }
    
    
}
$displayPublisherMagazine=new DisplayPublisherMagazine();
$listMagazine=$displayPublisherMagazine->listMagazineThumbnailPublisher ($SessionObj->checkIssetSessionPublisherId(),$SessionObj->getSessionPublisherId(),$_POST['magId']);

echo json_encode($listMagazine);


?>