<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<title>登录</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="/info_pub/Public/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="/info_pub/Public/css/style.css" rel='stylesheet' type='text/css' />
<link href="/info_pub/Public/css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="/info_pub/Public/js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="/info_pub/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/info_pub/Public/js/login.js"></script>
</head>
<body id="login">
  <div class="login-logo">
    <img src="/info_pub/Public/images/logo.png" alt=""/>
  </div>
  <h2 class="form-heading">login</h2>
  <div class="app-cam">
	  <form method="post" action="/info_pub/index.php/Home/Login/verify">
        <input id="loginname" name="username" type="text" class="form-control1" placeholder="Username">
        <input id="loginpsw" name="password" type="password" class="form-control1" placeholder="Password">
		    <div class="submit"><input type="submit" onclick="return Login()" value="Login"></div>
		
    		<ul class="new">
    			<li class="new_left"><p><a href="#" onclick="FindPsw()">Forgot Password ?</a></p></li>
    			<li class="new_right"><p class="sign">New here ?<a href="/info_pub/index.php/Home/Login/signup"> Sign Up</a></p></li>
    			<div class="clearfix"></div>
    		</ul>
	</form>
  </div>
   <div class="copy_layout login">
      <p>Copyright &copy; 2016.Software All rights reserved.</p>
   </div>
</body>
</html>