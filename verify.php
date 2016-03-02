<?php
require_once 'database/dbOperation.php';
class verify
{
    private $hash;
    function __construct() {
        ;
    }
    
    function setUrl(){
        $this->hash=$_GET['url'];
    }
    function getUrl(){
        return $this->hash;
    }
    
    function insertIntoUser($url)
    {
        $dboperationobj=new dboperation();
        $result=$dboperationobj->insertIntoUser($url);
        if($result['result']==1) 
        {
            ?>
            <html>
    <head>
        <title>Verify</title>
       
    </head>
    <body>
        <p>successfully verified. Please login</p>
        <a href="index.php"/>Go to Homepage</a>
    </body>
</html>
<?php
        }
        else {
             "";
            ?>

             <html>
    <head>
        <title>Verify</title>
       
    </head>
    <body>
        <p>Link expired. Please signup again</p>
        
    </body>
</html>
<?php
               }
    }
}
if(!empty($_GET['url']))
{
    $verifyobj=new verify();
    $verifyobj->setUrl();
    $verifyobj->insertIntoUser($verifyobj->getUrl());
    
}
?>

