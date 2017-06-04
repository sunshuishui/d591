<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>媒体管理</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/datastyle.css" />
<script>
	function checkD(){
		if($('#title').val()==''){
			alert('媒体名称不能为空');	
			$('#title').focus();
			return false;
		}
		return true;
	}
</script>
</head>

<body>
<div class="mainAll">
<div class="addmedia">
    <form method="post" action="__URL__/addmedia" onsubmit="return checkD();">
    <span class="m30">媒体名称：</span><input type="text" id="title" name="medianame" class="w120"><input type="submit" value="添加" class="addbtn" />
    </form>
</div>
<table cellpadding="0" cellspacing="0" cellspacing="0" width="100%">
    <tr class="bb_table">
        <th height="50" class="bb_table" align="center" width="20%">SRC</th>
        <th class="bb_table" align="center" width="20%">媒体名称</th>
        <th class="bb_table" align="center" width="30%">添加时间</th>
        <th class="bb_table" align="center" width="30%">操作</th>
    </tr>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
        <td class="bb_table" height="50" align="center"><?php echo ($vo["id"]); ?></td>
        <td class="bb_table" align="center"><?php echo ($vo["medianame"]); ?></td>
        <td class="bb_table" align="center"><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
        <td class="bb_table" align="center">
            <a href="__URL__/delmedia/id/<?php echo ($vo["id"]); ?>" class="delbtn" onclick="return confirm('确定要删除吗？')">删除</a>
        </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<div class="padding60"></div>
</div>
</body>
</html>