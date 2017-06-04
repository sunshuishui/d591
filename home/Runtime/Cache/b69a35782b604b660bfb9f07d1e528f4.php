<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>591客资管理系统</title>
<style>
body{margin:0;padding:0; font-size:12px;font-family:"Arial","微软雅黑","宋体",HELVETICA;background:#fff;_background-image: url(about:blank);_background-attachment: fixed; background:#ebeef1 }
form,ul,li,p,h1,h2,h3,h4,h5,h6{margin:0;padding:0;}input,select{font-size:12px;line-height:16px;}img{border:0;}ul,li{list-style-type:none;}
a{ text-decoration:none;}
.left_top{ height:50px; line-height:50px;}
.welcome a{ display:block; float:left; margin-right:10px; margin-bottom:10px; text-align:center; color:#fff;}
.wc{font-size:60px;line-height:150px;}
.welcome a img{ margin-top:38px;}
.welcome a:hover img{ -moz-animation:animations 1s ease-out forwards;-webkit-animation:animations 1s ease-out forwards;animation:animations 1s ease-out forwards;}
@keyframes animations{
	0%{transform:rotateY(0deg)}
	100%{transform:rotateY(360deg)}
}
@-moz-keyframes animations{
	0%{transform:rotateY(0deg)}
	100%{transform:rotateY(360deg)}
}
@-webkit-keyframes animations{
	0%{transform:rotateY(0deg)}
	100%{transform:rotateY(360deg)}
}
.z{ width:150px; height:150px;}
.c{ width:310px; height:150px;}
.zj{ font-size:20px;}
.zj p{ font-size:35px; padding-top:35px}
</style>
</head>

<body>
<div style="width:965px; height:320px; margin:75px auto 0 auto" class="welcome">
<a class="z wc" style="background-color:#90bb4f">W</a>
<a class="c wc" style="background-color:#f5c147">E&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;L</a>
<a class="z wc" style="background-color:#38bec9">C</a>
<a class="c wc" style="background-color:#e8687f">O&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M</a>
<a class="c zj" style="background-color:#5f7cb4"  title="总客资" href="<?php echo U('Member/index');?>"><p><?php echo ($a); ?></p>总客资</a>
<a class="z zj" style="background-color:#993f3e"  title="有效" href="<?php echo U('Member/index',array('state'=>1));?>"><p><?php echo ($b); ?></p>有效</a>
<a class="c zj" style="background-color:#48b5ee"  title="进店" href="<?php echo U('Member/index',array('state'=>1,'valid'=>2));?>"><p><?php echo ($c); ?></p>进店</a>
<a class="z zj" style="background-color:#af5ec5"  title="订单" href="<?php echo U('Member/index',array('state'=>1,'valid'=>3));?>"><p><?php echo ($d); ?></p>订单</a>
</body>
</html>