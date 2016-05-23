<?php
require_once 'services/Session.php';
require_once 'services/Login.php';
$SessionObj=new Session('Magzhub');
if(!$SessionObj->checkIssetSessionPublisherId())
{
    $url='https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'index.php';
    header('Location: '.$url);;
}
?>
﻿<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Magzhub</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="css/custom final/bootstrap.min.css" rel="stylesheet">
        <link href="css/offcanvas.css" rel="stylesheet" />
        <link href="css/sweetalert.css" rel="stylesheet"/>
        <!--[if lt IE 9]>
                            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
                    <![endif]-->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/publisherDashboard/view.css" rel="stylesheet">
    </head>
    <body>
        <?php include_once("analyticstracking.php") ?>
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
        <!--read Pdf File-->
        <div class="modal fade " id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content ">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>  
      
        <div class="modal-body" style="height: 83vh;">
        
         <iframe id="ifrm" src="about:blank" style=" position:fixed;  left:0px; right:0px;width:100%; height:450%;  border:none; margin:0;margin-top: -15px;  padding:0; overflow:hidden; z-index:999999; " ></iframe>
        </div>
        <div class="modal-footer">
         <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        </div>
      </div>
      
    </div>
  </div>
        <!--End read pdf File-->
        <!-- change password modal-->
        <div id="password" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    
                    <div class="modal-body">
                         <div class="well bs-component">
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                             <fieldset>
                                 <legend>Change Password</legend>
                        <form id="changePass" name="changePass"  method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                                <div class="form-group">
                                    <label for="oldPassword" class="col-lg-2 control-label">Old&nbsp;Password</label>
                                    <div class="col-lg-offset-1 col-sm-9" >
                                        <input type="password" name="oldPassword" class="form-control" id="oldPassword" placeholder="Old Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword" class="col-lg-2 control-label">New&nbsp;Password</label>
                                    <div class="col-lg-offset-1 col-sm-9" >
                                        <input  type="password"  name="newPassword" class="form-control" id="newPassword" placeholder="New Password" >
                                    </div>
                                </div>
                            <div class="form-group">
                                    <label for="reenterPassoword" class="col-lg-2 control-label">Reenter&nbsp;Password</label>
                                    <div class="col-lg-offset-1 col-sm-9" >
                                        <input type="password" name="reenterPassword" class="form-control" id="reenterPassword" placeholder="Re-Enter New Password">
                                    </div>
                                </div>
                             <div class="form-group">
                                    <div class="col-lg-8 col-lg-offset-3 ">
                                        <p id="passwordMessage" class="text-success"></p>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input id="changePasswordSubmit" class="btn btn-primary pull-right" type="submit" name="submit" value="Submit" />
                                    </div>
                                </div>
                        </form>
                             </fieldset>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!--end  change password modal-->

        <!-- main container-->
        <div class="container-fluid">
            <!-- Off Canvas-->

            <div class="row row-offcanvas row-offcanvas-left">

                <div class="col-xs-12 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation" style=" height: 88vh;border-right:1px solid rgba(0, 0, 0, 0.3)">
                    <div class="list-group">
                        <a href="#" id="myMagazine" class="list-group-item active">My Magazines</a>
                        <a href="#" id="addMag" class="list-group-item">Add Magazine</a>
                        <a href="#" id="addIssue" class="list-group-item">Add Issue</a>
                        <a href="#" id="changePassword" class="list-group-item">Change Password</a>
                        <a href="#" id="subscriptionStatus" class="list-group-item">Subscription Statistics</a>
                    </div>
                </div>
                <!--magazine container-->
                
                <div id="magazineContainer" class="col-sm-9  container-main" style="margin-left: 50px;"  >
                    <!-- div magazine--> 
                    <div id="magazinelist" class="row placeholders"><img id="loadingImg"src="img/ajax-loader.gif" style="padding-left:43%;padding-top: 12%;"class="hide"></img></div>
                    <!-- end div magazine-->
                </div>
                <!-- end magazine container-->
                <!-- upload file -->
                <div id="divAddIssuePdf" class="col-lg-4 div-issue-upload-form hide">
                    <div class="well bs-component">
                        <form name="form1" onsubmit="return uploadFile();" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <fieldset>
                                <legend>Upload File</legend>
                                <div class="form-group">
                                    <label for="progressNumber" class="col-lg-2 control-label">Progress</label>
                                    <div class="col-lg-10">
                                        <div id="progressNumber" style='position: absolute; z-index: 2; margin-top: 7px; left: 2;' name="progressName"></div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="file" class="col-lg-2 control-label">File</label>
                                    <div class="col-lg-10">
                                        <span class="btn btn-primary btn-sm">Choose File
                                            <input type="file" id="file" style='position: absolute; z-index: 2; top: 0; left: 0; filter: alpha(opacity=0); -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; opacity: 0; background-color: transparent; color: transparent;' accept="application/pdf"   onchange='fileName();
                                                            uploadchange();' multiple name="uploads[]" >
                                        </span>
                                        &nbsp;<span class='label label-primary' id="upload-file-info"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <div id="uploadlist" class="hide"></div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
 
                        <p id='instruction'><strong>Instructions</strong><br>*Please first upload the pdf file<br>*Then fill the issue details form and submit</p>
                    </div>
                </div>
               
                <!-- end upload file -->
                <!-- Add Issue-->
                <div id="divAddIssueDetails"class="col-lg-6 div-issue-upload-form hide">
                    <div class="well bs-component">
                        <form id="addIssueForm" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <fieldset>
                                <legend>Issue Details</legend>
                                <div class="form-group">
                                    <label for="element_3" class="col-lg-2 control-label">Category</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="CatListInissue" name="element_3">
                                            <option value="" selected="selected"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="magazineList" class="col-lg-2 control-label">Magazines</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="magazineList" name="magazineId">
                                            <option value="" selected="selected" ></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="IssueName" class="col-lg-2 control-label">Issue</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="issueName" placeholder="Issue Name" name="issueName" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-lg-2 control-label">Description</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" rows="3" id="textAreaDes" name="Description" placeholder="Description" ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="element_2" class="col-lg-2 control-label">Thumbnail</label>
                                    <div class="col-lg-10">
                                        <span class="btn btn-primary btn-sm">Choose File 
                                            <input type="file" id="addIssueImage" name="file" style='position: absolute; z-index: 2; top: 0; left: 0; filter: alpha(opacity=0); -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; opacity: 0; background-color: transparent; color: transparent;'  onchange='thumbnailUpload ();'/>
                                       </span>
                                        &nbsp;<span class='label label-primary' id="thumbnail-info"></span>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input id="buttonAddNewIssue" class="btn btn-primary" type="submit" name="submit" value="Submit" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8 col-lg-offset-2 ">
                                        <p id="issueSuccess" class="text-success "></p>
                                    </div>
                            </div>
                            </fieldset>
                        </form>
                        <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
                    </div>
                </div>
                <!-- end Add Issue-->
                <!--Add magazine-->
                <div class="col-lg-6 hide" id="addMagDiv">
                    <div class="well bs-component">
                        <form id="data" enctype="multipart/form-data" method="post" class="form-horizontal">
                            <fieldset>
                                <legend>Add Magazine</legend>
                                <div class="form-group">
                                    <label for="catList" class="col-lg-2 control-label">Category</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="catList" name="categoryId">
                                            <option value="" selected="selected"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newMagazine" class="col-lg-2 control-label">Magazines</label>
                                    <div class="col-lg-10">
                                        <input id="newMagazine" name="newMagazine" class="form-control" type="text"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="textArea" class="col-lg-2 control-label">Description</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" rows="3" id="textAreaMag" name="Description" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="magazineFrequency" class="col-lg-2 control-label">Frequency</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" id="magazineFrequency" name="magazineFrequency">
                                            <option value="" selected="selected">Frequency</option>
                                            <option value="SEMI-WEEKLY">SEMI-WEEKLY</option>
                                            <option value="WEEKLY">WEEKLY</option>
                                            <option value="FORTNIGHTLY">FORTNIGHTLY</option>
                                            <option value="MONTHLY">MONTHLY</option>
                                            <option value="45 DAYS">45 DAYS</option>
                                            <option value="BI-MONTHLY">BI-MONTHLY</option>
                                            <option value="QUATERLY">QUATERLY</option>
                                            <option value="HALF-YEARLY">HALF-YEARLY</option>
                                            <option value="ANNUALLY">ANNUALLY</option>
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <input id="buttonAddNewMagazine" class="btn btn-primary" type="submit" name="submit" value="Submit" />

                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="col-lg-8 col-lg-offset-2 ">
                                        <p id="addMagSuccess" class="text-success "></p>
                                    </div>
                            </div>
                            </fieldset>
                        </form>
                        <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
                    </div>
                </div>
                <!-- end Add Magazine-->
                <!-- Subscription stats-->
                <div id="divSubscriptionStat" class="col-lg-10 hide">
                   
                    <div class="col-lg-4">
                        <select id="listOfMagazines"  class="form-control">
                         <option value="" selected="selected">Magazines</option>   
                        </select>
                    </div>
                    <button  id="fetchListOfMagazines" class="btn btn-sm btn-primary">Go</button>
                    <div class="col-lg-9">
                    <img id="loadingImgInStats"src="img/ajax-loader.gif" style="padding-left:55%;padding-top: 12%;"class="hide"></img>
                    </div>
                    <div id="divCanvas" class="col-lg-offset-2 col-lg-8" style="margin-top:15vh;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <!--end susbscription stats-->

            </div>

            <!--end off canvas-->
        </div>
        <!-- end main container-->




        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/publisherDashboard/view.js"></script>
        <script src="js/uploadbigfile.js"></script>
        <script src="js/offcanvas.js"></script>
        <script src="js/logout.js"></script>
        <script src="js/readPdf.js"></script>
        <script src='js/showMessage.js'></script>
        <script src="js/publisherDashBoard.js"></script>
        <script src="js/jquery.nicescroll.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.0.0/Chart.js"></script>
        <script src="js/sweetalert.min.js"></script>
        <!-- script references -->
    </body>
</html>
