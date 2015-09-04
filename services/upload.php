<?php
require_once '/../database/database.php';
require_once '/../database/dbOperation.php';
$datbaseObj=new database();
class uploadNewIssueOfMagazine {
    function __construct() {
        ;
    }

function UploadIssue () 
{
if(isset($_FILES['filename']['name']))
{    
     
 $file = rand(1000,100000)."-".$_FILES['filename']['name'];
    $file_loc = $_FILES['filename']['tmp_name'];
 $file_size = $_FILES['filename']['size'];
 $file_type = $_FILES['filename']['type'];
 $folder="uploads/";
 
 
 // new file size in KB
 $new_size = $file_size/1024;  
 // new file size in KB
 
 // make file name in lower case
 $new_file_name = strtolower($file);
 // make file name in lower case
 
 $final_file=str_replace(' ','-',$new_file_name);
 $filepathName=$folder.$final_file;
 print 'ak';
 
 if(move_uploaded_file($file_loc,$folder.$final_file))
 {
   
  $dboperationObj=new dboperation();
  $dboperationObj->uploadIssue(1,$filepathName,$final_file);
  
  ?>
  <script>
  alert('successfully uploaded');
        
   </script>
  <?php
 }
 else
 {
  ?>
  <script>
  alert('error while uploading file');
       
        </script>
  <?php
 }
}
}
}
?>