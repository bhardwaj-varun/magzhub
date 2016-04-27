<?php
require_once '../database/dbOperation.php';

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$password=  sha1("magzhub@123");
$dboperationObj=new dboperation();
$dboperationObj->entryInUser($firstname, $lastname, $password, $email);
echo "Entry Submitted";



