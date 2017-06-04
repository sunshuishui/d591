<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style>
body{margin:0;padding:0; font-size:12px;font-family:"Arial","微软雅黑","宋体",HELVETICA;background:#4A4A4A;_background-image: url(about:blank);_background-attachment: fixed; }
form,ul,li,p,h1,h2,h3,h4,h5,h6{margin:0;padding:0;}input,select{font-size:12px;line-height:16px;}img{border:0;}ul,li{list-style-type:none;}
a{ text-decoration:none;}
.left_top{ height:50px; line-height:50px; float:left; color:#333}
.right_top{ float:right;line-height:50px;}
.back_index{ width:20px; height:20px; background-image:url(__PUBLIC__/images/back_index2.png); background-repeat:no-repeat; display:block; float:right; background-position:center; margin:15px 20px 0 0;}
.logout{ width:20px; height:20px; background-image:url(__PUBLIC__/images/logout2.png); background-repeat:no-repeat; display:block; float:right; background-position:center; margin:15px 20px 0 0;}
.geren{height:20px; background-image:url(__PUBLIC__/images/gerenzhongx2.png); background-repeat:no-repeat; display:block; float:right; padding-left:20px; line-height:20px;background-position:left center; margin:15px 20px 0 0; color:#fff}
.m30{ margin-left:30px; color:#fff}
.w240{ width:240px; height:23px; line-height:23px; border:solid 1px #e8ecf3; border-radius:3px; margin-left:10px; padding-left:5px; outline:none; font-family:'微软雅黑'; color:#333;transition:background-color .3s linear}
.w120{ width:120px; height:23px; line-height:23px; border:solid 1px #e8ecf3; border-radius:3px; margin-right:10px; padding-left:5px; outline:none; font-family:'微软雅黑'; color:#333;transition:background-color .3s linear}
.addbtn{ border:none; width:65px; height:25px; color:#fff; border-radius:3px; background-color:#2dcb73; font-family:'微软雅黑'; display:inline-block; line-height:25px; text-align:center;vertical-align:middle}
</style>

</head>

<body>
<div class="left_top">
<div class="addmedia">
    <form method="post" action="__APP__/Member" target="main">
    <span class="m30">快速搜索：</span><input type="text" name="keyword" id="keyword" class="w240" placeholder="姓名/手机/微信/QQ"><input type="submit" value="搜索" class="m30 addbtn" />
    </form>
</div>
</div>
<div class="right_top">
<a href="#" class="geren"><?php echo ($username); ?></a>
<a href="__URL__/logout" class="logout" target="_parent"></a>
<a href="__URL__/right" target="main" class="back_index"></a>
</div>
</body>
</html>