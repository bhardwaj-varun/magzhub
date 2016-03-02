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
}
