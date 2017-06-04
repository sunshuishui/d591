<?php
class ImportAction extends CommonAction {
	public function index(){
		$this->display();
	}
	public function imp(){
		$m=M('datainfor');
		$tdata=nl2br($this->_post('tdata'));
		$tdata=explode('<br />',$tdata);
		$i=0;
		foreach($tdata as $tdata_temp){
			$single=explode('	',$tdata_temp);
			unset($data);
			$data['id']=$single[0];
			$data['addtime']=$single[1];
			$data['state']=$single[2];
			if($data['state']==4){//如果是有效的话
				$data['validtime']=strtotime($single[1]);
			}
			$data['valid']=$single[3];
			if($data['valid']==3){//如果是订单的话
				$data['suretime']=$single[1];
				$data['sale']=14;
				$data['salecustomer']=1;
			}
			$data['bname']=$single[4];
			if(ismobile($single[5])){
				$data['bmobile']=sjiami($single[5]);	
			}else{
				$data['omobile']=$single[5];		
			}
			/*if(ismobile($single[12])){
				$data['gmobile']=sjiami($single[12]);	
			}else{
				$data['emobile']=$single[12];		
			}*/
			$data['needs']='#1#';
			$data['firstsrc']=$single[7];
			$data['firstsrctime']=$single[1];
			if($single[10]==1){	//如果是到馆
				$data['daoguan']=strtotime($single[1]);
			}
			$data['serviceid']=$single[11];
			$data['desk']=$single[15];
			$back=$m->add($data);
			if($back){
				$i++;
				unset($incus);
				if($single[10]==1){
					$incus['dataid']=$back;
					$incus['cusid']=1;
					$incus['incusdate']=strtotime($single[1]);
					M('incus')->add($incus);
				}
				unset($note);
				$note[]=array('serviceid'=>1,'dataid'=>$back,'note'=>'导入','addtime'=>date('Y-m-d H:i:s'),'type'=>1);
				if($single[6]){
					$note[]=array('serviceid'=>$single[11],'dataid'=>$back,'note'=>'婚期（'.$single[6].'）','addtime'=>$single[1],'type'=>1);
				}
				if($single[8]){
					$note[]=array('serviceid'=>$single[11],'dataid'=>$back,'note'=>'新人回访：'.$single[8],'addtime'=>$single[1],'type'=>1);
				}
				if($single[9]){
					$note[]=array('serviceid'=>$single[11],'dataid'=>$back,'note'=>'二次回访：'.$single[9],'addtime'=>$single[1],'type'=>1);
				}
				if($single[12]){
					$note[]=array('serviceid'=>$single[11],'dataid'=>$back,'note'=>'销售回复：'.$single[12],'addtime'=>$single[1],'type'=>1);
				}
				if($single[13]){
					$note[]=array('serviceid'=>$single[11],'dataid'=>$back,'note'=>'未到馆原因：'.$single[13],'addtime'=>$single[1],'type'=>1);
				}
				if($single[14]){
					$note[]=array('serviceid'=>$single[11],'dataid'=>$back,'note'=>'未订单原因：'.$single[14],'addtime'=>$single[1],'type'=>1);
				}
				M('servicenote')->addall($note);
			}else{
				echo $single[0].'<br />';
			}
		}
		echo '导入成功'.$i.'条！';
	}
	public function del(){
		$id=(int)$this->_post('id');
		if($id){
			$m=M('datainfor');
			$back=$m->delete($id);
		}
		if($back){
			echo '已删除！';	
		}else{
			echo '删除失败！';	
		}
	}
	public function chongfu(){
		
	}
}