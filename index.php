<?php

require_once 'services/Session.php';
require_once 'services/Login.php';
$SessionObj=new Session('Magzhub');
$url='https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'';
$loginObj=new Login();
$userLoginStatus=$loginObj->checkLoginStatus($SessionObj->checkIssetSessionUserId());
$publisherLoginStatus=$loginObj->checkLoginStatus($SessionObj->checkIssetSessionPublisherId());

if($userLoginStatus){
   header('Location: '.$url."userDashboard.php");;
}
else if($publisherLoginStatus){
    header('Location: '.$url.'publisherDashboard.php');
}

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Magzhub</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/index/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/index/userlogin.css" />

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/index/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/index/creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">
    <?php include_once("analyticstracking.php") ?>
    

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"><img src="img/rsz_mainlogo.png" style="margin:-9px; margin-left:5px;" class="im"/></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Features</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#portfolio">Featured</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li class="visible-xs-inline-block">
                        <div>
                            <form class="form" role="form" accept-charset="UTF-8">
                                            <div class="form-group visible-xs-inline-block">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control" id="publisheremailsmall" placeholder="Email address" required>
                                            </div>
                                            <div class="form-group visible-xs-inline-block">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control" id="publisherpasswordsmall" placeholder="Password" required>
                                            </div>
                                            <div class="form-group visible-xs-inline-block">
                                                
                                                <button id="publishersubmitsmall" class="btn btn-primary btn-block">Publisher Login</button>
                                                
                                            </div>
                                            <div class="form-group visible-xs-inline-block">
                                               &nbsp; <span id="publisherwrongsmall" class="text-danger small"></span>
                                            </div>
                            </form>
                        </div>
                     </li>
                     <li class="visible-xs-inline-block">
                         <div>
                             <form class="form" role="form" id="userlogin" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group visible-xs-inline-block">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control" id="useremailsmall" placeholder="Email address" required>
                                            </div>
                                            <div class="form-group visible-xs-inline-block">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control" id="userpasswordsmall" placeholder="Password" required>
                                               
                                            </div>
                                            <div class="form-group visible-xs-inline-block">
                                                <button id="userbuttonsmall" class="btn btn-primary btn-block">User Login</button>
                                                 <a href="#myModal" data-toggle="modal" data-target="#myModal">Signup</a>
                                                 
                                               
                                            </div>
                                            <div class="form-group visible-xs-inline-block">
                                               &nbsp; <span id="userwrongsmall" class="text-danger small"></span>
                                            </div>
                                          
                                        </form>
                             
                         </div>
                     </li>
                    <li class="dropdown hidden-xs">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Publisher</b> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!--
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
								</div>
                                -->
                                        <form class="form" role="form" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control" id="publisheremail" placeholder="Email address" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control" id="publisherpassword" placeholder="Password" required>
                                                
                                            </div>
                                            <div class="form-group">
                                                <button id="publishersubmit" class="btn btn-primary btn-block">Sign in</button>
                                                
                                            </div>
                                             <div class="form-group">
                                               &nbsp; <span id="publisherwrong" class=" text-danger"></span>
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <!--<div class="bottom text-center">
								New here ? <a href="#"><b>Join Us</b></a>
							</div>-->
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li class="dropdown hidden-xs">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>User</b> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu ">
                            <li>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!--
								<div class="social-buttons">
									<a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
									<a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
								</div>
                                -->
                                        <form class="form" role="form" id="userlogin" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control" id="useremail" placeholder="Email address" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control" id="userpassword" placeholder="Password" required>
                                               
                                            </div>
                                            <div class="form-group">
                                                <button id="userbutton" class="btn btn-primary btn-block">Sign in</button>
                                                <a href="#myModal" data-toggle="modal" data-target="#myModal">Signup</a>
                                                <a href="#myModal1" data-toggle="modal" data-target="#myModal1" class="text-right">forgot password</a>
                                               
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<span id="userwrong" class="wrong text-danger"></span>
                                            </div>
                                           
                                        </form>
                                    </div>
                                    <!--<div class="bottom text-center">
								New here ? <a href="#"><b>Join Us</b></a>
							</div>-->
                                </div>
                            </li>
                        </ul>
                    </li>


                </ul>


            </div>
            
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <br><br><br><br>
                <h1>Boost your preperation </h1>
                <h1>Education = Future </h1>
                <br><br><br><br><br><br><br>
                <hr>
                
                <h4>Now get all your books and magazines at <strong> Magzhub</strong> save more than Rs 500 per month.</h4>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">Find Out More</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">We've got what you need!</h2>
                    <hr class="light">
                    <p class="text-faded">Magzhub was started to create a seamless way to read books and magazines for users, along with a more cost effective platform for publishers to serve these reader.</p>
                    <a href="#" class="btn btn-default btn-xl">Get Started!</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary"></i>
                        <h3>Read at your convenience</h3>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3>Available 24X7</h3>
                      
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3>Right in your pocket</h3>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <h3>Progressive downloading</h3>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding" id="portfolio">
       
        <div class="container-fluid">
            <div class="row no-gutter">
                
                <div class="col-lg-2 col-sm-6">
                    
                        <img src="img/Images/1.png" class="img-responsive" alt="">
                    
                </div>
                
                <div class="col-lg-2 col-sm-6">
                    
                        <img src="img/Images/4.png" class="img-responsive" alt="">
                        
                </div>
                
                <div class="col-lg-2 col-sm-6">
                   
                        <img src="img/Images/2.png" class="img-responsive" alt="">
                        
                </div>
                 
                <div class="col-lg-2 col-sm-6">
                   
                        <img src="img/Images/5.png" class="img-responsive" alt="">
                        
                </div>
                <div class="col-lg-2 col-sm-6">
                    
                        <img src="img/Images/3.png" class="img-responsive" alt="">
                        
                </div>
                <div class="col-lg-2 col-sm-6">
                    
                        <img src="img/Images/6.png" class="img-responsive" alt="">
                        
                       
                </div>
        
            </div>
            </div>
            
    
    </section>

     <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2> Zero wait, Zero weight</h2>
                <a href="#" class="btn btn-default btn-xl wow tada">Get Started!</a>
            </div>
        </div>
    </aside>


    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x wow bounceIn"></i>
                    <p>+91-9044798748</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="mailto:contact@magzhub.com">contact@magzhub.com</a></p>
                    
                </div>
            </div>
        </div>
         
    </section>
<div class="col-sm-9 col-sm-offset-3">    
<ul class="nav navbar-nav navbar-left">
                    <li>
                        <a class="page-scroll" href="aboutUs.html">About Us</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="privacyPolicy.html">Privacy Policy</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="faq.html">FAQ</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="termsAndConditions.html">Terms And Conditions</a>
                    </li>
                     <li>
                         <a class="page-scroll" href="publishingAgreement.html">Publisher Agreement</a>
                    </li>
</ul>
</div>
    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Signup</h4>
      </div>
      <div class="modal-body">
          <form class="form" role="form" id="userSignup" accept-charset="UTF-8" id="login-nav" method="post">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Firstname</label>
                                                <input type="text" class="form-control" id="firstname" placeholder="Firstname" name="firstName" required>
                                               
                                            </div>
                                                <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Lastname</label>
                                                <input type="text" class="form-control" id="lastname" placeholder="Lastname" name="lastName" required>
                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Email address</label>
                                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Re-enter Password</label>
                                                <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Re-enter Password" required>
                                               
                                            </div>
                                            <div class="form-group">
                                                <input id="submitSignup" type="submit" value="Sign up" class="btn btn-primary btn-block"/>
                                                <p id="signupMessage"></p>
                                                
                                               
                                            </div>
                                            <div class="form-group">
                                                &nbsp;<span id="userwrong" class="wrong text-danger"></span>
                                            </div>
                                           
                                        </form>
      </div>
      
    </div>

  </div>
</div>
    <div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Forgot password</h4>
      </div>
      <div class="modal-body">
       <div class="form-group">
              
                <input type="text" class="form-control" id="forgetEmail" name="email" placeholder="enter your Email" required>
                                               
               <div>
                 <div class="form-group">
                   <input id="submitEmail" type="submit" value="submit" class="btn btn-primary btn-block"/>
                    <p id="fogetPasswordMsg"></p>                    
                     </div>
                   <div class="form-group">
                        &nbsp;<span id="forgetPasswor" class="wrong text-danger"></span>
                       </div>
      </div>
    </div>

  </div>
</div>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/index/jquery.easing.min.js"></script>
    <script src="js/index/jquery.fittext.js"></script>
    <script src="js/index/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/index/creative.js"></script>
    <script src="js/login.js"></script>
    <script src="js/jquery.jcarousellite.js"></script>
    <script src="js/signup.js"></script>
    

</body>

</html>
