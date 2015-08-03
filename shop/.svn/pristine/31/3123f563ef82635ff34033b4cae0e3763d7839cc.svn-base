var index = {
	ani : null,
	frame : 1,
	easeInOut: function(t,b,c,d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	show : function(type,e) {
		var scrollLeft = document.getElementById('LandR_c').scrollLeft,
			end = type === 'login' ? (0 - scrollLeft) : (529 - scrollLeft),
			self = this;	
		clearInterval(this.ani);
		this.frame = 1;
		document.getElementById('LandR').className = 'ani';
		this.ani = setInterval(
			function() {
				self.changeScrollLeft(self.frame,scrollLeft,end);
				self.frame += 1;
				if (self.frame > 10) {
					clearInterval(self.ani);
					document.getElementById('LandR').className = '';
				}
			}
		,30);
		(e && e.preventDefault) ? e.preventDefault() : (window.event.returnValue = false);
	},
	changeScrollLeft : function(f,l,e) {
		document.getElementById('LandR_c').scrollLeft = parseInt(this.easeInOut(f,l,e,10));
	},
	inputErrorTips : function(input) {
		(function() {
			var obj = input,
				no = 1,
				bg = '#ff0000',
				interval = setInterval(function(){
					obj.style.background = bg;
					no++;
					bg = bg === '#ff0000' ? '' : '#ff0000';
					if (no === 5) {
						clearInterval(interval);
					}
			},100);	
		})();
	},
	login : function() {
		var uInput = document.getElementById('userName'),
			pInput = document.getElementById('password'),
			menu = document.getElementById('loginMenu'),
			userName = uInput.value,
			password = pInput.value,
			isEmail = /^(?:\w+.?)*\w+@(?:[-_a-zA-Z0-9]+\.+)+[a-zA-Z]+$/.test(userName),
			isPassword = /^(?:.{6,16})$/.test(password),
			ajaxUrl;
		if (!isEmail) {this.inputErrorTips(uInput)}
		if (!isPassword) {this.inputErrorTips(pInput);this.inputErrorTips(document.getElementById('passwordTips'))}
		if (isEmail && isPassword) {
			ajaxUrl = '/login.do?userName=' + userName + '&password=' + password;
			jQuery.ajax({
				dataType: "json",
				url: ajaxUrl,
				cache: false,
				timeout: 10000,	
				beforeSend: function(){
					menu.className = 'grayMenu83';
					menu.innerHTML = '正在处理...';
				},
				success: function(data){
					menu.className = 'blueMenu83';
					menu.innerHTML = '登　录';
					if (data.success) {
						if (document.getElementById('remember').checked) {
							$.cookie('userName',userName,{expires: 7});
						} else {
							$.cookie('userName',null);
						}
						window.location.href = '/manage/index.html';
					} else {
						alert(data.Msg);
					}
				},	
				error: function(){
					menu.className = 'blueMenu83';
					menu.innerHTML = '登　录';
					alert('网络异常，请稍候再试');
				}
			});
		}
	},
	register : function() {
		var cInput = document.getElementById('code'),
			menu = document.getElementById('registerMenu'),
			code = cInput.value,
			ajaxUrl;
		if (!code.length || code === cInput.getAttribute('data-value')) {
			this.inputErrorTips(cInput);
			return false;
		} else {
			ajaxUrl = '/member/checkcode.do?authcode=' + code + '&r' + new Date().getTime();
			jQuery.ajax({
				dataType: "json",
				url: ajaxUrl,
				cache: false,
				timeout: 10000,	
				beforeSend: function(){
					menu.className = 'grayMenu83';
					menu.innerHTML = '正在处理...';
				},
				success: function(data){
					menu.className = 'blueMenu83';
					menu.innerHTML = '下一步';
					if (data.success) {
						window.location.href = '/member/toregister.do?authcode=' + data.code + '&r=' + new Date().getTime();
					} else {
						alert(data.Msg);
					}
				},	
				error: function(){
					menu.className = 'blueMenu83';
					menu.innerHTML = '下一步';
					alert('网络异常，请稍候再试');
				}
			});
		}
	},
	appendLogin : function() {
		var	html = "<ul id='LandR' class='clearfix'><li id='LandR_l'></li><li id='LandR_c'><div id='LandR_c_wrap' class='clearfix'><form id='login'><p class='clearfix'><input type='text' id='userName' data-value='请输入您的用户名' /><input type='text' id='passwordTips' value='请输入您的密码' /><input type='password' id='password' style='display:none' /><a href='' id='loginMenu' class='blueMenu83'>登　录</a></p><p class='otherOperations'><input type='checkbox' id='remember' checked /><label for='remember'>记住账号</label><a href='' onClick=index.show('register',event) id='registerNow'>马上注册</a><span class='interval'> | </span><a href='/v/forgotpwd/index_new.html'>忘记密码？</a></p></form><form id='register'><p class='clearfix'><input type='text' id='code' data-value='请输入您的邀请码' /><a href='' id='registerMenu' class='blueMenu83'>下一步</a></p><p class='otherOperations'><a href='' onClick=index.show('login',event) id='have'>已有账号？</a><span class='interval'> | </span><a href='/v/register/inviteCode_new.html'>邀请码申请</a></p></form></div></li><li id='LandR_r'></li><li id='maskLeft'></li><li id='maskRight'></li></ul>";
		$('#logo').after(html);
	},
	addEvent : function() {
		$('#userName').bind('keydown',function(e){
			if (e.type === 'keydown' && e.keyCode === 13) {
				index.login();
			}
		});
		$('#passwordTips').bind('focus',function(e){
			if (e.type === 'focus') {
				$('#passwordTips').hide();
				$('#password').show().focus();
			}
		});
		$('#password').bind('blur keydown',function(e){
			if (e.type === 'keydown') {
				if (e.keyCode !== 13) return;
				index.login();
			} else {
				var password = $('#password');
				if (!password.val().length) {
					password.hide();
					$('#passwordTips').show();	
				}
			}
		});
		$('#loginMenu').bind('click',function(e) {
			e.preventDefault();
			if (this.className !== 'blueMenu83') return;
			index.login();
		});
		$('#register').bind('submit',function(e){
			e.preventDefault();
			if (this.className !== 'blueMenu83') return;
			index.register();
		});
		$('#registerMenu').bind('click',function(e) {
			e.preventDefault();
			if (this.className !== 'blueMenu83') return;
			index.register();
		});
	},
	init : function() {
		this.appendLogin();//生成文本框
		var uInput = document.getElementById('userName'),
			pInput = document.getElementById('password'),
			userName = $.cookie('userName');

		new InputHandle(uInput);//文本框提示功能
		new InputHandle(document.getElementById('code'));//文本框提示功能
		this.addEvent();
		new InputSuggest({
			input: document.getElementById('userName'),
			data: ['sina.com','163.com','qq.com','126.com','vip.sina.com','sina.cn','hotmail.com','gmail.com','sohu.com','yahoo.com','139.com','wo.com.cn','189.com','21cn.com']
		});
		if (!userName) return;
		uInput.value = userName;
	}
}
index.init();