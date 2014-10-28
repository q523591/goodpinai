window.onload = function(){
	var oWrap = document.getElementById('login_main_wrap'),
		oTab = document.getElementById('login_tab'),
		oLoginMain = document.getElementById('login_main'),
		oRgsMain = document.getElementById('rgs_main'),
		now = 0,
		iIndex = 2;

	oTab.onclick = function(){
		if(now==0){
			now=-180;
			iIndex+=1;
			setTimeout(function(){oRgsMain.style.zIndex = iIndex;}, 650);
			oTab.innerHTML = '登录';
		}else{
			now=0;
			iIndex+=1;
			setTimeout(function(){oLoginMain.style.zIndex = iIndex;}, 650);
			oTab.innerHTML = '注册';
		}
		oWrap.style.webkitTransform = 'rotateY('+now+'deg)';
		oWrap.style.oTransform = 'rotateY('+now+'deg)';
		oWrap.style.mozTransform = 'rotateY('+now+'deg)';
		oWrap.style.msTransform = 'rotateY('+now+'deg)';
		oWrap.style.transform = 'rotateY('+now+'deg)';
	}


	// 点击注册按钮进行提交验证

	var rgs_submit = getById('rgs_submit'); // 注册按钮

	var reg_form = document.forms[1]; // 注册表单form元素

	var nickname = document.forms[1].nickname; // 昵称表单

	var email = document.forms[1].email; // 邮箱表单

	var pwd = document.forms[1].pwd; // 密码表单

	var repwd = document.forms[1].repwd; // 重复密码表单

	var agreed = document.forms[1].agreed; // 同意条框

	//当表单要提交时
	reg_form.onsubmit = function(){
		// 验证昵称
		if(Trim(nickname.value,'k') == ''){
			alert('昵称不能为空');
			return false;
		}
		
		// 验证邮箱
		var email_pattern = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; // 匹配邮箱地址的正则
		if(Trim(email.value,'k') == ''){
			alert('邮箱不能为空');
			return false;
		}
		if(!email_pattern.test(email.value)){
			alert('邮箱格式不正确');
			return false;
		}
		
		// 验证密码
		if(Trim(pwd.value,'k') == ''){
			alert('密码不能为空');
			return false;
		}

		var pwd_pattern = /^[_0-9a-z]{6,16}$/;  // 匹配密码的正则
		if(!pwd_pattern.test(pwd.value)){
			alert('密码格式不正确');
			return false;
		}
		
		// 验证确认密码
		if(Trim(repwd.value,'k') == ''){
			alert('确认密码不能为空');
			return false;
		}
		
		if(Trim(pwd.value,'k') != Trim(repwd.value,'k')){
			alert('密码与确认密码不一样');
			return false;
		}

		// 验证是否勾选使用条框
		if(!agreed.checked){
			alert('请勾选同意使用条框');
			return false;
		}
	};
}