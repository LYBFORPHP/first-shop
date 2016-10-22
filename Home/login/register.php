


<html>
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
		 <link href="../Admin/public/css/bootstrap.min.css" rel="stylesheet">
   <script src="../Admin/public/js/jquery-2.1.3.min.js"></script>
   <script src="../Admin/public/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="./public/css/web.css" type="text/css"/>
		<style type="text/css">
#myCarousel{
   width: 500px;
}
</style>
<body>
	</head>
	<body>
		<div class="top">
			<div class="top-content">
				<a href="#" class="logo"></a>
			</div>
			<div class="main">
				<div class="new-zhuce">

					<h1>
							注册新用户
						
						<span>我已经注册，现在就<a href="login.php">登陆</a></span>
					</h1>
				
				<div class="register-box">
					<ul>
						<li>
							<div class="register-info">
								<div >
									<input type="text" placeholder="请输入手机号" id="phone-number"/>
									<a href="">获取短信验证码</a>	
								</div>
							</div>
						</li>
							
						<li>
							<div class="register-info">
								<input type="text" placeholder="填写手机验证码"/>
							</div>	
						</li>
						<li>
							<div class="register-info">
								<input type="text" placeholder="请设定登陆密码"/>
							</div>	
						</li>
						<li>
							<div class="register-info">
								<input type="text" placeholder="请再次输入登陆密码"/>
							</div>	
						</li>
						
						<li>
							<div class="register-info">
								<div >
									<input type="text" placeholder="请输入验证码" id="phone-yzm"/>
									<img onclick="this.src = '../Common/yzm.php?id='+Math.random()" src="../Common/yzm.php" alt="">
								</div>
							</div>
						</li>
						<li>
							<div class="register-button-box">
								<input type="checkbox" />请阅读<a href="#">《vancl凡客诚品服务条款》</a>
								<a href="#">
									<div class="register-button">立即注册</div>
								</a>
							</div>	

						</li>
					</ul>
				</div>
				</div>
			<!-- <div class="main-logo">

			</div> -->

			<!-- ____________轮播_________________ -->


				<div id="myCarousel" class="carousel slide">
<ol class="carousel-indicators">
<li data-target="#myCarousel" data-slide-to="0" class="active">
<li data-target="#myCarousel" data-slide-to="1">
<li data-target="#myCarousel" data-slide-to="2">
</ol>
<div class="carousel-inner">
<div class="item active">
<img src="public/pic/main-logo.jpg" alt="First slide">
</div>
<div class="item">
<img src="public/pic/focus-ad1.jpg" alt="Second slide">
</div>
<div class="item">
<a herf="#"><img src="public/pic/focus-ad-2.jpg" alt="Third slide"></a>
</div>
</div>
<a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
<a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>
</div>















			<!-- __________________轮播区域_____________________________ -->
		</div>


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
					<li><a href="#"><img src="./pic/brand.png"/></a></li>
				</ul>	
			</div>
		</div>
	</body>
</html>
	











	
<!--                   连接数据库                              -->











<?php
// 先导入配置文件
    require '../Common/config.php';

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');












?>
