<?php
require_once 'services/Login.php';
require_once 'services/Session.php';

$SessionObj=new Session('Magzhub');
if(!$SessionObj->checkIssetSessionUserId())
{
    $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
    header('Location: '.$url);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Magzhub</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/custom final//bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/thumbnail-gallery.css" rel="stylesheet" />
    <link href="css/ajaxCss.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body style="overflow:hidden;">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="img/magz..jpeg" style="height:35px; margin-left: 20px; margin-top: -8px;"/></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
           <li><a id="message"></a></li>   
           <li><a href="index.php">Home</a></li>
           <li><a href="category.php">Category</a></li>
           <li><a href="#" id="logout">Logout</a></li>
          </ul>
          
        </div>
      </div>
</nav>

    <!-- Page Content -->
    <div id="innercontainer" class="container-fluid">
        
        <div id="row" class="row">
            <h1 id="header" class="col-sm-9 col-sm-offset-1 page-header text-center" style="padding-top: 40px;">CATEGORY</h1>
            <a id="backAnchor" href="category.php" class="col-sm-2 text-primary pull-right hide" style="padding-top: 100px;">Back to category</a>
            <div class="col-sm-10 col-sm-offset-1 container-main" id="containermain">
                    <div id="cotegoriesList"><img id="loadingImgCat"src="img/ajax-loader.gif" style="padding-left:200px;padding-top: 100px;"class="hide"></img></div>
                    <div id="issuesList"> <img id="loadingImg"src="img/ajax-loader.gif" style="padding-left:200px;padding-top: 100px;"class="hide"></img></div> 
            </div>
            
        </div>


        <!-- Footer 
        <footer>
            <div class="row">
                <div
                class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>
            -->
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/category.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/logout.js"></script>
    <script src="js/showMessage.js"></script>
    <script src="js/readPdf.js"></script>
</body>

</html>
