<?php
class PannelAction extends CommonAction{
    public function index(){
        $this->display();
    }
	public function top(){
		$this->assign('username',$_SESSION['username']);
		$this->assign('power',$_SESSION['power']);
        $this->display();
    }
	public function left(){
		$this->assign('power',$_SESSION['power']);
		$this->assign('userid',$_SESSION['userid']);
		$this->assign('username',$_SESSION['username']);
        $this->display();
    }
	public function right(){
		$power=$_SESSION['power'];
		if($power==3){
			$where['asdid']=$_SESSION['userid'];	
		}elseif($power==4){
			$where['customers']=$_SESSION['userid'];	
		}elseif($power==5){
			$where['saleid']=$_SESSION['userid'];	
		}
		$where['_string']='1=1';
		$m=M('datainfor');
		$datainfor=$m->field('id,state,valid,incustime,suretime')->where($where)->select();
		$a=0;
		$b=0;
		$c=0;
		$d=0;
		foreach($datainfor as $datainfor_t){
			$a++;	
			if($datainfor_t['state']==1){	//有效
				$b++;	
			}
			if(strtotime($datainfor_t['incustime'])>0 and $datainfor_t['state']==1){	//进店
				$c++;	
			}
			if($datainfor_t['state']==1 and strtotime($datainfor_t['incustime'])>0){	//订单
				$d++;	
			}	
		}
		$this->assign('a',$a);
		$this->assign('b',$b);
		$this->assign('c',$c);
		$this->assign('d',$d);
        $this->display();
    }
	public function logout(){
     session('username',null);
	 $this->redirect('Login/login');
    }
}