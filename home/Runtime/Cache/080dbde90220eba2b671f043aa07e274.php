<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台登录</title>
<meta name="author" content="DeathGhost">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/fkstyles.css" tppabs="css/loginstyle.css" />
<script src="__PUBLIC__/js/jquery-1.11.0.min.js"></script>
<script>
function chk(){
	if($('#username').val()=='' || $('#password').val()=='' || $('#yzcode').val()==''){
		alert('请填写必选信息！');
		return false;
	}	
	return true;
}
</script>
</head>
<body>
<div class="htmleaf-container">
	<div class="wrapper">
		<div class="container">
			<h1>客资系统</h1>
			<form class="form" action="__URL__/dologin" method="post" onsubmit="return chk();">
				<input name="username" id="username" maxlength="20" required="required" placeholder="用户名">
				<input type="password" id="password" placeholder="密码" class="login_txtbx" name="password" maxlength="20" required="required">
                <input type="text" id="yzcode" placeholder="验证码" maxlength="4" class="login_txtbx" name="yzcode"  required="required" style="width:160px;float:left"/><img src="__URL__/verify" onclick="this.src+='?'+ Math.random();" style="float:right" />
				<button type="submit" id="login-button">立即登陆</button>
			</form>
		</div>
		
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
            <li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>
</body>
</html>