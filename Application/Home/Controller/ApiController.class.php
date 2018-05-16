<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends HomeController {
    public function getBanner(){

        $group = I('group');
        $focus = D('Addons://Focus/Focus')->getList($group);
        $this->ajaxReturn($focus);
    }
    public function getCateList(){
        $Category_model = D('Category');
        $data = $Category_model->getTree();

		//$data = $this->getCateImg($data);
//        foreach ($data as $key => $value){
//            $data[$key]['pic'] = get_cover($value['icon'],'path');
//            if($value['_']){
//                foreach($value['_'] as $k => $v){
//                    $data[$key]['_'][$k]['pic'] = get_cover($v['icon'],'path');
//                }
//            }
//        }
        $data = $this->recuCate($data);
        $this->ajaxReturn($data);
    }
    /*
     * 递归获取栏目图片
     * 2018年4月3日
     * param $reArr 栏目数组
     * */
    public function recuCate(&$reArr){
        if(empty($reArr)){
            $reArr['_']['pic'] = get_cover($reArr['icon'],'path');
        }else{
            foreach ($reArr as $key => $value){
                $reArr[$key]['pic'] = get_cover($value['icon'],'path');
                if($value['_']){
                    $reArr[$key]['_'] = $this->recuCate($value['_']);
                }
            }
        }
        return $reArr;
    }
    public function getArticleList(){


        $map = array();
        $map['page'] = I('post.page',1);
        $map['limit'] = I('post.limit',10);
        $map['cateId'] = I('post.cateId');

        $map['order'] = I('post.order','`id` DESC');
        $map['pos'] = I('post.pos');

        $expand = I('post.expand');

        $data = $this->getArticleListModel($map['cateId'],$map['order'],$map['page'],$map['limit'],$map['pos'],$expand);
        $this->ajaxReturn($data);
    }

    public function getArticleDetail(){
        $Document_model = D('Document');
        $map = array();
        $map['id'] = I('post.id');
        $data = $Document_model->detail($map['id']);
        if($data){
            $data['duotu'] = trim($data['duotu'],',');

            $images = explode(',',$data['duotu']);

            if($images){
                foreach($images as $k=>$v){
                    $data['duotu_arr'][$k] = get_cover($v,'path');
                }

            }
            if($data['cover_id']){
                $data['cover_img'] = get_cover($data['cover_id'],'path');
            }

        }
        $this->ajaxReturn($data);
    }
    //获取公司基本信息
    public function getCompanyBaseInfo(){
        $map = array();
        $map['fields'] = I('post.fields');
        $fields = explode(',',$map['fields']);
        $data = array();
        foreach($fields as $v){
            if($v == 'COMPANY_LOGO' || $v == 'COMPANY_IMGCODE'){
                $imgsrc = get_cover(C("{$v}"),'path');
                $data[$v] = $imgsrc;
            }else{
                $data[$v] = C("{$v}");
            }
        }
        $this->ajaxReturn($data);
    }
    //地图坐标
    public function getMap(){
        /** $Addons_model = D('Addons');
        $info = $Addons_model->where('id=25')->find();
        $data = array();
        if(!empty($info['config'])){
        $tmp = json_decode($info['config'],true);
        $data['longitude'] = $tmp['longitude'];
        $data['latitude'] = $tmp['latitude'];
        }**/
        $tmp = explode(',',C('TEN_MAP'));

        $data['latitude'] = $tmp[0];
        $data['longitude'] = $tmp[1];
        $this->ajaxReturn($data);
    }
	//第二个地图坐标
	public function getSecondMap(){

        $tmp = explode(',',C('TEN_MAP_SECOND'));

        $data['latitude'] = $tmp[0];
        $data['longitude'] = $tmp[1];
        $this->ajaxReturn($data);
    }


    private function getArticleListModel($category, $order = '`id` DESC',$page = 1,$limit = 10,$pos = null,$expand = '' ,$status = 1 ,$field = true){
        $Document_model = D('Document');
        $map = $this->listMap($category,1,$pos);
        $data = array();
        $data['list'] = $Document_model->field($field)->where($map)->page($page, $limit)->order($order)->select();
        $data['listCount'] = $Document_model->where($map)->count('id');
        //dump($data);exit;

        if(!empty($data['list'])){
            foreach($data['list'] as $k=>$v){
                $data['list'][$k]['cover_img'] = get_cover($v['cover_id'],'path');

                if(!empty($expand)){

                    $data['list'][$k]['expand'] = $this->getFieldByAid($v['id'],$v['model_id'],$expand);

                }
            }


        }
        $data['listPageCount'] = 0;
        if($data['listCount']>0){
            $data['listPageCount'] = ceil($data['listCount']/$limit);
        }
        return $data;
    }
    private function listMap($category, $status = 1, $pos = null){
        /* 设置状态 */
        $map = array('status' => $status, 'pid' => 0);

        /* 设置分类 */
        //if(!is_null($category)){
        //    if(is_numeric($category)){
        //        $map['category_id'] = $category;
        //    } else {
        //        $map['category_id'] = array('in', str2arr($category));
        //    }
        //}

        /* 设置分类  做了一级栏目存在二级栏目的处理 */
        if(!is_null($category)){
            if(is_numeric($category)){
                //$categoryids = D('Category')->getChildrenId($category);
                
				$categoryids = D('Category')->getTree($category);
			    $categoryids = $this->getSonId($categoryids);
			   
			    $categoryids = trim($categoryids,',');
			   
				if(is_numeric($categoryids)){
                    $map['category_id'] = $categoryids;
                }else{
                    $map['category_id'] = array('in', str2arr($categoryids));
                }
            } else {
                $cate = str2arr($category);
                $categoryids = '';
                foreach($cate as $k => $v){
                    $categoryids .= D('Category')->getChildrenId($v);
                    $categoryids .= ',';
                }
                $categoryids = rtrim($categoryids, ",");
                $map['category_id'] = array('in', str2arr($categoryids));
            }
        }

        $map['create_time'] = array('lt', NOW_TIME);
        $map['_string']     = 'deadline = 0 OR deadline > ' . NOW_TIME;

        /* 设置推荐位 */
        if(is_numeric($pos)){
            $map[] = "position & {$pos} = {$pos}";
        }

        return $map;
    }

    //留言
    public function message(){
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
        $info['ip'] = get_client_ip();
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

    //获取模型字段
    private function getFieldByAid($id,$mid = 4,$field = '*'){
        if($id<1){
            return false;
        }
        $model = D('model')->where(array("id"=>$mid))->field('name')->find();

        $info = D("document_{$model['name']}")->where(array("id"=>$id))->field("{$field}")->find();
        if(empty($info)){
            return false;
        }

        if($field != '*' ){
            $arr = explode(',',$field);

        }
        return $info;
    }
	
	public function getSonId($categoryids,&$sonid){
		if(empty($categoryids['_'])){

			$sonid .= $categoryids['id'].',';
		}else{

			foreach($categoryids['_'] as $v){

				$this->getSonId($v,$sonid);

			}
			
		}
	    return $sonid;
	}
	
	
	/*
     * 小程序统一搜索
     * */
    public function search(){

        $keyword = I('post.keyword');
        $modelId = I('post.modelId','4');//2 文章 3 下载 4 产品 6 相册 默认产品
        $order = I('post.order','`level` DESC,`id` DESC');
        $page = I('post.page',1);
        $limit = I('post.limit',10);
        $expand = I('post.expand');
        $map['title'] = array('like',"%{$keyword}%");
        $map['model_id'] = $modelId;

        $list = $this->lists($map,$order,$page,$limit,$expand);
        //header("Content-Type:text/html;charset=utf-8");
        //dump($list);exit;
        $this->ajaxReturn($list);
    }

    private function lists($map,$order,$page,$limit,$expand){
        $now = ($page-1)*$limit;
        $document = D('Document');
        $count = $document->where($map)->count('id');
        $list = $document->where($map)->order($order)->limit($now,$limit)->select();
        foreach($list as $key => $value){
            $list[$key]['cover_img'] = get_cover($value['cover_id'],'path');
            if(!empty($expand)){
                $list[$key]['expand'] = $this->getFieldByAid($value['id'],$value['model_id'],$expand);
            }
        }
        $list['count'] = $count;
        return $list;
    }
	
	/*
     * 产品根据字段筛选
     * */
    public function getProductList(){

        $categoryId = I('post.categoryId');
        $order = I('post.order');
        $op = I('post.op');
        $modelId = I('post.modelId');
        $page = I('post.page',1);
        $limit = I('post.limit',10);
        $orderStr = ' a.`id` DESC,b.`level` DESC';
        $now = ($page-1)*$limit;
        if(!empty($categoryId)){
            $map['b.category_id']  = array('eq',$categoryId);
        }
        if(!empty($modelId)){
            $map['b.model_id']  = array('eq',$modelId);
        }
        if(!$modelId || !$categoryId){
            $this->ajaxReturn(array('message'=>'参数错误'));
        }
        $orderArr = explode(',',$order);
        if(sizeof($orderArr)-1){
            if($op == 'between'){
                $map[$orderArr[0]] = array($op,array($orderArr[1],$orderArr[2]));
            }else{
                $map[$orderArr[0]] = array($op,$orderArr[1]);
            }
        }else{
            $orderStr = $order.' '.$op.','.$orderStr;
        }
        $model = D('model')->where(array("id"=>$modelId))->field('name')->find();
        $modelName = $model['name'];
        $productlist = M("document_{$modelName} as a")
            ->join('RIGHT join onethink_document as b ON a.id = b.id')
            ->where($map)->order($orderStr)
            ->limit($now,$limit)
            ->select();
        foreach($productlist as $key => $value){
            $productlist[$key]['cover_img'] = get_cover($value['cover_id'],'path');
        }
        $total = count(M("document_{$modelName} as a")
            ->join('RIGHT join onethink_document as b ON a.id = b.id')
            ->where($map)->select());
        $product = array('productlist'=>$productlist,'total'=>$total);
        $this->ajaxReturn($product);
    }
}