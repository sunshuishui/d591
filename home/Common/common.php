<?php
function needs(){
	return array(
	1=>'婚纱照',
	2=>'宝宝照',
	3=>'写真',
	4=>'艺术照',
	5=>'全家福',
	6=>'纪念照'
	);	
}

//客资状态
function states(){
	return array(
	0=>'未处理',
	1=>'有效',
	2=>'无效'
	);
}
//客资有效状态
function valids(){
	return array(
	0=>'待定',
	1=>'跟进中',
	2=>'进店',                                                         
	3=>'订单',
	4=>'死单'
	);	
}


//权限列表+
function power(){
	return array(
	'admin'=>'1',		//管理员
	'askdir'=>'2',		//鼠标手主管
	'ask'=>'3',			//鼠标手
	'customer'=>'4',	//商户	
	'netsale'=>'5'		//网销
	);
}
//媒体列表
function medialist(){
	$m=M('media_list');
	$data=$m->field('id,medianame')->order('id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['medianame'];
	}
	return $datanew;
}
//鼠标手列表
function askarr(){
	$m=M('datauser');
	$data=$m->field('id,username')->where("(power=3 or power=2) and isdel =0")->order('id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['username'];
	}
	return $datanew;
}

//网销列表
function salearr(){
	$m=M('datauser');
	$data=$m->field('id,username')->where("power=5 and isdel =0")->order('ownerid desc,id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['username'];
	}
	return $datanew;
}
//网销对应商户列表
function saletocarr(){
	$m=M('datauser');
	$data=$m->field('id,ownerid')->where("power=5 and isdel =0")->order('ownerid desc,id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['ownerid'];
	}
	return $datanew;
}
//指定商户网销列表
function salecusarr($cus){
	$m=M('datauser');
	$data=$m->field('id,username')->where("power=5 and isdel=0 and ownerid=$cus")->order('id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['username'];
	}
	return $datanew;
}
//商户列表
function cusarr(){
	$m=M('datauser');
	$data=$m->field('id,customername')->where("power=4 and isdel =0")->order('id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['customername'];
	}
	return $datanew;
}
//总用户列表
function dataarr(){
	$m=M('datauser');
	$data=$m->field('id,username')->where("(power=4 or power=3 or power=2 or power=5 or power=1) and isdel =0")->order('id desc')->select();
	foreach($data as $datatemp){
		$datanew[$datatemp['id']]=$datatemp['username'];
	}
	return $datanew;
}
//判断是不是操作别人的数据
function illegal($power,$data,$userid){
	if($power==3){	//鼠标手
		if($data['askid']!=$userid){
			exit('非法操作');
		}
	}elseif($power==4){	//商户
		if($data['customers']!=$userid){
			exit('非法操作');
		}
	}elseif($power==5){	//网销
		if($data['saleid']!=$userid){
			exit('非法操作');
		}
	}
}
function sjiami($mobile){
  if($mobile){
	  $mobile=$mobile+C('MOBILESECRET');
	  $mobile1=substr($mobile,0,1);
	  $mobile2=substr($mobile,1,2);
	  $mobile3=substr($mobile,3,2);
	  $mobile4=substr($mobile,5,2);
	  $mobile5=substr($mobile,7,2);
	  $mobile6=substr($mobile,9,2);
	  return $mobile1.$mobile5.$mobile3.$mobile2.$mobile4.$mobile6;
  }else{
	  return '';
  }
}
function sjiemi($mobile){
	if($mobile){
		$mobile1=substr($mobile,0,1);
		$mobile2=substr($mobile,1,2);
		$mobile3=substr($mobile,3,2);
		$mobile4=substr($mobile,5,2);
		$mobile5=substr($mobile,7,2);
		$mobile6=substr($mobile,9,2);
		$mobile=$mobile1.$mobile4.$mobile3.$mobile5.$mobile2.$mobile6;
		$mobile=$mobile-C('MOBILESECRET');
		return (string)$mobile;	
	}
}
function subsix($mobile){
	if(ismobile($mobile)){
		return substr($mobile,7,4);
	}
}
function Echodata($bname,$bmobile,$gname,$gmobile,$type){
	if($gname){
		$name=$gname;	
	}
	if($bname){
		$name=$bname;	
	}
	if($gmobile){
		$mobile=$gmobile;
	}
	if($bmobile){
		$mobile=$bmobile;	
	}
	if($gname and $gmobile){
		$name=$gname;
		$mobile=$gmobile;
	}
	if($bname and $bmobile){
		$name=$bname;
		$mobile=$bmobile;
	}
	if($type==1){
		return $name;
	}elseif($type==2){
		return sjiemi($mobile);
	}else{
		$sl=sjiemi($mobile);
		return substr($sl,0,3).'****'.substr($sl,7,4);
	}
}
function Status($state,$valid){
	if(!$state){
		$state=0;	
	}
	if(!$valid){
		$valid=0;	
	}
	if($valid){
		$valids=valids();
		return $valids[$valid];
	}else{
		$states=states();
		return $states[$state];	
	}
}

function LogLogin($username){
	$txt="\r\n".date('Y-m-d H:i:s').'	'.$username.'	'.get_client_ip();
    $f=fopen('./Public/record/log.txt','a+');
    fwrite($f,$txt);
    fclose($f);
}
function Hz($Ymd){
	$t=$Ymd;
	if(strtotime($Ymd)<strtotime(date('Y-m-d'))){
		$t='<span style="color:#ff0000">'.$t.'</span>';
	}
	if(strtotime($Ymd)==strtotime(date('Y-m-d'))){
		$t='<span style="color:#ff0000">今天</span>';	
	}
	if(strtotime($Ymd)==(strtotime(date('Y-m-d'))+24*3600)){
		$t='明天';	
	}
	return $t;
}
function ismobile($mobile) {
	if (!is_numeric($mobile)) {
		return false;
	}
	return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,3,6,7,8]{1}\d{8}$|^18[\d]{9}$#',$mobile)?true:false;
 }
?>