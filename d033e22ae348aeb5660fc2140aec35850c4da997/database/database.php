<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author radha
 */
require_once 'databaseInfo.php';
class database extends mysqli implements databaseInfo {
    //put your code here
    public $query,$stmt,$res,$row,$tempres,$temprow,$rows;
    
    public function __construct() {
         parent::connect(databaseInfo::db_hostname, databaseInfo::db_username,  databaseInfo::db_password, databaseInfo::db_database);
    }
    
    public function __destruct() {
        parent::close();
    }
}
