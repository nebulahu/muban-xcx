var weichong = {
	moduleAll : function(indexNav){
		/*大轮播*/
		$(".slideBox").slide({titCell:".hd ul",mainCell:".bd ul",effect:"leftLoop",autoPlay:true,easing:"easeOutCirc",delayTime:900,autoPage:true,interTime:5000});
		/*导航定位*/
		$("#moduleNav").find(".link").eq(indexNav).addClass("active")
		
		/*底部验证*/
		$(function(){
	
			var form = {},
				formIdObj = $('#messageForm');

			/**
			 * 验证注册
			 */
			form.validMsg = function(){
				var formvalid = formIdObj.Validform({
					 tiptype:3,
					 showAllError:true,
					 ignoreHidden:true,
					 btnSubmit:"#submitButton",
					 beforeSubmit : function(curform) {
						form.submitForm();
						
						return false;
					 }
					 
				});
				formvalid.addRule([
					
					{
						ele:"#yourName",
						datatype:"*2-5",
						nullmsg:"请输入姓名！",
						errormsg:"2-5位之间！"
					},
					{
						ele:"#memberContactPhone",
						datatype:/^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/,
						nullmsg:"请输入电话号码！",
						sucmsg:"手机号可以使用！",
						nullmsg:"请输入手机号码",
						errormsg:"请正确填写手机号格式、如：13511111111"
					},
					{
						ele:"#yourMess",
						datatype:"*2-200",
						nullmsg:"请输入留言！",
						errormsg:"2-200位之间！"
					}
				]);
			};
			var url_form=$('#thisajax').attr('data-url');
			form.submitForm = function(){
				$.ajax({
					type : 'POST',
					url : url_form,
					data : formIdObj.serialize(),
					dataType : 'json',
					success : function(data){
						if(data.status){
							
							layer.open({
								title: '信息',
								content: data.message,
								icon: 6,
									yes: function(index){
								  		location.reload();
									}
								}); 
						}else{
							layer.alert(data.message, {icon: 2});

						}
					}
				});

			};

			form.validMsg();
		})

	}
}

