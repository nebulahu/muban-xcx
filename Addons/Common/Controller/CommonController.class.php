<?php

namespace Addons\Common\Controller;
use Home\Controller\AddonsController;

class CommonController extends AddonsController{

    public function index(){
		$data=array();
		if(empty($_POST['content'])){
			$data=array('status'=>0,'message'=>'请填写留言内容');
			$this->ajaxReturn($data);exit;
		}
		//dump($_POST);exit;
     	$list=M('common');
		$info['username'] = $_POST['username'];
		$info['phone'] = $_POST['phone'];
		//$info['address'] = $_POST['address'];
		//$info['gid'] = $_POST['gid'];
		//$info['email'] = $_POST['email'];
		//$info['ip'] = get_client_ip();
		$info['time'] = date('Y-m-d H:i:s',time());
		$info['content'] = $_POST['content'];
		//dump($info);exit;
		if($list->add($info)){
			$data=array('status'=>1,'message'=>'留言成功');
		}else{
			$data=array('status'=>0,'message'=>'留言失败');
		}
		$this->ajaxReturn($data);
    }
}
