<?php
class LoginAction extends Action {
	public function index(){
        $this->display('login');
    }
    public function login(){
        $this->display('login2');
    }
	public function verify(){
		import('ORG.Util.Image');
    	Image::buildImageVerify(4,1,'png',80,42,'verify');
    }
	public function dologin(){
        $username=$this->_post('username');
		$password=$this->_post('password');
		$yzcode=$this->_post('yzcode');
		if(!$username or !$password){
			$this->show('<script>alert("该用户不存在");history.back();</script>');
			exit();	
		}
		$verify =$_SESSION['verify'];
		if($verify!=md5($yzcode)){
			$this->show('<script>alert("验证码不正确");history.back();</script>');
			exit();
		}
		$user=M('datauser');
		$where['username']=$username;
		$where['password']=md5($password);
		$arr=$user->where($where)->find();
		if($arr){
			if($arr['allowlogin']!=1){
				$this->show('<script>alert("管理员已禁止该用户登录");history.back();</script>');
				exit();
			}
			session('username',$username);
			session('userid',$arr['id']);
			session('power',$arr['power']);
			session('bindcus',$arr['bindcus']);
			LogLogin($username);
			$this->redirect('Pannel/index');
		}else{
			$this->show('<script>alert("该用户不存在");history.back();</script>');
			exit();
		}
    }
}