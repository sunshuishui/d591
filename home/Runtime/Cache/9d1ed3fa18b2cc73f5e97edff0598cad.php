<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>591客资管理系统</title>
<meta name="author" content="DeathGhost">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/loginstyle.css" tppabs="css/loginstyle.css" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="__PUBLIC__/js/jquery-1.11.0.min.js"></script>
<script src="__PUBLIC__/js/Particleground.js" tppabs="__PUBLIC__/js/Particleground.js"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
  $('body').particleground({
    dotColor: '#5cbdaa',
    lineColor: '#5cbdaa'
  });
});
</script>
</head>
<body><canvas class="pg-canvas" width="1920" height="934"></canvas>
<form method="post" action="__URL__/dologin">
<dl class="admin_login">
 <dt>
  <strong>591客资管理系统</strong>
  <em>Management System Of 591</em>
 </dt>
 <dd class="user_icon">
  <input type="text" placeholder="账号" class="login_txtbx" name="username" maxlength="20" required="required" />
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" class="login_txtbx" name="password" maxlength="20" required="required" />
 </dd>
 <dd class="val_icon">
  <div class="checkcode">
    <input type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx" name="yzcode"  required="required"/>
  </div>
  <img src="__URL__/verify" onclick="this.src+='?'+ Math.random();" />
 </dd>
 <dd>
  <input type="submit" value="立即登陆" class="submit_btn">
 </dd>
 <dd>
  <p>©2017 591版权所有</p>
  <p>591客资管理系统内测版v1.1</p>
 </dd>
</dl>
</form>

</body>
</html>