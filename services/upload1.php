<?php
require_once '/../database/database.php';
require_once '/../database/dbOperation.php';
//$datbaseObj=new database();
//print_r($_POST);
//print_r($_FILES);
if(isset($_FILES['file']['name']))
{    
     
 $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="uploads/";
 
 
 // new file size in KB
 $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 
 $final_file=str_replace(' ','-',$new_file_name);
 $filepathName=$folder.$final_file;
 
    if(move_uploaded_file($file_loc,$folder.$final_file))
    {
            print'uploaded';    
         //$dboperationObj=new dboperation();
        // $dboperationObj->uploadIssue(1,$filepathName,$final_file);
  
    }
    else
    {
         echo 'error in move';
    }

}
else{
    echo 'error in file upload';
}
?>