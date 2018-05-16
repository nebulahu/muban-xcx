<?php if (!defined('THINK_PATH')) exit();?><div class="page_banners">
    <div class="slideBox" id="slideBox">
        <div class="hd">
            <ul>
            </ul>
        </div>
        <div class="bd">
            <ul>
            	<?php if(is_array($focus)): $i = 0; $__LIST__ = $focus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <a href="<?php echo ($vo["url"]); ?>" target="_blank" class="link1">
                    <img src="<?php echo (get_cover($vo["pic"],'path')); ?>" alt="" />
                </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
               
            </ul>
        </div>
    </div>
</div>