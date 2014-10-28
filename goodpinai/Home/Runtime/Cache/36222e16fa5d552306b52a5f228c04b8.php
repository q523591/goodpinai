<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Common/Css/reset.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Index/Css/loginReg.css">
<script type="text/javascript" src="__PUBLIC__/Common/Js/html5shiv.js" ></script>
<script type="text/javascript" src="__PUBLIC__/Index/Js/loginReg.js" ></script>
<!--[if IE 6]>
<script src="__PUBLIC__/Common/Js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
<script type="text/javascript">
DD_belatedPNG.fix('*');
</script>
<![endif]-->
</head>
<body>
	<div id="login_wrap">
		<h2 id="login_title_1">让爱从心开始</h2>
		<h2 id="login_title_2">爱情起航</h2>
		<img id="login_heart" src="__PUBLIC__/Index/Img/login_heart.png" alt="">
		<img id="login_ship" src="__PUBLIC__/Index/Img/login_ship.png" alt="">
		<a id="login_index" href="#">回到首页</a>
		<a id="login_tab" href="javascript:;">注册</a>
		<div id="login_main_3d">
			<div id="login_main_wrap">
				<div id="login_main">
					<a href="#" class="login_button"><img class="login_img" src="__PUBLIC__/Index/Img/login_qq.png" alt="">QQ快捷登录</a>
					<a href="#" class="login_button"><img class="login_img" src="__PUBLIC__/Index/Img/login_microblog.png" alt="">新浪快捷登录</a>
					<form action="#" method="">
						<ul class="login_form">
							<li class="login_li">
								<span>邮箱:</span>
								<input type="email" name="username" autofocus placeholder="请输入用户名" required="required" >
							</li>
							<li class="login_li">
								<span>密码:</span>
								<input type="password" name="password" required="required">
							</li>
						</ul>
						<a id="login_forget" href="#">忘记密码</a>
						<input id="login_submit" class="login_rgs_submit" type="submit" value="立即登录">
					</form>
				</div><!-- end login_main -->
				<div id="rgs_main">
					<a href="#" class="login_button"><img class="login_img" src="__PUBLIC__/Index/Img/login_qq.png" alt="">QQ快捷登录</a>
					<a href="#" class="login_button"><img class="login_img" src="__PUBLIC__/Index/Img/login_microblog.png" alt="">新浪快捷登录</a>
					<form action="#" method="">
						<ul class="login_form">
							<li class="rgs_li">
								<span>昵称:</span>
								<input type="email" name="nickname" autofocus required="required" >
							</li>
							<li class="rgs_li">
								<span>邮箱:</span>
								<input type="email" name="username" autofocus required="required" >
							</li>
							<li class="rgs_li">
								<span>密码:</span>
								<input type="password" name="password" required="required">
							</li>
							<li class="rgs_li">
								<span>重复密码:</span>
								<input type="password" name="repassword" required="required">
							</li>
						</ul>
						<div id="rgs_clause">
							<input id="rgs_check" type="checkbox" name="checkbox" checked >
							<span>同意</span>
							<a id="rgs_agree" href="#">使用条款</a>
						</div>
						<input id="rgs_submit" class="login_rgs_submit" type="submit" value="立即注册">
					</form>
				</div><!-- end rgs_main -->
			</div><!-- end login_main_wrap -->
		</div><!-- end login_main_3d -->
	</div>
</body>
</html>