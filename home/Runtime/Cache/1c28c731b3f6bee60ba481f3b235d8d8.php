<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客资管理</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/clipboard.min.js"></script>
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
	function checkD(){
		$bmobile=$('#bmobile').val();
		$gmobile=$('#gmobile').val();
		$wechat=$('#wechat').val();
		$qq=$('#qq').val();
		if(!$bmobile && !$gmobile && !$wechat && !$qq){
			alert('请至少填写一种联系方式！');	
			return false;
		}
		if($bmobile!=''){
			if(! /^1[345678]\d{9}$/.test($bmobile)){
				 $("#bmobile").focus();
				 alert('请输入正确的男方号码！');
				 return false;
			}
		}
		if($gmobile!=''){
			if(! /^1[345678]\d{9}$/.test($gmobile)){
				 $("#gmobile").focus();
				 alert('请输入正确的女方号码！');
				 return false;
			}
		}
		if($("#source").val()==0){
			alert('请添加数据来源！');
			return false;	
		}
		
		if($("#askid").val()==''){
			alert('请选择所属鼠标手！');
			return false;	
		}
		
		if($('#nexttime').val()){
			$mydate=new Date();
			$nowdate=new Date($mydate.toLocaleDateString());
			if(!DateSize($nowdate,$('#nexttime').val())){
				alert('待回访时间不能小于当前时间！');
				return false;	
			}
		}
		$onc=0;
		$(".onc").each(function($i){
			if($(".onc").eq($i).val()!=''){
				$onc++;	
				return false;
			}
		});
		if($onc==0){
			alert('请选择推荐商户！');
			return false;	
		}
		$valid=$('#valid').val();
		$state=$('#state').val();
		if($state==1){
			if($valid==3){
				if($('#suretime').val()==''){
					alert('请填写订单时间！');
					return false;		
				}
			}	
		}
		if($("#pic").val()!='' && $("#note").val()==''){
			alert('请填写跟踪记录！');
			return false;	
		}
		return true;
	}
	function checkD2(){
		if($("#source").val()==0){
			alert('请添加数据来源！');
			return false;	
		}
		if($("#askid").val()==''){
			alert('请选择所属鼠标手！');
			return false;	
		}
		
		if($('#nexttime').val()){
			$mydate=new Date();
			$nowdate=new Date($mydate.toLocaleDateString());
			if(!DateSize($nowdate,$('#nexttime').val())){
				alert('待回访时间不能小于当前时间！');
				return false;	
			}
		}
		
		$valid=$('#valid').val();
		$state=$('#state').val();
		if($state==1){
			if($valid==2){
				if($('#incustime').val()==''){
					alert('请填写进店时间！');
					return false;		
				}
			}
			if($valid==3){
				if($('#suretime').val()==''){
					alert('请填写订单时间！');
					return false;		
				}
			}	
		}
		if($("#pic").val()!='' && $("#note").val()==''){
			alert('请填写跟踪记录！');
			return false;	
		}
		return true;
	}
	
	$(function(){
		
		//推荐商家的时候加背景颜色区分,并查询重复
		$('.onc').change(function(){
			if($(this).val()){
				AjaxReturn($(this));
				$(this).addClass('addbg');	
			}else{
				$(this).css('border','solid 1px #e8ecf3');
				$(this).removeClass('addbg');		
			}
		})
		
		//客资有效时候，跳出有效状态
		$('#state').change(function(){
			
			if($(this).val()==1){
				$('#valid').show();	
			}else{
				$('#valid').hide();		
			}
		})
	})
	function AjaxReturn($this){
		$bmobile=$('#bmobile').val();
		$gmobile=$('#gmobile').val();
		$wechat=$('#wechat').val();
		$qq=$('#qq').val();
		$id=$('#id').val();
		$cusid=$this.val();
		$isact=true;
		if(!$bmobile && !$gmobile && !$wechat && !$qq){
			alert('请至少填写一种联系方式！');	
			$isact=false;
		}
		if(!$cusid){
			$isact=false;
		}
		//$isact=false;
		if($isact){
			$.post('__URL__/checkrepeat',{bmobile:$bmobile,gmobile:$gmobile,wechat:$wechat,qq:$qq,cusid:$cusid,id:$id},function($msg){
				if($msg['status']==1){
					alert($msg['info']);
				}else if($msg['status']==2){
					$($this).css('border','solid 1px #ff0000');
					alert('此商户数据重复');
				}else{
					$($this).css('border','solid 1px #e8ecf3');
				}
			})
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
</script>
<style>
.jilu2 a{background-image:url(__PUBLIC__/images/ypicon.jpg); background-repeat:no-repeat; background-position:left center; padding:8px}
</style>
</head>

<body>
<div class="mainAll">
<?php if($act == 1): ?><table cellpadding="0" cellspacing="0" cellspacing="0" width="100%">

	<tr <?php if($map['nt'] != null): ?>class="none"<?php endif; ?>>
        <td class="bb_table" height="70" colspan="10">
        <form action="__URL__/index" method="post" onsubmit="return checktime();">
        <select class="w3_120 m30" name="state" id="state">
        	<option value="nodata">---是否有效---</option>
            <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['state'] == $key and $map['state'] != null): ?>selected<?php endif; ?>><?php echo ($state); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <select class="styleselect <?php if($map["valid"] == null and $map["state"] != 1): ?>none<?php endif; ?>" name="valid" id="valid">
        	<option value="nodata">--状态--</option>
            <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['valid'] == $key): ?>selected<?php endif; ?>><?php echo ($valid); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <?php if($power != 5 and $power != 4 and $power != 3): ?><select class="w3_120" name="source">
        	<option value="nodata">---来源渠道---</option>
            <?php if(is_array($medialist)): $i = 0; $__LIST__ = $medialist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$media): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['source'] == $key): ?>selected<?php endif; ?>><?php echo ($media); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select><?php endif; ?>
        <?php if($power != 4 and $power != 5 and $power != 3): ?><select class="w3_120" name="customers">
        	<option value="nodata">---商户---</option>
            <?php if(is_array($cusarr)): $i = 0; $__LIST__ = $cusarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cus): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['customers'] == $key): ?>selected<?php endif; ?>><?php echo ($cus); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select><?php endif; ?>
        <?php if($power != 4 and $power != 5 and $power != 3): ?><select class="w3_120" name="askid">
        	<option value="nodata">---鼠标手---</option>
            <?php if(is_array($askarr)): $i = 0; $__LIST__ = $askarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ask): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['askid'] == $key): ?>selected<?php endif; ?>><?php echo ($ask); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select><?php endif; ?>
        <?php if($power != 5 and $power != 3): if($power==4){ $sale_data_arr=$salecusarr; }else{ $sale_data_arr=$salearr; } ?>
        <select class="w3_120" name="saleid">
        	<option value="nodata">---网销---</option>
            <?php if(is_array($sale_data_arr)): $i = 0; $__LIST__ = $sale_data_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sale): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['saleid'] == $key): ?>selected<?php endif; ?>><?php echo ($sale); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select><?php endif; ?>
        <select class="w3_120" name="need">
        	<option value="nodata">---会员需求---</option>
            <?php if(is_array($needs)): $i = 0; $__LIST__ = $needs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$need): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($map['need'] == $key): ?>selected<?php endif; ?>><?php echo ($need); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <input type="text" class="w120" value="<?php echo ($map['keyword']); ?>" placeholder="联系方式" name="keyword" />
        <input class="w120" value="<?php echo ($map['starttime']); ?>" type="date" name="starttime" id="starttime"/>-&nbsp;&nbsp;&nbsp;&nbsp;<input class="w120" type="date" value="<?php echo ($map['endtime']); ?>" name="endtime" id="endtime"/><input type="submit" value="搜索" class=" addbtn" />
</form>
        </td>
    </tr>
  
    <tr class="bb_table">
        <th height="50" class="bb_table" align="center" width="10%">ID</th>
        <th class="bb_table" align="center" width="10%"><?php if($map['nt'] == 'y'): ?>回访<?php else: ?>提交<?php endif; ?>时间</th>
        <th class="bb_table" align="center" width="10%">渠道</th>
        <th class="bb_table" align="center" width="10%">微信</th>
        <th class="bb_table" align="center" width="10%">姓名</th>
        <th class="bb_table" align="center" width="10%">电话</th>
        <th class="bb_table" align="center" width="10%">状态</th>
        <th class="bb_table" align="center" width="10%">所属网销</th>
        <th class="bb_table" align="center" width="10%">进店时间</th>
        <th class="bb_table" align="center" width="10%">详情</th>
    </tr>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="bb_table" onmouseover="this.style.background='#e9f2ed'" onmouseout="this.style.background='#ffffff'">
     	<td class="bb_table" height="50" align="center"><?php echo ($vo["id"]); ?></td>
        <td class="bb_table" align="center"><?php if($map['nt'] == 'y'): echo Hz($vo['nexttime']); else: echo ($vo["addtime"]); endif; ?></td>
        <td class="bb_table" align="center"><?php echo ($medialist[$vo['source']]); ?></td>
        <td class="bb_table" align="center"><?php echo ($vo['wechat']); ?></td>
        <td class="bb_table" height="50" align="center"><?php echo Echodata($vo['bname'],$vo['bmobile'],$vo['gname'],$vo['gmobile'],1);?></td>
        <td class="bb_table" align="center"><?php echo Echodata($vo['bname'],$vo['bmobile'],$vo['gname'],$vo['gmobile'],2);?></td>
        <td class="bb_table" align="center"><?php echo Status($vo['state'],$vo['valid']);?></td>
        <td class="bb_table" align="center"><?php echo ($cusarr[$vo['customers']]); ?>—<?php echo ($salearr[$vo['saleid']]); ?></td>
        <td class="bb_table" align="center"><?php echo ($vo['incustime']); ?></td>
        <td class="bb_table" align="center">
        	<?php $map['id']=$vo['id'] ?>
        	<a href="<?php echo U('Member/editmember',$map);?>" class="editbtn">详情</a>
        </td>
    </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
    <?php $map['id']='' ?>
    <tr><td colspan="9" height="60" align="center" class="pageclass"><?php echo ($show); ?><form method="get" action="<?php echo U('Member/index',$map);?>" style="display:inline; margin-left:30px"><input type="number" name="p" class="w40"/><input type="submit" value="跳转" /></form></td></tr>
</table>
<?php elseif($act == 2): ?>
<p style="height:20px"></p>
<form action="__URL__/addmember" method="post" onsubmit="return checkD();" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="1" width="1000" align="center" bgcolor="#32c2cd">
	<tr bgcolor="#e6fafc">
    	<td height="60" colspan="4" align="center"><font size="+1">基础信息</font></td>
    </tr>
	<tr bgcolor="#ffffff">
    	<td height="60" width="25%" align="right">姓名（男）：<input type="text" class="w120 mri" value="<?php echo ($data["bname"]); ?>" name="bname" id="bname" /></td>
        <td width="25%" align="right">电话（男）：<input type="text" class="w120 mri" value="<?php echo ($data["bmobile"]); ?>" name="bmobile" id="bmobile" maxlength="11" placeholder="男方手机号" /></td>
        <td width="25%" align="right">姓名（女）：<input type="text" class="w120 mri" value="<?php echo ($data["gname"]); ?>" name="gname" id="gname" /></td>
        <td width="25%" align="right">电话（女）：<input type="text" class="w120 mri" value="<?php echo ($data["gmobile"]); ?>" name="gmobile" id="gmobile" maxlength="11" placeholder="女方手机号" /></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td align="right">
        微信：<input type="text" class="w120 mri" value="<?php echo ($data["wechat"]); ?>" name="wechat" id="wechat"/>
        </td>
        <td align="right">
        QQ：<input type="text" class="w120 mri" value="<?php echo ($data["qq"]); ?>" name="qq" id="qq"/>
        </td>
        <td height="60" align="right">预算：<input type="number" class="w120 mri"  value="<?php echo ($data["budget"]); ?>" name="budget" id="budget"/></td>
        <td height="60" align="right">婚期：<input type="date" class="w120 mri" name="marrydate" id="marrydate" /></td>
        </tr>
   
    <tr bgcolor="#ffffff">
    	<td height="60" align="right">数据来源：
        <select class="w2_120 mri" name="source" id="source">
        <option value="0">-----请选择-----</option>
        <?php if(is_array($medialist)): $i = 0; $__LIST__ = $medialist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$media): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($media); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </td>
    	<td height="60" align="left" colspan="3">
        <span class="m30">顾客需求：</span>
        <?php if(is_array($needs)): $i = 0; $__LIST__ = $needs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$need): $mod = ($i % 2 );++$i;?><input type="checkbox" value="<?php echo ($key); ?>" id='need<?php echo ($key); ?>' name='needs[]'/><label class="m15" for='need<?php echo ($key); ?>'><?php echo ($need); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
        </td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td colspan="4">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td width="95" align="right"><span>推荐客户：</span></td>
                    <td style="padding:15px 0">
                    	<?php if(is_array($customers)): $i = 0; $__LIST__ = $customers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$customer): $mod = ($i % 2 );++$i;?><p class="pli">
                            <select class="w2_170 onc" name="cus_sale[]">
                                <option value="">----<?php echo ($customer["customername"]); ?>----</option>
                                <?php if(is_array($salelist[$customer['id']])): $i = 0; $__LIST__ = $salelist[$customer['id']];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sale): $mod = ($i % 2 );++$i;?><option value="<?php echo ($customer['id']); ?>-<?php echo ($sale["id"]); ?>"><?php echo ($sale["username"]); ?> (<?php echo ($customer["customername"]); ?>)</option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            </p><?php endforeach; endif; else: echo "" ;endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr bgcolor="#e6fafc">
    	<td height="60" colspan="4" align="center"><font size="+1">数据详情</font></td>
    </tr>
    <tr bgcolor="#ffffff">
     	<td align="right">所属鼠标手：
        <?php if($power == 1 or $power == 2): ?><select class="w2_120 mri" name="askid" id="askid">
        <option value="">----请选择----</option>
        <?php if(is_array($ask)): $i = 0; $__LIST__ = $ask;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ser): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($ser); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <?php else: ?>
        <input type="hidden" value="<?php echo ($userid); ?>" name='askid' id="askid" />
        <span class="mri"><?php echo ($ask[$userid]); ?></span><?php endif; ?>
        </td>
    	<td height="60" align="right">状态：
        <select class="styleselect" name="state" id="state">
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($state); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <select class="styleselect none" name="valid" id="valid">
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($valid); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </td>
        <td align="right">下次回访：<input type="date" class="w120 mri"  value="<?php echo ($data["nexttime"]); ?>" name="nexttime" id="nexttime"/></td>
       <td align="right">签单时间：<input type="date" class="w120 mri"  value="<?php echo ($data["suretime"]); ?>" name="suretime" id="suretime"/></td>
    </tr>
    <tr bgcolor="#e6fafc">
    	<td height="60" colspan="4" align="center"><font size="+1">跟进记录</font></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td colspan="4" height="80">
        	<p style="height:20px"></p>
            <textarea class="textb90_2" name="note" id="note" placeholder="跟进记录"></textarea>
            <p style="height:10px"></p>
            <p class="m30"><input type="file" name="pic" id="pic" /></p>
            <p style="height:10px"></p>
        </td>
    </tr>
    <tr bgcolor="#ffffff">
        <td colspan="4" align="center" height="60">
        	<input type="hidden" value="<?php echo ($data["id"]); ?>" name="id" /><input type="submit" value="提交" class="addbtn" /><a href="javascript:history.back()" class="editbtn m30" onclick="return confirm('确定返回上一页吗？')">返回</a>
        </td>
    </tr>
</table>
</form>
<?php elseif($act == 3): ?>
<p style="height:20px"></p>
<form action="__URL__/savemember" method="post" onsubmit="return checkD2();" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="1" width="1000" align="center" bgcolor="#32c2cd">
	<tr bgcolor="#e6fafc">
    	<td height="60" colspan="4" align="center"><font size="+1">基础信息</font></td>
    </tr>
	<tr bgcolor="#ffffff">
    	<td height="60" width="25%" align="right">姓名（男）：<input type="text" class="w120 mri" value="<?php echo ($data["bname"]); ?>" name="bname" id="bname" /></td>
        <td width="25%" align="right">电话（男）：<?php if($data["bmobile"] != null): ?><span class="mri"><?php echo (sjiemi($data["bmobile"])); ?></span><?php else: ?><span class="mri">无</span><?php endif; ?></td>
        <td width="25%" align="right">姓名（女）：<input type="text" class="w120 mri" value="<?php echo ($data["gname"]); ?>" name="gname" id="gname" /></td>
        <td width="25%" align="right">电话（女）：<?php if($data["gmobile"] != null): ?><span class="mri"><?php echo (sjiemi($data["gmobile"])); ?></span><?php else: ?><span class="mri">无</span><?php endif; ?></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td align="right">
        微信：<?php if($data["wechat"] != null): ?><span class="mri"><?php echo ($data["wechat"]); ?></span><?php else: ?><span class="mri">无</span><?php endif; ?>
        </td>
        <td align="right">
        QQ：<?php if($data["qq"] != null): ?><span class="mri"><?php echo ($data["qq"]); ?></span><?php else: ?><span class="mri">无</span><?php endif; ?>
        </td>
        <td height="60" align="right">预算：<input type="number" class="w120 mri"  value="<?php echo ($data["budget"]); ?>" name="budget" id="budget"/></td>
        <td height="60" align="right">婚期：<input type="date" class="w120 mri"  value="<?php echo ($data["marrydate"]); ?>" name="marrydate" id="marrydate" /></td>
        </tr>
   
    <tr bgcolor="#ffffff">
    	<td height="60" align="right">数据来源：
        <?php if($power == 1 or $power == 2): ?><select class="w2_120 mri" name="source" id="source">
        <option value="0">-----请选择-----</option>
        <?php if(is_array($medialist)): $i = 0; $__LIST__ = $medialist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$media): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($data['source'] == $key): ?>selected="selected"<?php endif; ?>><?php echo ($media); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <?php else: ?>
        <span class="mri"><?php echo ($medialist[$data['source']]); ?></span>
        <input type="hidden" value="1" name="source" /><?php endif; ?>
        </td>
    	<td height="60" align="left" colspan="3">
        <span class="m30">顾客需求：</span>
        <?php if(is_array($needs)): $i = 0; $__LIST__ = $needs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$need): $mod = ($i % 2 );++$i;?><input type="checkbox" value="<?php echo ($key); ?>" id='need<?php echo ($key); ?>' name='needs[]' <?php if($needinfor[$key] == $key): ?>checked=checked<?php endif; ?>/><label class="m15" for='need<?php echo ($key); ?>'><?php echo ($need); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
        </td>
    </tr>
    <tr bgcolor="#e6fafc">
    	<td height="60" colspan="4" align="center"><font size="+1">数据详情</font></td>
    </tr>
    <tr bgcolor="#ffffff">
     	<td align="right">所属鼠标手：
        <?php if($power == 1 or $power == 2): ?><select class="w2_120 mri" name="askid" id="askid">
        <option value="">----请选择----</option>
        <?php if(is_array($askarr)): $i = 0; $__LIST__ = $askarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ser): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($data['askid'] == $key): ?>selected="selected"<?php endif; ?>><?php echo ($ser); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <?php else: ?>
        <span class="mri"><?php echo ($dataarr[$data['askid']]); ?></span>
        <input type="hidden" value="1" name="askid"/><?php endif; ?>
        </td>
    	<td height="60" align="right">状态：
        <?php if($power != 1 and $power != 2 and $data['state'] == 1): ?><select class="styleselect" name="state" id="state">
        <option value="1">有效</option>
        </select>
        <?php else: ?>
        <select class="styleselect" name="state" id="state">
        <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($data['state'] == $key): ?>selected="selected"<?php endif; ?>><?php echo ($state); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select><?php endif; ?>
        
        <select class="styleselect <?php if($data["state"] != 1): ?>none<?php endif; ?>" name="valid" id="valid">
        <?php if(is_array($valids)): $i = 0; $__LIST__ = $valids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valid): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($data['valid'] == $key): ?>selected="selected"<?php endif; ?>><?php echo ($valid); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        </td>
        <td align="right">下次回访：<input type="date" class="w120 mri"  value="<?php echo ($data["nexttime"]); ?>" name="nexttime" id="nexttime"/></td>
       <td align="right">签单时间：<input type="date" class="w120 mri"  value="<?php echo ($data["suretime"]); ?>" name="suretime" id="suretime"/></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td height="60" align="right">所属商户：<span class="mri"><?php echo ($cusarr[$data['customers']]); ?></span></td>
        <td align="right">所属网销：<span class="mri"><?php echo ($dataarr[$data['saleid']]); ?></span></td>
        <td align="right">到店日期：<input type="date" class="w120 mri"  value="<?php echo ($data["incustime"]); ?>" name="incustime" id="incustime"/></td>
        <td align="right"></td>
    </tr>
    <tr bgcolor="#e6fafc">
    	<td height="60" colspan="4" align="center"><font size="+1">跟进记录</font></td>
    </tr>
    <tr bgcolor="#ffffff">
    	<td colspan="4" height="80">
        	<p style="height:20px"></p>
            <?php if(is_array($note)): $i = 0; $__LIST__ = $note;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$n): $mod = ($i % 2 );++$i;?><p class="jilu<?php if($n["type"] == 1): ?>2<?php endif; ?>"><span><b><?php echo ($dataarr[$n['userid']]); ?></b>（<?php echo ($n["addtime"]); ?>）：</span><?php echo ($n["note"]); if($n["pic"] != null): ?><a href="__PUBLIC__/Uploads/<?php echo ($n["pic"]); ?>" class="piclink" target="_blank">图片</a><?php endif; ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
            <textarea class="textb90_2" name="note" id="note" placeholder="跟进记录"></textarea>
            <p style="height:10px"></p>
            <p class="m30"><input type="file" name="pic" id="pic" /></p>
            <p style="height:10px"></p>
        </td>
    </tr>
    <tr bgcolor="#ffffff">
        <td colspan="4" align="center" height="60">
        <?php if(is_array($param)): $i = 0; $__LIST__ = $param;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cs): $mod = ($i % 2 );++$i;?><input type="hidden" value="<?php echo ($cs); ?>" name='<?php echo ($key); ?>' /><?php endforeach; endif; else: echo "" ;endif; ?>
        	<input type="hidden" value="<?php echo ($data["id"]); ?>" name="id" /><input type="submit" value="提交" class="addbtn" /><a href="javascript:history.back()" class="editbtn m30" onclick="return confirm('确定返回上一页吗？')">返回</a>
        </td>
    </tr>
</table>
</form><?php endif; ?>
<div class="padding60"></div>
</div>
</body>
</html>