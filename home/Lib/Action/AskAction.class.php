<?php
class AskAction extends CommonAction {
	public $power=3;
	public $askdir=2;
	public function index(){
	   $m=M('datauser');
	   $where['power']=array($this->power,$this->askdir,'or');
	   $where['isdel']=0;
	   $data=$m->where($where)->order('id asc')->select();
	  // echo $m->_sql();
	   $this->assign('data',$data);
	   $this->assign('act',1);
	   $this->display();
    }
	
	public function adddata(){
		$m=M('datauser');
		$where['power']=4;
	   	$where['isdel']=0;
	   	$data=$m->where($where)->order('id asc')->select();
	   	$this->assign('data',$data);
		$this->assign('act',2);
		$this->display('index');
	}
    public function adduser(){
		$data['username']=$this->_post('username');
		$data['password']=$this->_post('password');
		$powerk=$this->_post('powerk');
		if($powerk){
			$data['power']=$this->askdir;	
		}else{
			$data['power']=$this->power;		
		}
		
		if(!$data['username'] or !$data['password'] or strlen($data['password'])<6){
			$this->show('<script>alert("请填写账号密码,密码不少于6位！");history.go(-1)</script>');
			exit();
		}
		
		$bindcus=$this->_post('bindcus');
		$data['bindcus']=implode(',',$bindcus);
		$data['addtime']=date('Y-m-d H:i:s');
		if($this->_post('allowlogin')){
			$data['allowlogin']=1;
		}else{
			$data['allowlogin']=0;
		}
		$m=M('datauser');
		$where['username']=$data['username'];
		$count=$m->where($where)->count();
		if($count>=1){//判断用户名是否重复
			$this->show('<script>alert("用户名已存在，请更换");history.go(-1)</script>');
			exit();	
				
		}
		$data['password']=md5($this->_post('password'));
		$back=$m->add($data);
		if($back){
			$this->success('添加成功',U('Ask/index'));
		}else{
			$this->success('添加失败',U('Ask/index'));
		}
    }
	public function editdata(){
		$id=$this->_get('id');
		$m=M('datauser');
		$where['power']=array($this->power,$this->askdir,'or');
		$user=$m->where($where)->find($id);
		$bindcus=explode(',',$user['bindcus']);
		foreach($bindcus as $bindcus_temp){
			$bc[$bindcus_temp]=$bindcus_temp;
		}
		unset($where);
		$where['power']=4;
	   	$where['isdel']=0;
	   	$data=$m->where($where)->order('id asc')->select();
		
		$this->assign('bindcus',$bindcus);
		$this->assign('bc',$bc);
		$this->assign('data',$data);
		$this->assign('user',$user);
		$this->assign('act',3);
		$this->display('index');
		
    }
	public function edituser(){
		$id=$this->_post('id');
		$data['username']=$this->_post('username');
		
		if(!$data['username']){
			$this->show('<script>alert("请填写账号信息！");history.go(-1)</script>');
			exit();
		}
		
		if($this->_post('password')){
			if(strlen($this->_post('password'))<6){
				$this->show('<script>alert("密码不少于6位！");history.go(-1)</script>');
				exit();
			}
			$data['password']=md5($this->_post('password'));
		}
		if($this->_post('allowlogin')){
			$data['allowlogin']=1;
		}else{
			$data['allowlogin']=0;
		}
		$m=M('datauser');
		$where['username']=$data['username'];
		$where['id']=array('neq',$id);
		$count=$m->where($where)->count();
		if($count>=1){//判断用户名是否重复
			$this->show('<script>alert("用户名已存在，请更换");history.go(-1)</script>');
			exit();	
				
		}
		$bindcus=$this->_post('bindcus');
		$data['bindcus']=implode(',',$bindcus);
		$powerk=$this->_post('powerk');
		if($powerk){
			$data['power']=$this->askdir;	
		}else{
			$data['power']=$this->power;		
		}
		$back=$m->where("id=$id")->save($data);
		if($back){
			$this->success('编辑成功',U('Ask/index'));
		}else{
			$this->success('编辑失败',U('Ask/index'));
		}
    }
	
	public function deluser(){
		$m=M('datauser');
		$id=$this->_get('id');
		$data['isdel']=1;
		$back=$m->where("id=$id")->save($data);
		
		if($back){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
}