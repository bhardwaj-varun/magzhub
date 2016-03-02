<?php
session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author radha
 */
class Session {
    //put your code here
    /**
     *
     * @var type private
     */
    
    function __construct($sessionName) {
        
        session_name($sessionName);
        
            
    }
    
 
     function setSessionAdmin($adminId){
        $_SESSION['adminId']=$adminId;
    }
     function getSessionAdmin($adminId){
       return $_SESSION['adminId'];
    }
    
    function getSessionName(){
        return session_name();
    }
    
     function checkIssetSessionAdmin(){
        return isset($_SESSION['adminId']);
    }
   
    function sessionDestroy(){
        session_destroy();
        $_SESSION=array();
        unset($_SESSION);
    }
    function __destruct() {
        ;
    }
}
