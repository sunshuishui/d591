<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>鼠标手管理</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/datastyle.css" />
<script>
	function checkD(){
		if($('#username').val()==''){
			alert('用户名不能为空');	
			$('#username').focus();
			return false;
		}
		if($('#password').val()=='' || $('#password').val().length<6){
			alert('密码不能少于6位');	
			$('#password').focus();
			return false;
		}
		return true;
	}
	function checkD2(){
		if($('#username').val()==''){
			alert('用户名不能为空');	
			$('#username').focus();
			return false;
		}
		if($('#password').val()!='' && $('#password').val().length<6){
			alert('密码不能少于6位');	
			$('#password').focus();
			return false;
		}
		return true;
	}
	
</script>
</head>

<body>
<div class="mainAll">
<?php if($act == 1): ?><div class="addmedia">
   <a href="__URL__/adddata" class="m30 addbtn">添加</a>
</div>
<table cellpadding="0" cellspacing="0" cellspacing="0" width="100%">
    <tr class="bb_table">
        <th height="50" class="bb_table" align="center" width="15%">ID</th>
        <th class="bb_table" align="center" width="15%">鼠标手</th>
        <th class="bb_table" align="center" width="15%">角色</th>
        <th class="bb_table" align="center" width="15%">允许登录</th>
        <th class="bb_table" align="center" width="15%">添加日期</th>
        <th class="bb_table" align="center" width="20%">操作</th>
    </tr>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
        <td class="bb_table" height="50" align="center"><?php echo ($user["id"]); ?></td>
        <td class="bb_table" align="center"><?php echo ($user["username"]); ?></td>
        <td class="bb_table" align="center"><?php if($user["power"] == 2): ?>主管<?php else: ?>鼠标手<?php endif; ?></td>
        <td class="bb_table" align="center"><?php if($user['allowlogin'] == 1): ?>允许<?php else: ?>否<?php endif; ?></td>
        <td class="bb_table" align="center"><?php echo ($user["addtime"]); ?></td>
        <td class="bb_table" align="center">
            <a href="__URL__/editdata/id/<?php echo ($user["id"]); ?>" class="editbtn">编辑</a>
            <a href="__URL__/deluser/id/<?php echo ($user["id"]); ?>" class="delbtn" onclick="return confirm('确定要删除吗，请谨慎操作！')">删除</a>
        </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<?php elseif($act == 2): ?>
<form action="__URL__/adduser" method="post" onsubmit="return checkD();">
	<table cellpadding="0" cellspacing="1" cellspacing="0" width="100%">
    	<tr>
        	<td colspan="2" height="55" class="bb_table" align="center"><span class="font18">添加鼠标手</span></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">用户名</span></td>
            <td class="bb_table"><input type="text" value="" class="wb90" placeholder="用户名" name="username" id="username" maxlength="20"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">密码</span></td>
            <td class="bb_table"><input type="password" value="" class="wb90" placeholder="******" name="password" id="password" maxlength="15"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">设为主管</span></td>
            <td class="bb_table"><select class="w120 m30" name="powerk"><option value="0">否</option><option value="1">是</option></select></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">允许登录</span></td>
            <td class="bb_table">
            <select class="w120 m30" name="allowlogin"><option value="1">允许</option><option value="0">不允许</option></select>
            </td>
        </tr>
        <tr>
        	<td width="180" class="bb_table" align="right"><span class="bold500">推荐商户</span></td>
            <td class="bb_table" style="padding:15px 0">
            <div class="m30 medialist">
            <ul>
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><li><input type="checkbox" name="bindcus[]" value="<?php echo ($user["id"]); ?>" id="c<?php echo ($user["id"]); ?>"><label for="c<?php echo ($user["id"]); ?>"><?php echo ($user["customername"]); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            </div>
            </td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table"></td>
            <td class="bb_table"><input type="submit" value="提交" class="addbtn m30"/><a href="javascript:history.back()" class="editbtn m30">返回</a></td>
        </tr>
    </table>
</form>
<?php elseif($act == 3): ?>
<form action="__URL__/edituser" method="post" onsubmit="return checkD2();">
	<table cellpadding="0" cellspacing="1" cellspacing="0" width="100%">
    	<tr>
        	<td colspan="2" height="55" class="bb_table" align="center"><span class="font18">添加鼠标手</span></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">用户名</span></td>
            <td class="bb_table"><input type="text" value="<?php echo ($user["username"]); ?>" class="wb90" placeholder="用户名" name="username" id="username" maxlength="20"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">密码</span></td>
            <td class="bb_table"><input type="password" value="" class="wb90" placeholder="******" name="password" id="password" maxlength="15"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">设为主管</span></td>
            <td class="bb_table"><select class="w120 m30" name="powerk"><option value="0" <?php if($user["power"] == 3): ?>selected="selected"<?php endif; ?>>否</option><option value="1" <?php if($user["power"] == 2): ?>selected="selected"<?php endif; ?>>是</option></select></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">允许登录</span></td>
            <td class="bb_table">
            <select class="w120 m30" name="allowlogin"><option value="1" <?php if($user["allowlogin"] == 1): ?>selected="selected"<?php endif; ?>>允许</option><option value="0" <?php if($user["allowlogin"] != 1): ?>selected="selected"<?php endif; ?>>不允许</option></select>
            </td>
        </tr>
        <tr>
        	<td width="180" class="bb_table" align="right"><span class="bold500">推荐商户</span></td>
            <td class="bb_table" style="padding:15px 0">
            <div class="m30 medialist">
            <ul>
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($i % 2 );++$i;?><li><input type="checkbox" name="bindcus[]" value="<?php echo ($da["id"]); ?>" id="c<?php echo ($da["id"]); ?>"<?php if($bc[$da['id']] == $da['id']): ?>checked="checked"<?php endif; ?>><label for="c<?php echo ($da["id"]); ?>"><?php echo ($da["customername"]); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            </div>
            </td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table"></td>
            <td class="bb_table"><input type="submit" value="提交" class="addbtn m30"/><input type="hidden" value="<?php echo ($user["id"]); ?>" name="id" /><a href="javascript:history.back()" class="editbtn m30">返回</a></td>
        </tr>
    </table>
</form>
<?php elseif($act == 4): ?>
<table cellpadding="0" cellspacing="0" cellspacing="0" width="100%">
	<tr class="bb_table">
        <th height="70" class="bb_table" align="center" colspan="6"><a href="javascript:openaddsale(<?php echo ($ownerid); ?>,'<?php echo (urlencode($customername)); ?>');" class="m30 addbtn" style="float:left">添加</a><span class="font18"><?php echo ($customername); ?>网销管理</span></th>
    </tr>
    <tr class="bb_table">
        <th height="50" class="bb_table" align="center" width="10%">ID</th>
        <th class="bb_table" align="center" width="20%">用户名</th>
        <th class="bb_table" align="center" width="15%">允许登录</th>
        <th class="bb_table" align="center" width="15%">添加日期</th>
        <th class="bb_table" align="center" width="20%">操作</th>
    </tr>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
        <td class="bb_table" height="50" align="center"><?php echo ($user["id"]); ?></td>
        <td class="bb_table" align="center"><?php echo ($user["username"]); ?></td>
        <td class="bb_table" align="center"><?php if($user['allowlogin'] == 1): ?>允许<?php else: ?>否<?php endif; ?></td>
        <td class="bb_table" align="center"><?php echo ($user["addtime"]); ?></td>
        <td class="bb_table" align="center">
            <a href="javascript:openeditsale(<?php echo ($user["id"]); ?>,'<?php echo (urlencode($customername)); ?>');" class="editbtn">编辑</a>
            <a href="javascript:openbind(<?php echo ($user["id"]); ?>,'<?php echo (urlencode($customername)); ?>')" class="viewbtn">二维码</a>
            <a href="__URL__/deluser/id/<?php echo ($user["id"]); ?>" class="delbtn" onclick="return confirm('确定要删除吗，请谨慎操作！')">删除</a>
        </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<?php elseif($act == 5): ?>
<form action="__URL__/editdata" method="post" onsubmit="return checksale();">
	<table cellpadding="0" cellspacing="1" cellspacing="0" width="100%">
    	<tr>
        	<td colspan="2" height="55" class="bb_table" align="center"><span class="font18"><?php echo ($customername); ?>-添加网销</span></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">用户名</span></td>
            <td class="bb_table"><input type="text" value="" class="wb70" placeholder="用户名" name="username" id="username" maxlength="20"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">密码</span></td>
            <td class="bb_table"><input type="password" value="" class="wb70" placeholder="******" name="password" id="password" maxlength="15"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">允许登录</span></td>
            <td class="bb_table">
            <select class="wb70" name="allowlogin"><option value="1">允许</option><option value="0">不允许</option></select>
            </td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table"></td>
            <td class="bb_table"><input type="hidden" name="ownerid" value="<?php echo ($ownerid); ?>" /><input type="submit" value="提交" class="addbtn m30"/></td>
        </tr>
    </table>
</form>
<?php elseif($act == 6): ?>
<form action="__URL__/editsaledata" method="post" onsubmit="return checksale2();">
	<table cellpadding="0" cellspacing="1" cellspacing="0" width="100%">
    	<tr>
        	<td colspan="2" height="55" class="bb_table" align="center"><span class="font18"><?php echo ($customername); ?>-编辑网销</span></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">用户名</span></td>
            <td class="bb_table"><input type="text" value="<?php echo ($user["username"]); ?>" class="wb70" placeholder="用户名" name="username" id="username" maxlength="20"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">密码</span></td>
            <td class="bb_table"><input type="password" value="" class="wb70" placeholder="******" name="password" id="password" maxlength="15"/></td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table" align="right"><span class="bold500">允许登录</span></td>
            <td class="bb_table">
            <select class="wb70" name="allowlogin"><option value="1" <?php if($user["allowlogin"] == 1): ?>selected="selected"<?php endif; ?>>允许</option><option value="0" <?php if($user["allowlogin"] != 1): ?>selected="selected"<?php endif; ?>>不允许</option></select>
            </td>
        </tr>
        <tr>
        	<td width="180" height="60" class="bb_table"></td>
            <td class="bb_table"><input type="hidden" name="id" value="<?php echo ($user["id"]); ?>" /><input type="submit" value="提交" class="addbtn m30"/></td>
        </tr>
    </table>
</form>
<?php elseif($act == 7): ?>
<script>
$(function(){
	$id=<?php echo ($user['id']); ?>;
	$i=0;
	/*$exec=setInterval(function(){
		$.post('__URL__/isband',{id:$id},function($back){
			$i++;
			if($i<15){
				if($back['status']==1){
					clearInterval($exec);	
					alert('绑定成功！');
					window.opener.location.reload();
					window.close();
				}
			}else{
				clearInterval($exec);
				window.opener.location.reload();
				window.close();
			}
		})	
	},2000);*/
})
</script>
<table cellpadding="0" cellspacing="1" cellspacing="0" width="100%">
    <tr>
        <td colspan="2" height="55" class="bb_table" align="center"><span class="font14">网销绑定微信</span></td>
    </tr>
    <tr>
        <td width="180" height="60" class="bb_table" align="right"><span class="bold500">用户名</span></td>
        <td class="bb_table"><span class="m30"><?php echo ($user["username"]); ?></span></td>
    </tr>
    <tr>
        <td width="180" height="60" class="bb_table" align="right"><span class="bold500">所属商家</span></td>
        <td class="bb_table"><span class="m30"><?php echo ($customername); ?></span></td>
    </tr>
    <tr>
        <td width="180" height="180" class="bb_table" align="right"><span class="bold500">二维码</span></td>
        <td class="bb_table">
        <p class="m30">
       		<img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=<?php echo ($ticket); ?>" width="150" />
        </p>
        </td>
    </tr>
</table><?php endif; ?>
<div class="padding60"></div>
</div>
</body>
</html>