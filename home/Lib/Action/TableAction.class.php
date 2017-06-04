<?php
class TableAction extends CommonAction {
	public function index(){
		
	}
	//鼠标手效果
	public function ask(){
		$m=M('datainfor');
		$starttime=$this->_post('starttime');
		$endtime=$this->_post('endtime');
		$askarr=askarr();
		$askarr['other']='其他';
		$array_flip=array_flip($askarr);
		
		if($starttime and $endtime){
			$this->assign('starttime',$starttime);
			$this->assign('endtime',$endtime);
			$starttime=strtotime($starttime);
			$endtime=strtotime($endtime.' 23:59:59');
			
			//有效(待定、跟进中、死单)
			$where['state']=1;
			$where['validtime']=array(array('gt',$starttime),array('lt',$endtime));
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,askid')->where($where)->select();
			foreach($datainfor as $data){
				$CountState[$data['askid']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['valid']==0 or $data['valid']==1 or $data['valid']==4){
					if(!in_array($data['askid'],$array_flip)){
						$data['askid']='other';	
					}
					$CountValid[$data['askid']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
			}
			//进店
			unset($where);
			$where['state']=1;
			$where['_string']="(UNIX_TIMESTAMP(incustime)>=$starttime and UNIX_TIMESTAMP(incustime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,askid')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['askid'],$array_flip)){
					$data['askid']='other';	
				}
				$CountValid[$data['askid']][2]++;
				$CountAllValid[2]++;
			}
			//订单
			unset($where);
			$where['state']=1;
			$where['_string']="(UNIX_TIMESTAMP(suretime)>=$starttime and UNIX_TIMESTAMP(suretime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,askid')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['askid'],$array_flip)){
					$data['askid']='other';	
				}
				$CountValid[$data['askid']][3]++;
				$CountAllValid[3]++;
			}
			
			//其他
			unset($where);
			//$where['state']=array('neq',1);
			$where['_string']="(UNIX_TIMESTAMP(addtime)>$starttime and UNIX_TIMESTAMP(addtime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,askid')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['askid'],$array_flip)){
					$data['askid']='other';	
				}
				if($data['state']!=1){
					$CountState[$data['askid']][$data['state']]++;
					$CountAllState[$data['state']]++;
				}
				$CountZong[$data['askid']]++;
				$CountData++;
			}
		}else{
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,askid')->select();
			foreach($datainfor as $data){
				if(!in_array($data['askid'],$array_flip)){
					$data['askid']='other';	
				}
				$CountState[$data['askid']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['state']==1){
					$CountValid[$data['askid']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
				$CountZong[$data['askid']]++;
			}
			$CountData=count($datainfor);
		}
		$this->assign('act',1);
		$this->assign('askarr',$askarr);
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('CountValid',$CountValid);
		$this->assign('CountState',$CountState);
		$this->assign('CountZong',$CountZong);
		$this->assign('CountData',$CountData);
		$this->assign('CountAllValid',$CountAllValid);
		$this->assign('CountAllState',$CountAllState);
		$this->display('index');
	}
	//商户效果
	public function customer(){
		$m=M('datainfor');
		$starttime=$this->_post('starttime');
		$endtime=$this->_post('endtime');
		$cusarr=cusarr();
		$cusarr['other']='其他';
		
		$array_flip=array_flip($cusarr);
		
		if($starttime and $endtime){
			$this->assign('starttime',$starttime);
			$this->assign('endtime',$endtime);
			$starttime=strtotime($starttime);
			$endtime=strtotime($endtime.' 23:59:59');
			
			//有效(待定、跟进中、死单)
			$where['state']=1;
			$where['validtime']=array(array('gt',$starttime),array('lt',$endtime));
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,customers')->where($where)->select();
			foreach($datainfor as $data){
				$CountState[$data['customers']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['valid']==0 or $data['valid']==1 or $data['valid']==4){
					if(!in_array($data['customers'],$array_flip)){
						$data['customers']='other';	
					}
					$CountValid[$data['customers']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
			}
			//进店
			unset($where);
			$where['state']=1;
			$where['_string']="(UNIX_TIMESTAMP(incustime)>=$starttime and UNIX_TIMESTAMP(incustime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,customers')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['customers'],$array_flip)){
					$data['customers']='other';	
				}
				$CountValid[$data['customers']][2]++;
				$CountAllValid[2]++;
			}
			//订单
			unset($where);
			$where['state']=1;
			$where['_string']="(UNIX_TIMESTAMP(suretime)>=$starttime and UNIX_TIMESTAMP(suretime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,customers')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['customers'],$array_flip)){
					$data['customers']='other';	
				}
				$CountValid[$data['customers']][3]++;
				$CountAllValid[3]++;
			}
			
			//其他
			unset($where);
			//$where['state']=array('neq',1);
			$where['_string']="(UNIX_TIMESTAMP(addtime)>$starttime and UNIX_TIMESTAMP(addtime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,customers')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['customers'],$array_flip)){
					$data['customers']='other';	
				}
				if($data['state']!=1){
					$CountState[$data['customers']][$data['state']]++;
					$CountAllState[$data['state']]++;
				}
				$CountZong[$data['customers']]++;
				$CountData++;
			}
		}else{
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,customers')->select();
			foreach($datainfor as $data){
				if(!in_array($data['customers'],$array_flip)){
					$data['customers']='other';	
				}
				$CountState[$data['customers']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['state']==1){
					$CountValid[$data['customers']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
				$CountZong[$data['customers']]++;
			}
			$CountData=count($datainfor);
		}
		//var_dump($CountAllValid);
		$this->assign('act',2);
		$this->assign('cusarr',$cusarr);
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('CountValid',$CountValid);
		$this->assign('CountState',$CountState);
		$this->assign('CountZong',$CountZong);
		$this->assign('CountData',$CountData);
		$this->assign('CountAllValid',$CountAllValid);
		$this->assign('CountAllState',$CountAllState);
		$this->display('index');
	}
	//网销效果
	public function sale(){
		$m=M('datainfor');
		$starttime=$this->_post('starttime');
		$endtime=$this->_post('endtime');
		if(session('power')==4){
			$salearr=salecusarr(session('userid'));
		}else{
			$salearr=salearr();
			
		}
		
		$salearr['other']='其他';
		$array_flip=array_flip($salearr);
		
		if($starttime and $endtime){
			$this->assign('starttime',$starttime);
			$this->assign('endtime',$endtime);
			$starttime=strtotime($starttime);
			$endtime=strtotime($endtime.' 23:59:59');
			
			//有效(待定、跟进中、死单)
			$where['state']=1;
			if(session('power')==4){
				$where['customers']=session('userid');
			}
			$where['validtime']=array(array('gt',$starttime),array('lt',$endtime));
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,customers,saleid')->where($where)->select();
			foreach($datainfor as $data){
				$CountState[$data['saleid']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['valid']==0 or $data['valid']==1 or $data['valid']==4){
					if(!in_array($data['saleid'],$array_flip)){
						$data['saleid']='other';	
					}
					$CountValid[$data['saleid']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
			}
			//进店
			unset($where);
			$where['state']=1;
			if(session('power')==4){
				$where['customers']=session('userid');
			}
			$where['_string']="(UNIX_TIMESTAMP(incustime)>=$starttime and UNIX_TIMESTAMP(incustime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,saleid')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['saleid'],$array_flip)){
					$data['saleid']='other';	
				}
				$CountValid[$data['saleid']][2]++;
				$CountAllValid[2]++;
			}
			//订单
			unset($where);
			$where['state']=1;
			if(session('power')==4){
				$where['customers']=session('userid');
			}
			$where['_string']="(UNIX_TIMESTAMP(suretime)>=$starttime and UNIX_TIMESTAMP(suretime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,saleid')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['saleid'],$array_flip)){
					$data['saleid']='other';	
				}
				$CountValid[$data['saleid']][3]++;
				$CountAllValid[3]++;
			}
			
			//其他
			unset($where);
			//$where['state']=array('neq',1);
			if(session('power')==4){
				$where['customers']=session('userid');
			}
			$where['_string']="(UNIX_TIMESTAMP(addtime)>$starttime and UNIX_TIMESTAMP(addtime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,saleid')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['saleid'],$array_flip)){
					$data['saleid']='other';	
				}
				if($data['state']!=1){
					$CountState[$data['saleid']][$data['state']]++;
					$CountAllState[$data['state']]++;
				}
				$CountZong[$data['saleid']]++;
				$CountData++;
			}
		}else{
			if(session('power')==4){
				$where['customers']=session('userid');
			}
			$where['_string']='1=1';
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,saleid')->where($where)->select();
			//echo $m->_sql().session('power');
			foreach($datainfor as $data){
				if(!in_array($data['saleid'],$array_flip)){
					$data['saleid']='other';	
				}
				$CountState[$data['saleid']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['state']==1){
					$CountValid[$data['saleid']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
				$CountZong[$data['saleid']]++;
			}
			$CountData=count($datainfor);
		}
		
		$this->assign('act',3);
		$this->assign('salearr',$salearr);
		$this->assign('cusarr',cusarr());
		$this->assign('saletocarr',saletocarr());
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('CountValid',$CountValid);
		$this->assign('CountState',$CountState);
		$this->assign('CountZong',$CountZong);
		$this->assign('CountData',$CountData);
		$this->assign('CountAllValid',$CountAllValid);
		$this->assign('CountAllState',$CountAllState);
		$this->display('index');
	}
	
	//媒体效果
	public function media(){
		$m=M('datainfor');
		$starttime=$this->_post('starttime');
		$endtime=$this->_post('endtime');
		$medialist=medialist();
		$medialist['other']='其他';
		$array_flip=array_flip($medialist);
		
		if($starttime and $endtime){
			$this->assign('starttime',$starttime);
			$this->assign('endtime',$endtime);
			$starttime=strtotime($starttime);
			$endtime=strtotime($endtime.' 23:59:59');
			
			//有效(待定、跟进中、死单)
			$where['state']=1;
			$where['validtime']=array(array('gt',$starttime),array('lt',$endtime));
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,source')->where($where)->select();
			foreach($datainfor as $data){
				$CountState[$data['source']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['valid']==0 or $data['valid']==1 or $data['valid']==4){
					if(!in_array($data['source'],$array_flip)){
						$data['source']='other';	
					}
					$CountValid[$data['source']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
			}
			//进店
			unset($where);
			$where['state']=1;
			$where['_string']="(UNIX_TIMESTAMP(incustime)>=$starttime and UNIX_TIMESTAMP(incustime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,source')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['source'],$array_flip)){
					$data['source']='other';	
				}
				$CountValid[$data['source']][2]++;
				$CountAllValid[2]++;
			}
			//订单
			unset($where);
			$where['state']=1;
			$where['_string']="(UNIX_TIMESTAMP(suretime)>=$starttime and UNIX_TIMESTAMP(suretime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,source')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['source'],$array_flip)){
					$data['source']='other';	
				}
				$CountValid[$data['source']][3]++;
				$CountAllValid[3]++;
			}
			
			//其他
			unset($where);
			//$where['state']=array('neq',1);
			$where['_string']="(UNIX_TIMESTAMP(addtime)>$starttime and UNIX_TIMESTAMP(addtime)<$endtime)";
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,source')->where($where)->select();
			foreach($datainfor as $data){
				if(!in_array($data['source'],$array_flip)){
					$data['source']='other';	
				}
				if($data['state']!=1){
					$CountState[$data['source']][$data['state']]++;
					$CountAllState[$data['state']]++;
				}
				$CountZong[$data['source']]++;
				$CountData++;
			}
		}else{
			$datainfor=$m->field('valid,state,validtime,suretime,incustime,source')->select();
			foreach($datainfor as $data){
				if(!in_array($data['source'],$array_flip)){
					$data['source']='other';	
				}
				$CountState[$data['source']][$data['state']]++;
				$CountAllState[$data['state']]++;
				if($data['state']==1){
					$CountValid[$data['source']][$data['valid']]++;
					$CountAllValid[$data['valid']]++;
				}
				$CountZong[$data['source']]++;
			}
			$CountData=count($datainfor);
		}
		
		$this->assign('act',4);
		$this->assign('medialist',$medialist);
		$this->assign('states',states());
		$this->assign('valids',valids());
		$this->assign('CountValid',$CountValid);
		$this->assign('CountState',$CountState);
		$this->assign('CountZong',$CountZong);
		$this->assign('CountData',$CountData);
		$this->assign('CountAllValid',$CountAllValid);
		$this->assign('CountAllState',$CountAllState);
		$this->display('index');
	}
	
	
}