<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author radha
 */

class Login {
    //put your code here
    private $loginStatus;
    
    public function __construct() {
        $this->loginStatus=false;
    }
    
    public function checkLoginStatus($loginStatus){
       $this->loginStatus= ($loginStatus==true)?true:false;
            
        return $this->loginStatus;
    }
    
}
