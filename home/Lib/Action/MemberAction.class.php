<?php
class MemberAction extends CommonAction {
	public function index(){
		$power=session('power');
		$state=$this->_param('state');
		if($state!='nodata' and $state!=''){
			$where['state']=$state;	
			$map['state']=$state;	
		}
		if($state==1){
			$valid=$this->_param('valid');
			if($valid!='nodata' and $valid!=''){
				$where['valid']=$valid;	
				$map['valid']=$valid;
			}
		}
		$customers=$this->_param('customers');
		if($customers!='nodata' and $customers!=''){
			$where['customers']=$customers;	
			$map['customers']=$customers;
		}
		$saleid=$this->_param('saleid');
		if($saleid!='nodata' and $saleid!=''){
			$where['saleid']=$saleid;	
			$map['saleid']=$saleid;
		}
		$askid=$this->_param('askid');
		if($askid!='nodata' and $askid!=''){
			$where['askid']=$askid;	
			$map['askid']=$askid;
		}
		if($power==3){
			$where['askid']=session('userid');		
		}elseif($power==4){
			$where['customers']=session('userid');			
		}elseif($power==5){
			$where['saleid']=session('userid');			
		}
		$need=$this->_param('need');
		if($need!='nodata' and $need!=''){
			$where['needs']=array('like','%#'.$need.'#%');
			$map['need']=$need;
		}
		$nt=$this->_param('nt');
		if($nt=='y'){	//如果是待回访列表
			$map['nt']=$nt;
			$where['nexttime']=array(array('neq','null'),array('neq','0000-00-00'));
			$order='nexttime asc,id desc';
		}
		if($nt=='q'){	//如果是有效数据列表
			$map['nt']=$nt;
			$where['state']=array('eq','1');
		}
		$source=$this->_param('source');
		if($source!='nodata' and $source!=''){
			$where['source']=$source;	
			$map['source']=$source;
		}
		
		$keyword=$this->_param('keyword');
		$string='1=1';
		$starttime=$this->_param('starttime');
		$endtime=$this->_param('endtime');
		if($starttime and $endtime){
			$map['starttime']=$starttime;
			$map['endtime']=$endtime;
			$starttime=strtotime($starttime);
			$endtime=strtotime($endtime.' 23:59:59');
			$string.=" and (unix_timestamp(addtime)>=$starttime and unix_timestamp(addtime)<$endtime)";	
			
		}
		if($keyword){
			$string.=" and (bname like '%".$keyword."%' or gname like '%".$keyword."%' or bmobile like '%".sjiami($keyword)."%' or gmobile like '%".sjiami($keyword)."%' or bmobile_four like '%".$keyword."%' or gmobile_four like '%".$keyword."%' or qq like '%".$keyword."%' or wechat like '%".$keyword."%')";
			$map['keyword']=$keyword;	
		}
		$where['_string']=$string;
		
		$m=M('datainfor');
		import('ORG.Util.Page');
		$count=$m->where($where)->count();
		$Page=new Page($count,30);
		foreach($map as $key=>$maptemp){
			$Page->parameter.="$key=".urlencode($maptemp).'&';	
		}
		$show=$Page->show();
		if(!$order){
			$order='id desc';
		}
		$data=$m->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $m->_sql();
		$map['p']=$this->_get('p');
		$this->assign('data',$data);
		$this->assign('map',$map);
		$this->assign('show',$show);
		$this->assign('act',1);
		$this->assign('empty','<tr><td colspan="9" height="60" align="center">No Data!</td></tr>');
		
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('needs',needs());
		$this->assign('salearr',salearr());
		$this->assign('cusarr',cusarr());
		$this->assign('askarr',askarr());
		if($power==4){
			$this->assign('salecusarr',salecusarr(session('userid')));
		}
		$this->assign('power',$power);
		$this->assign('medialist',medialist());
		$this->display();
	}
	//添加数据
	public function add(){
		$where['power']=4;
		$where['isdel']=0;
		if(session('bindcus')){//如果鼠标手登录的话，选择他绑定的商家
			$where['id']=array('in',session('bindcus'));
			$map['ownerid']=array('in',session('bindcus'));
		}
		$m=M('datauser');
		$customers=$m->field('id,customername')->where($where)->order('id desc')->select();
		$map['power']=5;
		$map['isdel']=0;
		$sale=$m->field('id,username,ownerid')->where($map)->order('id desc')->select();
		foreach($sale as $sale_temp){
			$salelist[$sale_temp['ownerid']][]=$sale_temp;
		}
		
		
		$this->assign('needs',needs());
		$this->assign('act',2);
		$this->assign('customers',$customers);
		$this->assign('salelist',$salelist);
		$this->assign('medialist',medialist());
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('power',session('power'));
		$this->assign('userid',session('userid'));
		$this->assign('ask',askarr());
		$this->display('index');
	}
	public function addmember(){
		$bname=$this->_post('bname');
		$bmobile=$this->_post('bmobile');
		$gname=$this->_post('gname');
		$gmobile=$this->_post('gmobile');
		$wechat=$this->_post('wechat');
		$qq=$this->_post('qq');
		$budget=$this->_post('budget');
		$cus_sale=$this->_post('cus_sale');
		$marrydate=$this->_post('marrydate');
		$source=$this->_post('source');
		$needs=$this->_post('needs');
		$state=$this->_post('state');
		$valid=$this->_post('valid');
		$nexttime=$this->_post('nexttime');
		$suretime=$this->_post('suretime');
		
		if(!$bmobile and !$gmobile and !$wechat and !$qq){		//至少有一个联系方式
			$this->show('<script>alert("请至少填写男女一方的手机号码");history.back();</script>');
			exit();	
		}
		
		
		if($nexttime){
			if(strtotime($nexttime)<strtotime(date('Y-m-d'))){
				$this->show('<script>alert("待回访时间不能小于当前时间！");history.back();</script>');
				exit();
			}
		}
		if($state==1){
			if($valid==3){			//如果状态是订单
				if(!$suretime){
					$this->show('<script>alert("请填写订单时间！");history.back();</script>');
					exit();	
				}
			}		
		}
		if(!$source){
			$this->show('<script>alert("请添加数据来源！");history.back();</script>');
			exit();	
		}
		
		$needs=implode('#',$needs);
		if($needs){
			$needs='#'.$needs.'#';
		}
		
		$power=session('power');
		$userid=session('userid');
		if($power==3){
			$askid=$userid;
		}else{
			$askid=$this->_post('askid');
		}
		if(!$askid){
			$this->show('<script>alert("请选择所属鼠标手！");history.back();</script>');
			exit();	
		}
		
		$data=array(
		'bname'=>$bname,
		'bmobile'=>sjiami($bmobile),
		'bmobile_four'=>subsix($bmobile),
		'gname'=>$gname,
		'gmobile'=>sjiami($gmobile),
		'gmobile_four'=>subsix($gmobile_four),
		'wechat'=>$wechat,
		'qq'=>$qq,
		'budget'=>$budget,
		'marrydate'=>$marrydate,
		'source'=>$source,
		'needs'=>$needs,
		'state'=>$state,
		'nexttime'=>$nexttime,
		'askid'=>$askid,
		'suretime'=>$suretime,
		'addtime'=>date('Y-m-d H:i:s')
		);
		
		if($state==1){			//如果是有效咨询
			$data['valid']=$valid;
			$data['validtime']=time();
		}
		
		$cusarr=cusarr();
		$onc=0;
		foreach($cus_sale as $cus_sale_temp){
			if($cus_sale_temp){
				$onc++;
				$cus_temp=explode('-',$cus_sale_temp);
				$data['customers']=$cus_temp[0];
				$data['saleid']=$cus_temp[1];
				$dataall[]=$data;
				//判断联系方式是否重复及手机号是否符合格式
				$returnInfor=$this->checkdata($bmobile,$gmobile,$wechat,$qq,$cus_sale_temp,$id);
				if($returnInfor['status']==1){
					$this->show('<script>alert("'.$returnInfor['infor'].'！");history.back();</script>');
					exit();		
				}
				if($returnInfor['status']==2){
					$this->show('<script>alert("商户'.$cusarr[$cus_temp[0]].'数据重复！");history.back();</script>');
					exit();		
				}
			}
		}
		if($onc==0){
			$this->show('<script>alert("请选择推荐商户！");history.back();</script>');
			exit();	
		}
		$success_saleid=$this->addalldata($dataall);
		if(count($success_saleid)>0){		//如果数据添加成功，则发送模板消息
			$this->SendSer($success_saleid,array($bname,$bmobile,$gname,$gmobile,$wechat,$qq));
			$this->show('<script>alert("添加成功！");location.href="'.U('Member/index').'";</script>');
			exit();		
		}else{
			$this->show('<script>alert("添加失败！");history.back();</script>');
			exit();		
		}
	}
	public function editmember(){
		$id=$this->_get('id');
		$power=session('power');
		$param['temp_state']=$this->_param('state');
		$param['temp_valid']=$this->_param('valid');
		$param['temp_saleid']=$this->_param('saleid');
		$param['temp_customers']=$this->_param('customers');
		$param['temp_askid']=$this->_param('askid');
		$param['temp_keyword']=$this->_param('keyword');
		$param['temp_source']=$this->_param('source');
		$param['temp_need']=$this->_param('need');
		$param['temp_starttime']=$this->_param('starttime');
		$param['temp_endtime']=$this->_param('endtime');
		$param['temp_nt']=$this->_param('nt');
		$param['temp_p']=$this->_param('p');
		
		
		$m=M('datainfor');
		$data=$m->find($id);
		illegal($power,$data,session('userid'));
		$needlist=substr($data['needs'],1,-1);
		$needlist=explode('#',$needlist);
		foreach($needlist as $needlist_temp){
			$needinfor[$needlist_temp]=$needlist_temp;
		}
		$n=M('servicenote');
		$note=$n->where("dataid=$id")->order('id desc')->select();
		
		$this->assign('act',3);
		$this->assign('data',$data);
		$this->assign('note',$note);
		$this->assign('needs',needs());
		$this->assign('param',$param);
		$this->assign('medialist',medialist());
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('dataarr',dataarr());
		$this->assign('askarr',askarr());
		$this->assign('cusarr',cusarr());
		$this->assign('needinfor',$needinfor);
		$this->assign('power',session('power'));
		$this->assign('userid',session('userid'));
		$this->display('index');
	}
	public function savemember(){
		$id=$this->_post('id');
		$param['state']=$this->_param('temp_state');
		$param['valid']=$this->_param('temp_valid');
		$param['sale']=$this->_param('temp_sale');
		$param['need']=$this->_param('temp_need');
		$param['keyword']=$this->_param('temp_keyword');
		$param['media']=$this->_param('temp_media');
		$param['starttime']=$this->_param('temp_starttime');
		$param['endtime']=$this->_param('temp_endtime');
		$param['nt']=$this->_param('temp_nt');
		$param['p']=$this->_param('temp_p');
		
		$m=M('datainfor');
		$datainfor=$m->field('state,valid,askid,customers,saleid,source')->find($id);
		illegal(session('power'),$datainfor,session('userid'));
		$data['bname']=$this->_post('bname');
		$data['gname']=$this->_post('gname');
		
		
		$data['budget']=$this->_post('budget');
		$data['marrydate']=$this->_post('marrydate');
		$power=session('power');
		if($power==1 or $power==2){
			$data['source']=$this->_post('source');
		}
		
		$needs=$this->_post('needs');
		$needs=implode('#',$needs);
		if($needs){
			$data['needs']='#'.$needs.'#';
		}
		if($power==1 or $power==2){
			$data['askid']=$this->_post('askid');
		}
		
		$data['state']=$this->_post('state');
		$data['valid']=$this->_post('valid');
		if($datainfor['state']==1 and $data['state']!=1){		//如果之前已经是有效的数据，只有管理员权限才能更改为无效
			if($power==1 or $power==2){
				$data['state']=$this->_post('state');
			}else{
				$data['state']=1;
			}
		}
		
		if($this->_post('nexttime')){
			$data['nexttime']=$this->_post('nexttime');
		}
		if($this->_post('incustime')){
			$data['incustime']=$this->_post('incustime');	
		}
		
		if($data['nexttime']){
			if(strtotime($data['nexttime'])<strtotime(date('Y-m-d'))){
				$this->show('<script>alert("待回访时间不能小于当前时间！");history.back();</script>');
				exit();
			}
		}
		
		$data['suretime']=$this->_post('suretime');
		
		if($data['state']==1){
			if($data['valid']==2){			//如果状态是进店
				if(!$data['incustime']){
					$this->show('<script>alert("请选择邀约到店的时间！");history.back();</script>');
					exit();	
				}	
			}
			if($data['valid']==3){			//如果状态是订单
				if(!$data['suretime']){
					$this->show('<script>alert("请填写订单时间！");history.back();</script>');
					exit();	
				}
			}
			if($datainfor['state']!=1){
				$data['validtime']=time();
			}
		}
		
		
		if($data['state']!=1){		//如果是设为无效
			$data['valid']=0;
			$data['validtime']=0;
		}
		
		$back=$m->where("id=$id")->save($data);
		if($back!==false){
			$valids=valids();
			$states=states();
			$askarr=askarr();
			$medialist=medialist();
			$userid=session('userid');
			if($datainfor['askid']!=$data['askid'] and $data['askid']!=''){		//如果重新分配了鼠标手
				$note='鼠标手更改为：'.$askarr[$data['askid']].'；';
			}
			if($datainfor['source']!=$data['source'] and $data['source']!=''){		//如果重新更改了数据媒体
				$note.='数据渠道更改为：'.$medialist[$data['source']].'；';
			}
			if($data['state']==1){
				$validtext='—'.$valids[$data['valid']];	
			}
			if('o'.$datainfor['state'].'k'.$datainfor['valid'].'l'!='o'.$data['state'].'k'.$data['valid'].'l'){		//如果改变了数据状态(拼接字符串是为了判断更准确)
				$note.='数据状态更改为：'.$states[$data['state']].$validtext.'；';
			}
			$notetime=date('Y-m-d H:i:s');
			$notetype=1;
			$this->insertNote($userid,$id,$note,$notetime,$notetype,$pic);
			
			$note=$this->_post('note');
			if($note){
				if($_FILES['pic']['name']){
					$upinfor=$this->sc(204800);
				}
				$notetype=0;
				$this->insertNote($userid,$id,$note,$notetime,$notetype,$upinfor['pic']);
			}
			$this->show('<script>alert("编辑成功！");location.href="'.U('Member/index',$param).'";</script>');
			exit();		
		}else{
			$this->show('<script>alert("编辑成功2！");history.back();</script>');
			exit();		
		}
	}
	
	function addalldata($dataall){
		$m=M('datainfor');
		$userid=session('userid');
		$states=states();
		$valids=valids();
		$medialist=medialist();
		$dataarr=dataarr();
		$cusarr=cusarr();
		foreach($dataall as $dataall_temp){
			$back=$m->add($dataall_temp);
			if($back){
				$backall[]=$back;
				$success_saleid[]=$dataall_temp['saleid'];
				if($dataall_temp['state']==1){
					$validtext='-'.$valids[$dataall_temp['valid']];
				}
				$data['note']='录入，数据分配给：'.$cusarr[$dataall_temp['customers']].'（'.$dataarr[$dataall_temp['saleid']].'）'.'；渠道为：'.$medialist[$dataall_temp['source']].'；数据状态：'.$states[$dataall_temp['state']].$validtext.'；';
				$data['addtime']=date('Y-m-d H:i:s');
				$data['type']=1;
				$data['dataid']=$back;
				$data['userid']=$userid;
				$data['pic']='';
				$noteall[]=$data;
			}
		}		
		
		$note=$this->_post('note');
		if($note){
			if($_FILES['pic']['name']){
				$upinfor=$this->sc(204800);
			}
			
			foreach($backall as $backall_temp){
				$data['note']=$note;
				$data['addtime']=date('Y-m-d H:i:s');
				$data['type']=0;
				$data['dataid']=$backall_temp;
				$data['userid']=$userid;
				$data['pic']=$upinfor['pic'];
				$noteall[]=$data;
			}
		}
		
		$m=M('servicenote');
		$back=$m->addall($noteall);
		return $success_saleid;
	}
	public function checkrepeat(){
		$bmobile=$this->_post('bmobile');
		$gmobile=$this->_post('gmobile');
		$wechat=$this->_post('wechat');
		$qq=$this->_post('qq');
		$id=$this->_post('id');
		$cusid=$this->_post('cusid');
		$returnInfor=$this->checkdata($bmobile,$gmobile,$wechat,$qq,$cusid,$id);
		$this->ajaxReturn($returnInfor['data'],$returnInfor['info'],$returnInfor['status']);
	}
	private function checkdata($bmobile,$gmobile,$wechat,$qq,$cusid,$id){
		//status
		//1代表参数错误
		//2代表有重复
		//3代表没重复
		$cusid=explode('-',$cusid);
		$cusid=$cusid[0];
		if(!$bmobile and !$gmobile and $wechat and $qq){
			exit();
		}
		if($cusid){
			$sql='1=2';
			if($bmobile){
				if(!ismobile($bmobile)){
					$info="请输入正确的男方手机号！";
					$status=1;
					return array('info'=>$info,'status'=>$status);
					exit();	
				}
				$sql.=" or bmobile='".sjiami($bmobile)."' or gmobile='".sjiami($bmobile)."' or wechat='{$bmobile}' or qq='{$bmobile}'";
			}
			if($gmobile){
				if(!ismobile($gmobile)){
					$info="请输入正确的女方手机号！";
					$status=1;
					return array('info'=>$info,'status'=>$status);
					exit();	
				}
				$sql.=" or gmobile='".sjiami($gmobile)."' or bmobile='".sjiami($gmobile)."' or wechat='{$gmobile}' or qq='{$gmobile}'";
			}
			if($wechat){
				$sql.=" or wechat='{$wechat}' or qq='{$wechat}'";
				if(ismobile($wechat)){
					$sql.=" or gmobile='".sjiami($wechat)."' or bmobile='".sjiami($wechat)."'";
				}
				
			}
			if($qq){
				$sql.=" or wechat='{$qq}' or qq='{$qq}'";
				if(ismobile($qq)){
					$sql.=" or gmobile='".sjiami($qq)."' or bmobile='".sjiami($qq)."'";
				}
			}
			$sql="(".$sql.")"." and customers=$cusid";
			if($id){
				$sql.=" and id!=$id";
			}
			$m=M('datainfor');
			$back=$m->where($sql)->count();
			if($back>0){
				return array('info'=>'','status'=>2);
			}else{
				return array('info'=>'','status'=>3);
			}		
		}
	}
	
	
	function SendSer($saleid,$array){
		$m=M('datauser');
		$saleid=implode(',',$saleid);
		$where['id']=array('in',$saleid);
		$datatemp=$m->field('openid,username')->where($where)->select();
		if($array[0]){
			$bname="(男：{$array[0]})";	
		}
		if($array[1]){
			$bm="(男：{$array[1]})";	
		}
		if($array[2]){
			$gname="(女：{$array[2]})";	
		}
		if($array[3]){
			$gm="(女：{$array[3]})";	
		}
		if($array[4]){
			$wechat="(微信：{$array[3]})";	
		}
		if($array[5]){
			$qq="(QQ：{$array[3]})";	
		}
		foreach($datatemp as $data){
			if($data['openid']){
				$infors=array(
					 "touser"=>$data['openid'],
					 "template_id"=>"hlwhkkFjFg8tnCaF46kI9T1tDHaLFbB3bJXBIlDZrqc",
					 "data"=>array(
						 "first"=>array(
							 "value"=>urlencode($data['username']."，系统给您分配一条客户信息\\n"),
							 "color"=>"#333333"
						 ),
						 "keyword1"=>array(
							 "value"=>urlencode($bname.$gname),
							 "color"=>"#333333"
						 ),
						 "keyword2"=>array(
							 "value"=>urlencode($bm.$gm),
							 "color"=>"#333333"
						 ),
						 "keyword3"=>array(
							 "value"=>urlencode(''),
							 "color"=>"#333333"
						 ),
						 "keyword4"=>array(
							 "value"=>urlencode(date('Y-m-d H:i:s')),
							 "color"=>"#333333"
						 ),
						 "remark"=>array(
							 "value"=>urlencode("\\n\\n".$wechat.$qq."这个客人很重要，请尽快联系！"),
							 "color"=>"#333333"
						 )
					 )
				 );
				//send_template(urldecode(json_encode($infors)));	
			}	
		}
		
	}
	function insertNote($serviceid,$dataid,$note,$addtime,$type,$pic){
		if(!$type){
			$type=0;	
		}
		if($serviceid and $note and $addtime and $dataid){
			$data['userid']=$serviceid;
			$data['dataid']=$dataid;
			$data['note']=$note;
			$data['addtime']=$addtime;
			$data['type']=$type;
			$data['pic']=$pic;
			$m=M('servicenote');
			$back=$m->add($data);
			if(!$back){
				//echo $m->_sql();
				exit('跟踪记录插入出错，联系管理员！');
			}
		}
	}
	function sc($maxsize){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = $maxsize ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo();
			foreach($info as $infoas){
				$upinfor[$infoas['key']]=$infoas['savename'];
			}
		}
		return $upinfor;
		//return $info[0]['savename'];
	}
	
}