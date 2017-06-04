<?php
class CommonAction extends Action{
    public function _initialize(){
 		//初始化的时候检查用户权限
		//echo $_SESSION['username'];
		if (!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['username']=='') {
			$this->redirect('Login/login');
		}
		
		
		//echo ACTION_NAME;
	
		//后台权限数组
		//1代表超级管理员
		//2代表鼠标手主管
		//3代表鼠标手
		//4代表商户
		//5代表网销
		$modulename=MODULE_NAME;
		$actionname=ACTION_NAME;
		$ma=$modulename.$actionname;
		//echo $ma;
		if($_SESSION['power']==2){
			if($modulename=='Media' or $modulename=='Customer' or $modulename=='Ask' or $ma=='Tablemedia'){
				$this->error('权限拒绝');	
			}
		}
		if($_SESSION['power']==3){
			if($modulename=='Media' or $modulename=='Customer' or $modulename=='Ask' or $modulename=='Table'){
				$this->error('权限拒绝');	
			}
		}
		if($_SESSION['power']==4){
			if($modulename=='Media' or $modulename=='Customer' or $modulename=='Ask' or $ma=='Memberadd' or $ma=='Tablemedia' or $ma=='Tableask' or $ma=='Tablecustomer'){
				$this->error('权限拒绝');	
			}
		}
		if($_SESSION['power']==5){
			if($modulename=='Media' or $modulename=='Customer' or $modulename=='Ask' or $modulename=='Table' or $ma=='Memberadd'){
				$this->error('权限拒绝');	
			}
		}
	}
}