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
    /**
     * 
     */
       
    function setSessionUserId($userid){
        
        $_SESSION['userId']=$userid;
    }
    
    function setSessionPublisherId($publisherId){
        $_SESSION['publisherId']=$publisherId;
    }
    function setSessionIssueIdPublisher($issueId){
        $_SESSION['issueIdPublisher']=$issueId;
    }
     function setSessionAdmin($adminId){
        $_SESSION['adminId']=$adminId;
    }
    function getSessionIssueIdPublisher(){
        return $_SESSION['issueIdPublisher'];
    }
    function getSessionUserId(){
        return $_SESSION['userId'];
    }
    function getSessionPublisherId(){
        return $_SESSION['publisherId'];
    }
    function getSessionName(){
        return session_name();
    }
    function checkIssetSessionUserId(){
        return isset($_SESSION['userId']);
    }
      function checkIssetSessionPublisherId(){
        return isset($_SESSION['publisherId']);
    }
     function checkIssetSessionAdmin(){
        return isset($_SESSION['adminId']);
    }
    function getSessionAdmin($adminId){
       return $_SESSION['adminId'];
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
