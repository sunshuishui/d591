<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/Public/js/jquery-1.11.0.min.js"></script>
<script>
$(function(){
	$('.slidedown').click(function(){
		$('.parenta i').css({'background-image':'url(__PUBLIC__/images/r2.png)'});
		$('.slidedown').not($(this)).next('.second').slideUp(300);
		$('li').css({'background-color':'none'});
		$d=$(this).next('.second').css('display');
		if($d=='none'){
			$(this).find('i').css({'background-image':'url(__PUBLIC__/images/b2.png)'});
			$(this).parent().css({'background-color':'#088d96'});
		}else{
			$(this).find('i').css({'background-image':'url(__PUBLIC__/images/r2.png)'});
			$(this).parent().css({'background-color':'none'});
		}
		$(this).next('.second').stop(false,false).toggle(300);
	})
	$('.nos').click(function(){
		$('.second').hide();
		$('.parenta i').css({'background-image':'url(__PUBLIC__/images/r2.png)'});
		$('li').css({'background-color':'none'});
		$(this).parent().css({'background-color':'#088d96'});
	})
})
</script>
<title>591客资管理系统</title>
<style>
body{margin:0;padding:0; font-size:12px;font-family:"Arial","微软雅黑","宋体",HELVETICA;background:#fff;_background-image: url(about:blank);_background-attachment: fixed; background:#18A0A9; }
form,ul,li,p,h1,h2,h3,h4,h5,h6{margin:0;padding:0;}input,select{font-size:12px;line-height:16px;}img{border:0;}ul,li{list-style-type:none;}
a{ text-decoration:none;}
.left{ width:200px}
.top_control{ display:block; width:157px; height:50px; background-color:#24383A; color:#fff; line-height:50px; font-size:16px; padding-left:43px; background-image:url(__PUBLIC__/images/all_menu_icon.png); background-repeat:no-repeat; background-position:18px center}
li{min-height:60px; width:100%; line-height:60px; border-bottom:solid 1px #08959e}
.parenta{ display:block; width:157px; height:60px; line-height:60px;padding-left:43px; background-repeat:no-repeat; background-position:18px center; color:#fff; font-size:13px; cursor:pointer}
li:hover{ background-color:#088d96}
.parenta i{ width:9px; height:9px;  float:right; background-image:url(__PUBLIC__/images/r2.png); background-repeat:no-repeat; background-position:center; margin:25px 15px 0 0}
.second{ width:100%; height:auto; overflow:hidden; display:none}
.second a{ display:block; width:157px; height:60px; line-height:60px; padding-left:43px; color:#fff; font-size:13px;}

.adsm{background-image:url(__PUBLIC__/images/ads_b_icon.png);}
.tcm{background-image:url(__PUBLIC__/images/tc_b_icon.png);}
.basem{background-image:url(__PUBLIC__/images/base_b_icon.png);}
.kepm{background-image:url(__PUBLIC__/images/kep_b_icon.png);}
.ypm{background-image:url(__PUBLIC__/images/yp_b_icon.png);}
.zixm{background-image:url(__PUBLIC__/images/zix_b_icon.png);}
.wdym{background-image:url(__PUBLIC__/images/wdy_b_icon.png);}
.hydpm{background-image:url(__PUBLIC__/images/hydp_b_icon.png);}
.datam{background-image:url(__PUBLIC__/images/data_b_icon.png);}
.zhglm{background-image:url(__PUBLIC__/images/zh_bg.png);}
.dqm{background-image:url(__PUBLIC__/images/dq_bg.png);}
.servicem{background-image:url(__PUBLIC__/images/service_bg.png);}
.jiamengm{background-image:url(__PUBLIC__/images/jimeng_bg.png);}
.jiamum{background-image:url(__PUBLIC__/images/jiamu_bg.png);}
.orderm{background-image:url(__PUBLIC__/images/order_bg.png);}
</style>
</head>

<body>
<div class="left">
	<a class="top_control" href="#">功能列表</a>
	<ul>
    <?php if($power == 1): ?><li>
            <span class="parenta slidedown tcm">客资管理<i></i></span>
            <div class="second">
            	<a href="../Member/add" target="main">添加客资</a>
                <a href="../Member/index" target="main">数据列表</a>
                <a href="../Member/index/nt/q" target="main">有效数据</a>
            	<a href="../Member/index/nt/y" target="main">待回访</a>
            </div>
        </li>
        
        <li>
            <a href="../Media/index" class="parenta nos zixm" target="main">媒体管理</a>
        </li>
        <li>
            <a href="../Customer/index" class="parenta nos hydpm" target="main">商户管理</a>
        </li>
        <li>
            <a href="../Ask/index" class="parenta nos orderm" target="main">鼠标手</a>
        </li>
        <li>
            <span class="parenta slidedown datam">查看报表<i></i></span>
            <div class="second">
                <a href="../Table/ask" target="main">鼠标手报表</a>
            	<a href="../Table/customer" target="main">商户报表</a>
                <a href="../Table/sale" target="main">网销报表</a>
                <a href="../Table/media" target="main">媒体报表</a>
            </div>
        </li>
        <?php elseif($power == 2): ?>
        <li>
            <span class="parenta slidedown tcm">客资管理<i></i></span>
            <div class="second">
            	<a href="../Member/add" target="main">添加客资</a>
                <a href="../Member/index" target="main">数据列表</a>
                <a href="../Member/index/nt/q" target="main">有效数据</a>
            	<a href="../Member/index/nt/y" target="main">待回访</a>
            </div>
        </li>
        <li>
            <span class="parenta slidedown datam">查看报表<i></i></span>
            <div class="second">
                <a href="../Table/ask" target="main">鼠标手报表</a>
            	<a href="../Table/customer" target="main">商户报表</a>
                <a href="../Table/sale" target="main">网销报表</a>
            </div>
        </li>
        <?php elseif($power == 3): ?>
        <li>
            <span class="parenta slidedown tcm">客资管理<i></i></span>
            <div class="second">
            	<a href="../Member/add" target="main">添加客资</a>
                <a href="../Member/index" target="main">数据列表</a>
                <a href="../Member/index/nt/q" target="main">有效数据</a>
            	<a href="../Member/index/nt/y" target="main">待回访</a>
            </div>
        </li>
        <?php elseif($power == 4): ?>
        <li>
            <span class="parenta slidedown tcm">客资管理<i></i></span>
            <div class="second">
                <a href="../Member/index" target="main">数据列表</a>
                <a href="../Member/index/nt/q" target="main">有效数据</a>
            	<a href="../Member/index/nt/y" target="main">待回访</a>
            </div>
        </li>
        <li>
            <span class="parenta slidedown datam">查看报表<i></i></span>
            <div class="second">
                <a href="../Table/sale" target="main">网销报表</a>
            </div>
        </li>
        <?php elseif($power == 5): ?>
        <li>
            <span class="parenta slidedown tcm">客资管理<i></i></span>
            <div class="second">
                <a href="../Member/index" target="main">数据列表</a>
                <a href="../Member/index/nt/q" target="main">有效数据</a>
            	<a href="../Member/index/nt/y" target="main">待回访</a>
            </div>
        </li><?php endif; ?>
    </ul>
</div>
</body>
</html>