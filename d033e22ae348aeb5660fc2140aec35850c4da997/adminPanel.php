<?php
require_once 'services/Session.php';
$SessionObj=new Session('Magzhub');
if(!$SessionObj->checkIssetSessionAdmin())
{
    $url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.html';
    header('Location: '.$url);;
}
?>
﻿<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Magzhub-Admin</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/offcanvas.css" rel="stylesheet" />
        <link href="css/round-about.css"rel="stylesheet"/>
        <!--[if lt IE 9]>
                            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
                    <![endif]-->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/view.css" rel="stylesheet">
    </head>
    <body>

        <!--navbar-->
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
                        <li><a id="message"></a>                          
                        </li>
                        <li><a id="logout" href="#">Logout</a></li>
                    </ul>

                </div>
            </div>
        </nav>
        <!--end nav bar-->
        
        
        <!--end  change password modal-->

        <!-- main container-->
        <div class="container-fluid">
            <!-- Off Canvas-->

            <div class="row row-offcanvas row-offcanvas-left">

                <div class="col-xs-12 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation" style=" height: 88vh;border-right:1px solid rgba(0, 0, 0, 0.3)">
                    <div class="list-group">
                        <a href="#" id="listInactiveUser" class="list-group-item active">Show Inactive Users</a>
                        
                    </div>
                </div>
                <!--magazine container-->
                <div  id="activateAllDiv"class="hide">
                    <button id="activateAll"> Activate All</button>
                <div class="" id="inactiveUser">
                    
                   <!-- <button> Activate All</button>
                    <p>Ruchira Upadhyay  <button>Activate</button> </p>
                    <p>Ruchira Upadhyay  <button>Activate</button> </p>
                    -->
                    
                </div>
                </div>
                
               


            </div>

            <!--end off canvas-->
        </div>
        <!-- end main container-->




        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/listInactiveUser.js"></script>
        <script src="js/logout.js"></script>
        <script src="js/view.js"></script>
        <script src="js/offcanvas.js"></script>
       
        <!-- script references -->
    </body>
</html>

