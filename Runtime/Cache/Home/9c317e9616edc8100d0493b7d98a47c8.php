<?php if (!defined('THINK_PATH')) exit();?><form class="form_box clr" id="messageForm">
    <div class="top clr" id="thisajax" data-url="<?php echo ($action); ?>">
        <div class="lis">
            <input type="text" name="username" id="yourName" placeholder="姓名" class="inp" />
        </div>
        <div class="lis2">
            <input type="text" name="phone" id="memberContactPhone" placeholder="手机" class="inp" />
        </div>
    </div>
    <div class="lis3">
        <textarea name="content" id="yourMess" cols="30" rows="10" placeholder="请您留言..." class="write"></textarea>
    </div>
    <input type="button" name="" id="submitButton" value="提 交" class="btns" />
</form>