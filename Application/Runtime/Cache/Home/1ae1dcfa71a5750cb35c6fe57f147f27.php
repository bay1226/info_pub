<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<title>Register</title>
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
<script type="text/javascript" src="/info_pub/Public/js/signup.js"></script>
</head>
<body id="login">
  <div class="login-logo">
    <img src="/info_pub/Public/images/logo.png" alt=""/>
  </div>
  <h2 class="form-heading">Register</h2>
  <div class="app-cam">
    <form method="post" action="/info_pub/index.php/Home/Signup/regist">
        <p>密码必须由字母数字组成，用户名，密码和电话长度小于20个字符，邮箱长度小于50个字符</p>
        <input id="regname" name="username" type="text" class="form-control1" placeholder="Username">
        <input id="regemail" name="mail" type="text" class="form-control1" placeholder="Email">
        <input id="regtel" name="tel" type="text" class="form-control1" placeholder="Tel">
        <input id="regpsw" name="password" type="password" class="form-control1" placeholder="Password">
        <input id="regrepsw" type="password" class="form-control1" placeholder="Re-type Password">
        
        <div class="submit"><input type="submit" onclick="return SignUp()" value="Sign Up"></div>
        <div class="registration">
            Already Registered.
            <a href="/info_pub/index.php/Home/Signup/login">
                Login
            </a>
        </div>
    </form>
  </div>
  <div class="copy_layout login">
      <p>Copyright &copy; 2016.BlingChat All rights reserved.</p>
  </div>
</body>
</html>