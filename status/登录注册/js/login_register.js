window.onload = function(){
	var oWrap = document.getElementById('login_main_wrap'),
		oTab = document.getElementById('login_tab'),
		oLoginMain = document.getElementById('login_main'),
		oRgsMain = document.getElementById('rgs_main'),
		oPhone = document.getElementById('rgs_phone'),
		oEmail = document.getElementById('rgs_email'),
		oRgsTab1 = document.getElementById('rgs_tab1'),
		oRgsTab2 = document.getElementById('rgs_tab2'),
		bPhone = true,
		now = 0,
		iIndex = 2;

	oPhone.className += ' active';

	oPhone.onclick = function(){
		if (!bPhone) {
			oPhone.className += ' active';
			oEmail.className = 'login_button';
			oRgsTab1.style.display = 'block';
			oRgsTab2.style.display = 'none';
			bPhone = !bPhone;
		}
	}

	oEmail.onclick = function(){
		if (bPhone) {
			oPhone.className = 'login_button';
			oEmail.className += ' active';
			oRgsTab1.style.display = 'none';
			oRgsTab2.style.display = 'block';
			bPhone = !bPhone;
		}
	}

	oTab.onclick = function(){
		if(now==0){
			now=-180;
			setTimeout(function(){
				iIndex+=1;
				oRgsMain.style.zIndex = iIndex;
			}, 650);
			oTab.innerHTML = '登录';
		}else{
			now=0;
			setTimeout(function(){
				iIndex+=1;
				oLoginMain.style.zIndex = iIndex;
			}, 650);
			oTab.innerHTML = '注册';
		}
		oWrap.style.webkitTransform = 'rotateY('+now+'deg)';
		oWrap.style.oTransform = 'rotateY('+now+'deg)';
		oWrap.style.mozTransform = 'rotateY('+now+'deg)';
		oWrap.style.msTransform = 'rotateY('+now+'deg)';
		oWrap.style.transform = 'rotateY('+now+'deg)';
	}
}