<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of authenticateExistingUser
 *
 * @author radha
 */

/*
 * require /database/dboperation.php
 */
require_once '../database/dbOperation.php';
class ClassAuthenticateExistingUser {
    //put your code here
    /**
     *
     * @var type private 
     */
    private $email,$passwd,$dbOperationObj;
    
    /**
     * creating an object of dboperation class
     */
    function __construct() {
        $this->dbOperationObj=new dboperation(); 
    }
    /**
     * method authenticateUser calling validateUser of dbOperation class 
     * @param type $email
     * @param type $passwd
     * @return type array()
     */
    function authenticateUser($email,$passwd){
        $this->email=$email;
        $this->passwd=$passwd;
        $result=$this->dbOperationObj->validateUser($this->email, $this->passwd);
        return  $result;
                
    }
 
}
?>