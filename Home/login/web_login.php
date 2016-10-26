<?php
	
	//前台登录
	session_start();  //开启会话
	
	
	//判断是否存在error，如果不存在就可以覆盖上一个地址
	if(!isset($_GET['error'])){
		$_SESSION['REFERER'] = $_SERVER['HTTP_REFERER'];
	}
?>






<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
		
		<link rel="stylesheet" href="../public/css/web.css" type="text/css"/>
		<link href="../..//Admin/public/css/bootstrap.min.css" rel="stylesheet">
		<script src="../../Admin/public/js/jquery-2.1.3.min.js"></script>
  		 <script src="../../Admin/public/js/bootstrap.min.js"></script>
		
		<style type="text/css">
#myCarousel{
   width: 500px;
}
</style>
	</head>
	<body>
		<div class="top">
			<div class="top-content">
				<a href="#" class="logo"></a>
				<p><a href="#" >帮助</a></p>
			</div>
			<div class="main">
				<div class="zhuce">
						<span>
							没有用户免费<a href="web_register.php">注册</a>
						</span>
				</div>


				

				<form action="../web_action.php?a=login" method="post">
				<div class="login">
					<div class="login-top">
						
							<li id="putong">用户登陆</li>
						
					</div>
					<div class="login-main">
						<div class="block"></div>
						<div class="user_name" >
							<input type="text" name="user_name" placeholder="请输入用户名">
						</div>
						<div class="block"></div>
						<div class="user_pass">
							<input type="password" name="user_pass" placeholder="请输入密码">
						</div>


						<div class="register-info">
								<div >
									<input type="text" placeholder="请输入验证码" id="phone-yzm" name="yzm"/>
									<img onclick="this.src = '../../Common/yzm.php?id='+Math.random()" src="../../Common/yzm.php" alt="">
								</div>
							</div>


						<div class="block"></div>
						<div class="login-mian-bottom">
							<a href="#" class="	FindPassword">找回密码</a>
							<div class="clear">
							<button type="submit" class="register-button">登录</button>
							</div>

						</div>
						<div class="line"></div>
						<div class="OtherLogin">
							<p>使用合作网站帐号登陆</p>
							
							<ul>
								<a href="#"><li class="l1"></li></a>
								<a href="#"><li class="l2"></li></a>
								<a href="#"><li class="l3"></li></a>
								<a href="#"><li class="l4"></li></a>
								<a href="#"><li class="l5"></li></a>
								<a href="#"><li class="l6"></li></a>
							</ul>
						</div>
					</div>

				</div>
				</form>
					<!-- ____________轮播_________________ -->


				<div id="myCarousel" class="carousel slide">
				<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active">
				<li data-target="#myCarousel" data-slide-to="1">
				<li data-target="#myCarousel" data-slide-to="2">
				</ol>
				<div class="carousel-inner">
				<div class="item active">
				<img src="../public/pic/main-logo.jpg" alt="First slide">
				</div>
				<div class="item">
				<img src="../public/pic/focus-ad1.jpg" alt="Second slide">
				</div>
				<div class="item">
				<a herf="#"><img src="../public/pic/focus-ad-2.jpg" alt="Third slide"></a>
				</div>
				</div>
				<a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
				<a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>
				</div>
</div>





			<!-- __________________轮播区域_____________________________ -->
	


		<!--          尾部         -->

			<div class="foot-bottom">
				<div class="foot-bottom-box">
					<p>Copyright 2007 - 2016 vancl.com All Rights Reserved 京ICP证100557号 京公网安备11011502002400号 出版物经营许可证新出发京批字第直110138号</p>
					
				</div>
			</div>
			<div class="bottom">
				<ul >
					<li><a href="#"></a></li>
					<li><a href="#"></a></li>
					<li><a href="#"></a></li>
					<li><a href="#"></a></li>
					<li><a href="#"><img src="../public/pic/brand.png"/></a></li>
				</ul>	
			</div>
		</div>
	</body>
</html>



<?php
	
