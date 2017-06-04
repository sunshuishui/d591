<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客资管理</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/datastyle.css" />
<script>
	function DateSize($date1,$date2){
		$s= new Date($date1); 
		$d= new Date($date2); 
		if($s>$d){
			return false;
		}else{
			return true;
		}	
	}
	function checktime(){
		if($('#starttime').val()!='' && $('#endtime').val()==''){
			alert('请选择结束日期');
			return false;
		}
		if($('#endtime').val()!='' && $('#starttime').val()==''){
			alert('请选择开始日期');
			return false;
		}
		if(!DateSize($('#starttime').val(),$('#endtime').val())){
			alert('结束日期不能小于开始日期！');
			return false;	
		}
		return true;
	}
	function ExportData(){
		if(checktime()){
			if($('#starttime').val()=='' && $('#endtime').val()==''){
				alert('请选择日期');
				return false;
			}else{
				location.href='__URL__/exportdata/starttime/'+$('#starttime').val()+'/endtime/'+$('#endtime').val();
			}
		}
	}
</script>
</head>
<body>
<div class="mainAll">
<div class="addmedia">
    <form method="post" action="" onsubmit="return checktime();" style="float:left">
    <span class="m30">起始日期：</span><input type="date"  class="w120" name="starttime" id="starttime" value="<?php echo ($starttime); ?>"/>-&nbsp;&nbsp;&nbsp;&nbsp;<input type="date"  class="w120" name="endtime" id="endtime" value="<?php echo ($endtime); ?>"/><input type="submit" value="查询" class="addbtn" />
    </form>
    <form method="post" action="" style="float:left; margin:0 25px;margin-top: 2px;">
    <input type="hidden"  name="starttime" value="<?php echo date('Y-m-d'); ?>"/><input type="hidden"  name="endtime" value="<?php echo date('Y-m-d'); ?>"/>
    <input type="submit" value="今天" class="addbtn" />
    </form>
    <form method="post" action="" style="margin-top:2px">
    <input type="hidden"  name="starttime" value="<?php echo date('Y-m-d',strtotime('-1 day')); ?>"/><input type="hidden"  name="endtime" value="<?php echo date('Y-m-d',strtotime('-1 day')); ?>"/>
    <input type="submit" value="昨天" class="addbtn" />
    </form>
    
</div>
<?php if($act == 1): ?><table cellpadding="0" cellspacing="0" width="100%">
    <tr class="bb_table">
   	 	<th height="50" class="bb_table" align="center"></th>
        <th height="50" class="bb_table" align="center">数据量</th>
    	<?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($state); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($valid); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr>
    <?php if(is_array($askarr)): $i = 0; $__LIST__ = $askarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ask): $mod = ($i % 2 );++$i; $askid=$key; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center" width="200"><b><?php echo ($ask); ?></b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountZong[$askid] != null): echo ($CountZong[$askid]); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountState[$askid][$key] != null): echo ($CountState[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountValid[$askid][$key] != null): echo ($CountValid[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center"><b>总计</b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountData != null): echo ($CountData); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllState[$key] != null): echo ($CountAllState[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllValid[$key] != null): echo ($CountAllValid[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>        
    </tr>
</table>
<?php elseif($act == 2): ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr class="bb_table">
   	 	<th height="50" class="bb_table" align="center"></th>
        <th height="50" class="bb_table" align="center">数据量</th>
    	<?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($state); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($valid); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr>
    <?php if(is_array($cusarr)): $i = 0; $__LIST__ = $cusarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ask): $mod = ($i % 2 );++$i; $askid=$key; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center" width="200"><b><?php echo ($ask); ?></b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountZong[$askid] != null): echo ($CountZong[$askid]); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountState[$askid][$key] != null): echo ($CountState[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountValid[$askid][$key] != null): echo ($CountValid[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center"><b>总计</b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountData != null): echo ($CountData); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllState[$key] != null): echo ($CountAllState[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllValid[$key] != null): echo ($CountAllValid[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>        
    </tr>
</table>
<?php elseif($act == 3): ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr class="bb_table">
   	 	<th height="50" class="bb_table" align="center"></th>
        <th height="50" class="bb_table" align="center">数据量</th>
    	<?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($state); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($valid); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr>
    <?php if(is_array($salearr)): $i = 0; $__LIST__ = $salearr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ask): $mod = ($i % 2 );++$i; $askid=$key; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center" width="200"><b><?php echo (($cusarr[$saletocarr[$askid]])?($cusarr[$saletocarr[$askid]]):'其他'); ?>—<?php echo ($ask); ?></b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountZong[$askid] != null): echo ($CountZong[$askid]); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountState[$askid][$key] != null): echo ($CountState[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountValid[$askid][$key] != null): echo ($CountValid[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center"><b>总计</b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountData != null): echo ($CountData); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllState[$key] != null): echo ($CountAllState[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllValid[$key] != null): echo ($CountAllValid[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>        
    </tr>
</table>

<?php elseif($act == 4): ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tr class="bb_table">
   	 	<th height="50" class="bb_table" align="center"></th>
        <th height="50" class="bb_table" align="center">数据量</th>
    	<?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($state); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><th height="50" class="bb_table" align="center"><?php echo ($valid); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr>
    <?php if(is_array($medialist)): $i = 0; $__LIST__ = $medialist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ask): $mod = ($i % 2 );++$i; $askid=$key; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center" width="200"><b><?php echo ($ask); ?></b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountZong[$askid] != null): echo ($CountZong[$askid]); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountState[$askid][$key] != null): echo ($CountState[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountValid[$askid][$key] != null): echo ($CountValid[$askid][$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center"><b>总计</b></td>
        <td class="bb_table" height="50" align="center"><?php if($CountData != null): echo ($CountData); else: ?>-<?php endif; ?></td>
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllState[$key] != null): echo ($CountAllState[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><td class="bb_table" height="50" align="center"><?php if($CountAllValid[$key] != null): echo ($CountAllValid[$key]); else: ?>-<?php endif; ?></td><?php endforeach; endif; else: echo "" ;endif; ?>        
    </tr>
</table><?php endif; ?>
<div class="padding60"></div>
</div>
</body>
</html>