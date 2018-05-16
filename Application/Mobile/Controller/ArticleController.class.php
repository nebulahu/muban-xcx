<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Mobile\Controller;

/**
 * 文档模型控制器
 * 文档模型列表和详情
 */
class ArticleController extends HomeController {

    /* 文档模型频道页 */
	public function index(){
		/* 分类信息 */
		$category = $this->category();

		//频道页只显示模板，默认不读取任何内容
		//内容可以通过模板标签自行定制

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->display($category['template_index']);
	}

	/* 文档模型列表页 */
	public function lists($p = 1){
		/* 分类信息 */
		$category = $this->category();
		/* 获取当前分类列表 */
		$Document = D('Document');
		//$child = D('Category')->getChildrenId($category['id']);
		//if($child != $category['id']){
			
		//	$list = $Document->page($p, $category['list_row'])->lists($child);

		//}else{
			$list = $Document->page($p, $category['list_row'])->lists($category['id']);
		//}
		
		if(false === $list){
			$this->error('获取列表数据失败！');
		}

		if (!empty($category['template_lists'])){ //分类已定制模板
			$tmpl = $category['template_lists'];
		} else{
			$tmpl = 'list-news';
		}
		$page = ceil(count($list) / $category['list_row']);
		$nowpage = 2;
		$this->assign('page',$page);
		$this->assign('nowpage',$nowpage);
		//dump($category);
		//dump($list);
		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->assign('cid', $category['id']);
		$this->assign('list', $list);
		//TDK
		$tdk=M('category')->where('id='.$category['id'])->find();
		$description = $tdk['description'];
		
		if(!empty($tdk['meta_title']) && !empty($tdk['keywords'])){
			$title = $tdk['meta_title'];
			$keywords = $tdk['keywords'];
			
		}else{
			$title = $tdk['title'];
			$keywords = $tdk['title'];
		}
		$this->assign('title',$title);
		$this->assign('description',$description);
		$this->assign('keywords',$keywords);
		
		$this->display($tmpl);
	}

	/* 文档模型详情页 */
	public function detail($id = 0, $p = 1){
		/* 标识正确性检测 */
		if(!($id && is_numeric($id))){
			$this->error('文档ID错误！');
		}

		/* 页码检测 */
		$p = intval($p);
		$p = empty($p) ? 1 : $p;

		/* 获取详细信息 */
		$Document = D('Document');
		$info = $Document->detail($id);
		if(!$info){
			$this->error($Document->getError());
		}
		
		/* 分类信息 */
		$category = $this->category($info['category_id']);

		/* 获取模板 */
		if(!empty($info['template'])){//已定制模板
			$tmpl = $info['template'];
		} elseif (!empty($category['template_detail'])){ //分类已定制模板
			$tmpl = $category['template_detail'];
		} else{
			$tmpl = 'show-news';
		}
		//else { //使用默认模板
		//	$tmpl = 'Article/'. get_document_model($info['model_id'],'name') .'/detail';
		//}

		/* 更新浏览数 */
		$map = array('id' => $id);
//		$Document->where($map)->setInc('view');

		/* 模板赋值并渲染模板 */
		$this->assign('category', $category);
		$this->assign('info', $info);
		$this->assign('page', $p); //页码
		//TDK
		$tdk = M('document')->where('id='.$id)->find();
		$tdkt = M('category')->where('id='.$tdk['category_id'])->find();
		if(!empty($tdk['meta_title']) && !empty($tdk['description'])){
			$title = $tdk['meta_title'].'-'.$tdkt['title'];
			$description= $tdk['description'];
		}else{
			$title = $tdk['title'].'-'.$tdkt['title'];
			$description = mb_substr($tdk['description'],'1,80','utf-8');
		}	
		$keywords = $tdk['keywords'];
		$this->assign('title',$title);
		$this->assign('description',$description);
		$this->assign('keywords',$keywords);
		$this->display($tmpl);
	}

	/* 文档分类检测 */
	private function category($id = 0){
		/* 标识正确性检测 */
		$id = $id ? $id : I('get.category', 0);
		if(empty($id)){
			$this->error('没有指定文档分类！');
		}

		/* 获取分类信息 */
		$category = D('Category')->info($id);
		if($category && 1 == $category['status']){
			switch ($category['display']) {
				case 0:
					$this->error('该分类禁止显示！');
					break;
				//TODO: 更多分类显示状态判断
				default:
					return $category;
			}
		} else {
			$this->error('分类不存在或被禁用！');
		}
	}
	//分页数据
	public function doconsult(){
		$cate = I('post.category');
		$category = D('Category')->getChildrenId($cate);
			/* 获取当前分类列表 */
		$p = I('post.page','');
		//dump($p);exit;
		$Document = D('Document');
		$list = $Document->page($p, 10)->lists($category);
		
		if(empty($list)){
			$data=array('success'=>0);
			$this->ajaxReturn($data);exit;
		}
		
		foreach($list as $key=>$value){
		  $arr[$key]['title']=$value['title'];
		  $arr[$key]['src']=get_cover($value['cover_id'],'path');
		  $arr[$key]['date']=date('Y-m-d',$value['create_time']);
		  $arr[$key]['description'] = msubstr($value['description'],0,30);
		  $arr[$key]['url']=U('Article/detail','id='.$value['id']);
		  
		}
		//dump($arr);exit;
		$data=array('success'=>1,'list'=>$arr);
		
	  // dump($data);exit;
		$this->ajaxReturn($data);
  }
  
	//留言
	public function comment(){
		$action = addons_url('Common://Common/index');
		$this->assign('action',$action);
		$this->display();
	}
	//地图
	public function map(){
		$this->display();	
	}
	
}
