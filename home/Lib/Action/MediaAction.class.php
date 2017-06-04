<?php
class MediaAction extends CommonAction {
	public function index(){
		$m=M('media_list');
		$data=$m->order('id asc')->select();
		$this->assign('data',$data);
		$this->display();
	}
	//添加媒体
	public function addmedia(){
		$m=M('media_list');
		$data['medianame']=$this->_post('medianame');
		$password=uniqid();
		$password=substr($password,7,6);
		$data['password']=$password;
		$data['addtime']=time();
		$backs=$m->add($data);
		if($backs){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
	
	//删除媒体
	public function delmedia(){
		$m=M('media_list');
		$id=$this->_get('id');
		$backs=$m->delete($id);
		if($backs){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
    }
}