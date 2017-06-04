<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #666; font-size: 16px; }
.system-message{ padding: 24px 48px; }
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
.kbox_tip{ width:100%; height:40px; background-color:#08959E; color:#fff; font-size:18px; line-height:40px}
.kbox{ width:300px; height:160px; border:solid 1px #08959E; margin:0 auto; margin-top:200px;}
.kbox_title{ width:100%; height:55px; line-height:55px; margin-top:30px; font-size:24px; text-align:center; }
.kbox_jump{width:100%; height:55px; line-height:55px;  font-size:14px; text-align:center}
</style>
</head>
<body>
<div class="system-message">
<?php if(isset($message)): ?><!--<h1>:)</h1>
<p class="success"><?php echo($message); ?></p>-->
<div class="kbox">
	<p class="kbox_tip">&nbsp;&nbsp;&nbsp;&nbsp;页面提示</p>
	<p class="kbox_title"><?php echo($message); ?><a id="href" href="<?php echo($jumpUrl); ?>"></a>(<b id="wait"><?php echo($waitSecond); ?></b>s)</p>
</div>
<?php else: ?>
<!--<h1>:(</h1>
<p class="error"><?php echo($error); ?></p>-->
<div class="kbox">
	<p class="kbox_tip">&nbsp;&nbsp;&nbsp;&nbsp;页面提示</p>
	<p class="kbox_title"><?php echo($error); ?><a id="href" href="<?php echo($jumpUrl); ?>"></a>(<b id="wait"><?php echo($waitSecond); ?></b>s)</p>
</div><?php endif; ?>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time == 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>