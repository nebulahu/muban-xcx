<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Widget;
use Think\Controller;

/**
 * 分类widget
 * 用于动态调用分类信息
 */

class CategoryWidget extends Controller{
	
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($cate, $child = false){
		$field = 'id,name,pid,title,link_id';
		if($child){
			$category = D('Category')->getTree($cate, $field);
			$category = $category['_'];
		} else {
			$category = D('Category')->getSameLevel($cate, $field);
		}
		$this->assign('category', $category);
		$this->assign('current', $cate);
		$this->display('Category/lists');
	}
	//banner页面
	public function banner($group){
		$focus = D('Addons://Focus/Focus')->getList($group);
		$this->assign('focus',$focus);
		$this->display('Category/banner');
	}
	//留言页面
	public function comment(){
		$action = addons_url('Common://Common/index');
		$this->assign('action',$action);
		$this->display('Category/comment');
	}
	
	
}
