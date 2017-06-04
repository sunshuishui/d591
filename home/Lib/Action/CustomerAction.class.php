<?php
class CustomerAction extends CommonAction {
	public $power=4;
	public $salepower=5;
	public function index(){
	   $m=M('datauser');
	   $where['power']=$this->power;
	   $where['isdel']=0;
	   $data=$m->where($where)->order('id asc')->select();
	   $this->assign('data',$data);
	   $this->assign('act',1);
	   $this->display();
    }
	
	public function adddata(){
		$this->assign('act',2);
		$this->display('index');
	}
    public function adduser(){
		$m=M('datauser');
		$data['customername']=$this->_post('customername');
		$data['username']=$this->_post('username');
		$data['password']=$this->_post('password');
		
		if(!$data['username'] or !$data['password'] or strlen($data['password'])<6){
			$this->show('<script>alert("请填写账号密码,密码不少于6位！");history.go(-1)</script>');
			exit();
		}
		
		
		$data['power']=$this->power;
		$data['addtime']=date('Y-m-d H:i:s');
		if($this->_post('allowlogin')){
			$data['allowlogin']=1;
		}else{
			$data['allowlogin']=0;
		}
		
		$where['username']=$data['username'];
		$count=$m->where($where)->count();
		if($count>=1){//判断用户名是否重复
			$this->show('<script>alert("用户名已存在，请更换");history.go(-1)</script>');
			exit();	
				
		}
		$data['password']=md5($this->_post('password'));
		$back=$m->add($data);
		if($back){
			$this->show("<script>alert('添加成功！');window.opener.location.reload();window.close();</script>");
		}else{
			$this->show("<script>alert('添加失败！');window.close();</script>");
		}
    }
	public function editdata(){
		$id=$this->_get('id');
		$m=M('datauser');
		$where['power']=$this->power;
		$user=$m->where($where)->find($id);
		$this->assign('user',$user);
		$this->assign('act',3);
		$this->display('index');
		
    }
	public function edituser(){
		$m=M('datauser');
		$id=$this->_post('id');
		$data['username']=$this->_post('username');
		$data['customername']=$this->_post('customername');
		if(!$data['username'] or !$data['customername']){
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
		$where['username']=$data['username'];
		$where['id']=array('neq',$id);
		$count=$m->where($where)->count();
		if($count>=1){//判断用户名是否重复
			$this->show('<script>alert("用户名已存在，请更换");history.go(-1)</script>');
			exit();	
				
		}
		$back=$m->where("id=$id")->save($data);
		if($back){
			$this->show("<script>alert('编辑成功！');window.opener.location.reload();window.close();</script>");
		}else{
			$this->show("<script>alert('编辑失败！');window.close();</script>");
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
	public function salelist(){
		$ownerid=$this->_get('ownerid');
		$customername=$this->_get('customername');
		$m=M('datauser');
		$where['power']=$this->salepower;
	   	$where['isdel']=0;
		$where['ownerid']=$ownerid;
	   	$data=$m->where($where)->order('id asc')->select();
	   	$this->assign('data',$data);
		$this->assign('ownerid',$ownerid);
		$this->assign('customername',$customername);
		$this->assign('act',4);
		$this->display('index');
	}
	public function addsale(){
		$ownerid=$this->_get('ownerid');
		$customername=$this->_get('customername');
		$this->assign('ownerid',$ownerid);
		$this->assign('customername',$customername);
		$this->assign('act',5);
		$this->display('index');
	}
	public function addsaledata(){
		$ownerid=$this->_post('ownerid');
		$data['username']=$this->_post('username');
		$data['password']=$this->_post('password');
		$data['ownerid']=$ownerid;
		if(!$data['username'] or !$data['password'] or !$data['ownerid'] or strlen($data['password'])<6){
			$this->show('<script>alert("请填写账号密码,密码不少于6位！");history.go(-1)</script>');
			exit();
		}
		
		
		$data['power']=$this->salepower;
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
			$this->show("<script>alert('添加成功！');window.opener.location.reload();window.close();</script>");
		}else{
			$this->show("<script>alert('添加失败！');window.close();</script>");
		}
	}
	public function editsale(){
		$id=$this->_get('id');
		$customername=$this->_get('customername');
		$m=M('datauser');
		$where['power']=$this->salepower;
		$user=$m->where($where)->find($id);
		$this->assign('user',$user);
		$this->assign('customername',$customername);
		$this->assign('act',6);
		$this->display('index');
	}
	public function editsaledata(){
		$id=$this->_post('id');
		$data['username']=$this->_post('username');
		if(!$data['username']){
			$this->show('<script>alert("请填写用户名！");history.go(-1)</script>');
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
		$back=$m->where("id=$id")->save($data);
		if($back){
			$this->show("<script>alert('编辑成功！');window.opener.location.reload();window.close();</script>");
		}else{
			$this->show("<script>alert('编辑失败！');window.close();</script>");
		}
	}
	public function ticket(){
		$id=$this->_get('id');
		$customername=$this->_get('customername');
		$m=M('datauser');
		$where['power']=$this->salepower;
		$user=$m->where($where)->find($id);
		if(!$user['openid']){
			//$ticket=get_qrcode($id);
		}
		$this->assign('ticket',$ticket);
		$this->assign('customername',$customername);
		$this->assign('user',$user);
		$this->assign('act',7);
		$this->display('index');
	}
	public function isband(){
		$id=$this->_post('id');
		$m=M('datauser');
		$where['id']=$id;
		$infor=$m->where($where)->find();
		if($infor['openid']){
			$this->ajaxReturn(1,0,1);
		}
	}
	public function canticket(){
		$id=$this->_get('id');
		$where['id']=$id;
		$m=M('datauser');
		$data['openid']='';
		$back=$m->where($where)->save($data);
		//exit($m->_sql());
		if($back){
			$this->success('解绑成功');
		}else{
			$this->success('解绑失败');
		}	
	}
}