<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassAuthenticateExistingPublisher
 *
 * @author radha
 */
require_once '../database/dbOperation.php';

class ClassAuthenticateExistingPublisher {
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
    function authenticatePublisher($email,$passwd){
        $result=$this->dbOperationObj->validatePublisher($email, $passwd);
        return  $result;
                
    }
}
