<?php

require_once '../database/dbOperation.php';

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$password="magzhub@123";
$companyname=$_POST['companyname'];
$dboperationObj=new dboperation();
$dboperationObj->entryInPublisher($firstname, $lastname, $password, $email,$companyname);
echo "Entry Submitted";

