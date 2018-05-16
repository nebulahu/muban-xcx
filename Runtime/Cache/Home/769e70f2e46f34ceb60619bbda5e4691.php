<?php if (!defined('THINK_PATH')) exit();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$the_host = $_SERVER['HTTP_HOST']; $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''; if($the_host == 'wczlpet.com') { header('HTTP/1.1 301 Moved Permanently'); header('Location: http://www.wczlpet.com/'); } ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?>-<?php echo C('COMPANY_NAME');?></title>
<meta content="<?php echo ($keywords); ?>" name="keywords" />
<meta content="<?php echo ($description); ?>" name="description" />
<link rel="shortcut icon" href="/favicon.ico">
<link rel="bookmark" href="/favicon.ico">
<script type="text/javascript" src="http://webmonkey.d17.cc/js/jquery/jquery/1.8.3/jquery.js"></script>
<script type="text/javascript" src="http://webmonkey.d17.cc/js/jquery/focus/jquery.slides.js"></script>
<link rel="stylesheet" href="http://webmonkey.d17.cc/template/weichong/pc/css/dist/weichong.pc.min.css">
</head>
<body>
	<div class="module_header">
		<div class="main clr">
			<a href="/" class="link_logo">
				<img src="http://webmonkey.d17.cc/template/weichong/pc/images/logo.png" alt="南昌卫宠宠物诊疗中心" class="pic_logo" />
			</a>
			<div class="right_nav" id="moduleNav">
				<a href="\" class="link">
					<div class="text">首页</div>
					<div class="word">HOME</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=53');?>" class="link">
					<div class="text">关于卫宠</div>
					<div class="word">ABOUT US</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=54');?>" class="link">
					<div class="text">卫宠医疗</div>
					<div class="word">Medical</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=55');?>" class="link">
					<div class="text">卫宠美容</div>
					<div class="word">Beauty</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=62');?>" class="link">
					<div class="text">卫宠用品</div>
					<div class="word">product</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=57');?>" class="link">
					<div class="text">卫宠公益</div>
					<div class="word">public</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=58');?>" class="link">
					<div class="text">医疗团队</div>
					<div class="word">TEAM</div>
					<div class="mask"></div>
				</a>
				<a href="<?php echo U('Article/lists?category=59');?>" class="link">
					<div class="text">联系我们</div>
					<div class="word">call us</div>
					<div class="mask"></div>
				</a>
			</div>
		</div>
	</div>

	<?php echo W('Category/banner',array('banner'));?>

<div class="index_scrnews">
    <div class="main clr">
        <div class="left_text">最新资讯：</div>
        <div class="txtScroll-top">
            <div class="bd">
                <ul class="infoList">
                	<?php $categoryids=55;$__LIST__ = D('Document')->page(!empty($_GET["p"])?$_GET["p"]:1,10)->lists($categoryids, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Article/detail?id='.$vo['id']);?>" target="_blank" class="a_hidden"><?php echo ($vo["title"]); ?></a><span class="date"><?php echo (date('Y-m-d',$vo["create_time"])); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    
                </ul>
            </div>
        </div>
        
    </div>
</div>
	<div class="pageindex_list1">
		<div class="main">
			<img src="http://webmonkey.d17.cc/template/weichong/pc/images/titlepic1.png" alt="" class="page-title-style" />
			<img src="http://webmonkey.d17.cc/template/weichong/pc/images/bage1.png" alt="" class="bage" />
			<?php $article =M("Document")->alias("__DOCUMENT")->where("status=1 AND __DOCUMENT.id=109")->order("level desc,create_time desc")->join("INNER JOIN __DOCUMENT_ARTICLE__ ON __DOCUMENT.id = __DOCUMENT_ARTICLE__.id")->field("*")->find();?><div class="cen_box clr">
				<a href="javascript:void(0);" class="left_link">
					<img src="<?php echo (get_cover($article['cover_id'],'path')); ?>" alt="" class="pic" />
				</a>
				<div class="right_box">
					<div class="text">
						<?php echo ($article['content']); ?>
					</div>
					
					<a href="<?php echo U('Article/lists?category=53');?>" class="index-linkmore-style clr"  target="_blank">
						<div class="inner_left">
							<div class="inn_te1">查看更多</div>
							<div class="inn_te2">view more</div>
						</div>
						<div class="inner_line"></div>
						<div class="icon_arr2"></div>
						<div class="icon_arr"></div>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="pageindex_list2">
		<img src="http://webmonkey.d17.cc/template/weichong/pc/images/titlepic2.png" alt="" class="page-title-style">
		<div class="main">
		<img src="http://webmonkey.d17.cc/template/weichong/pc/images/bage2.png" alt="" class="bage_pic" />
			<div class="picScroll-left">
				<div class="bd">
					<ul class="picList">
                    	<?php $categoryids=53;$__LIST__ = D('Document')->page(!empty($_GET["p"])?$_GET["p"]:1,6)->lists($categoryids, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="background:url(<?php echo (get_cover($vo["cover_id"],'path')); ?>) no-repeat top center;">
							<a href="<?php echo U('Article/lists?category=53');?>" target="_blank" class="link_box"  target="_blank">
								<div class="top_box">
									<div class="text a_hidden"><span>南昌卫宠</span>宠物诊疗中心</div>
									<div class="word a_hidden">NanChang WeiChong Pet clinic</div>
								</div>
								<div class="bottom_box">
									<div class="tit a_hidden"><?php echo ($vo["title"]); ?></div>
									<div class="wirt"><?php echo (msubstr($vo["description"],0,80)); ?></div>
								</div>
							</a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
						
					</ul>
				</div>
				<div class="hd">
					<a class="next"></a>
					<ul></ul>
					<a class="prev"></a>
				</div>
			</div>

		</div>
	</div>

	<div class="pageindex_list3">
		<img src="http://webmonkey.d17.cc/template/weichong/pc/images/titlepic3.png" alt="" class="page-title-style">
		<div class="main clr">
        	<?php $categoryids=54;$__LIST__ = D('Document')->page(!empty($_GET["p"])?$_GET["p"]:1,4)->lists($categoryids, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Article/lists?category=54');?>" class="link"  target="_blank">
				<div class="con">
					<div class="title clr">
						<i class="icon_l"></i>
						<div class="text_t"><?php echo ($vo["title"]); ?></div>
						<div class="word_r"><?php echo ($vo["engname"]); ?></div>
					</div>
					<div class="line"></div>
					<div class="text">
						<?php echo (msubstr($vo["description"],0,100)); ?>
					</div>
				</div>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</div>
	</div>

	<div class="pageindex_list4">
		<img src="http://webmonkey.d17.cc/template/weichong/pc/images/titlepic4.png" alt="" class="page-title-style">
		<div class="main">
			<a href="<?php echo U('Article/lists?category=58');?>" class="index-linkmore-style clr" target="_blank">
				<div class="inner_left">
					<div class="inn_te1">查看更多</div>
					<div class="inn_te2">view more</div>
				</div>
				<div class="inner_line"></div>
				<div class="icon_arr2"></div>
				<div class="icon_arr"></div>
			</a>
			<div id="slideBox2" class="slideBox2">
				<div class="bd">
					<ul>
                    	<?php $__POSLIST__ = D('Document')->position(4,58,null,true); if(is_array($__POSLIST__)): $i = 0; $__LIST__ = $__POSLIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
							<a href="<?php echo U('Article/detail','id='.$vo['id']);?>" target="_blank" class="lift_link">
								<img src="<?php echo (get_cover($vo["cover_id"],'path')); ?>" alt="<?php echo ($vo["title"]); ?>" class="pic" />
							</a>
							<div class="right_text">
								<a href="<?php echo U('Article/detail','id='.$vo['id']);?>" target="_blank" class="name"><?php echo ($vo["title"]); ?></a>
                                <?php $info = D('Document')->detail($vo['id']);?>
								<div class="job"><?php echo ($info['job']); ?></div>
								<div class="info_text"><?php echo (msubstr($info['content'],0,60)); ?></div>
								<div class="info_wrod"><?php echo ($vo["description"]); ?></div>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
						
					</ul>
				</div>

				<!-- 下面是前/后按钮代码，如果不需要删除即可 -->
				<a class="prev" href="javascript:void(0)"></a>
				<a class="next" href="javascript:void(0)"></a>

			</div>

		</div>
	</div>

	<div class="pageindex_list5 clr">
		<img src="http://webmonkey.d17.cc/template/weichong/pc/images/titlepic5.png" alt="" class="page-title-style">
		<div class="pet_articles_list clr">
        	<?php $categoryids = D('Category')->getChildrenId(56);$__LIST__ = D('Document')->page(!empty($_GET["p"])?$_GET["p"]:1,4)->lists($categoryids, '`level` DESC,`id` DESC', 1,true); if(is_array($__LIST__)): $i = 0; $__LIST__ = $__LIST__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Article/detail','id='.$vo['id']);?>" class="link_list" target="_blank">
				<div class="pic_box">
					<img src="<?php echo (get_cover($vo["cover_id"],'path')); ?>" alt="<?php echo ($vo["title"]); ?>" class="pic" />
				</div>
				<div class="text_box">
					<div class="text"><?php echo ($vo["title"]); ?></div>
					<div class="word"><?php echo ($vo["engname"]); ?></div>
				</div>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</div>

		<a href="<?php echo U('Article/lists?category=62');?>" class="index-linkmore-style clr" target="_blank">
			<div class="inner_left">
				<div class="inn_te1">查看更多</div>
				<div class="inn_te2">view more</div>
			</div>
			<div class="inner_line"></div>
			<div class="icon_arr2"></div>
			<div class="icon_arr"></div>
		</a>
	</div>
	
	<div class="module_footer">
		<div class="main clr">
			<div class="left_box">
				<div class="title_text"><span>南昌卫宠</span>宠物诊所</div>
				<div class="title_word">NanChang WeiChong Pet clinic</div>
				<div class="con_box clr">
                	<?php $wei = C('COMPANY_IMGCODE');?>
					<img src="<?php echo (get_cover($wei,'path')); ?>" alt="" class="code" />
					<div class="text_info">
						<div class="lis clr">
							<div class="le">地址：</div>
							<div class="ri"><?php echo C('COMPANY_ADDRESS');?></div>
						</div>
						<div class="lis clr">
							<div class="le">电话：</div>
							<div class="ri"><?php echo C('CONTACT_PHONE');?>	</div>
						</div>
                        <div class="lis clr">
							<div class="le">友情链接：<?php if(is_array($link)): $i = 0; $__LIST__ = $link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="link" href="<?php echo ($vo["link"]); ?>" target="_blank"><?php echo ($vo["title"]); ?>	</a><?php endforeach; endif; else: echo "" ;endif; ?></div>
						</div>
					</div>
				</div>
			</div>
			<?php echo W('Category/comment');?>
		</div>
		<div class="last_text">2011-2017 Copyright © 第一枪 版权所有<?php echo C('WEB_SITE_ICP');?></div>
	</div>
</body>
<script src="http://webmonkey.d17.cc/js/layer/layer/layer.js"></script>
<script src="http://webmonkey.d17.cc/js/jquery/vaildform/vaildform.js"></script>
<script src="http://webmonkey.d17.cc/template/weichong/pc/js/dist/weichong.pc.min.js"></script>
<script>
weichong.moduleAll(0);
$(".slideBox2").slide({mainCell:".bd ul"});
/*特色轮播*/
$(".picScroll-left").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:true,vis:4,delayTime:700,mouseOverStop:true});
/*新闻滚动*/
		$(".txtScroll-top").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true,easing:"easeInQuint",delayTime:700});

</script>
</html>