<?php
require_once '../database/dbOperation.php';
require_once 'Session.php';
$SessionObj=new Session('Magzhub');


$target_path = "uploads/";
$tmp_name = $_FILES['file']['tmp_name'];
$size = $_FILES['file']['size'];
$name = $_FILES['file']['name'];
$name2 = $_GET['filename'];
$size1=$_GET['SIZE'];

$target_file = $target_path.$name;


$complete =$target_path.$name2;
$com = fopen($complete, "ab");
error_log($target_path);




// Open temp file
//$out = fopen($target_file, "wb");

//if ( $out ) {
    // Read binary input stream and append it to temp file
    $in = fopen($tmp_name, "rb");
    if ( $in ) {
        while ( $buff = fread( $in, 524288 ) ) {
           // fwrite($out, $buff);
            fwrite($com, $buff);
        }   
    }
    
    fclose($in);
    
    
//}
//fclose($out);
fclose($com);
$sizecom= filesize($complete);

if($size1==filesize($complete))
    {
    $newFileName=  rand(1000,100000)."-".$name2;
    rename($complete, $target_path.$newFileName);
    $dboperationObj=new dboperation();
    $dboperationObj->uploadBigFilePathIssue($target_path.$newFileName,$newFileName);
    $dboperationObjIssuesId=new dboperation();
    $result= $dboperationObjIssuesId->getIssueIdForInsertingDetails($target_path.$newFileName);
    $SessionObj->setSessionIssueIdPublisher($result['issueId']);
      
   }


?>