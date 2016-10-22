<?php
    session_start();
     //判断是否已经登录
    if(empty($_SESSION['home_userinfo'])){
        header('refresh:3;url=../login/web_login.php');
        echo '请登录';
        exit;
    }
    // 先导入配置文件
    require '../../Common/config.php';

    // 解决不能跳转的问题
    ob_start();


?>


<!doctype html>
<html>
    <head>  
        <title>凡客</title>
        <meta charset="utf-8"/>
        <link href="../../Admin/public/css/bootstrap.min.css" rel="stylesheet">
        <script src="../../Admin/public/js/jquery-2.1.3.min.js"></script>
        <script src="../../Admin/public/js/bootstrap.min.js"></script>
        <link type="text/css" rel="stylesheet" href="../public/css/index.css"/>
        </script>
        
            <style type="text/css">
                #myCarousel{
                   width: 710px;
                   height:475px;
                }
            </style>
    </head>        
    <body>
    <!--                              网页顶部导航                                  -->


        <nav class="top-nav navbar navbar-default" role="navigation">
            <div class="top-head">
                <div class="top-head-left">
                    <ul class="nav nav-pills">
                    <?php if(isset($_SESSION['home_userinfo'])): ?>
                        <li><a id="top-title">您好!<?php echo $_SESSION['home_userinfo']['user'] ?>欢迎光临凡客诚品！</a></li>
                        <li><a href="../login/web_action.php?a=logout">注销</a></li>
                    <?php else: ?>
                        <li><a href="../login/web_login.php?a=login">登录</a></li>
                        <li><a href="../login/register.php">注册</a></li>
                    <?php  endif; ?>
                        <li><a href="#">我的订单</a></li>
                        <li><a href="#">收藏本站</a></li>
                    </ul>
                </div>
               
                    

                
                <div class="top-head-right">
                    <ul class="nav nav-pills">
                        <li><a href="../main_index.php">返回首页</a></li>
                        <li class="nav-hide">
                        <a href="#">我的凡客</a>
                        <div class="hidebox"> 
                        <a href="#">个人中心</a>
                        <a href="#">我的订单</a>
                        </div>
                        </li>
                        <li><a href="#">帮助中心</a></li>
                        <li><a href="#">网站公告</a></li>
                        <li><a href="#">手机凡客</a></li>
                        <li><a href="#">在线客服</a></li>
                    </ul>
                    <div class="payattention">
                        <a href="#"><span></span></a>
                        <a href="#"><span></span></a>
                    </div>
                </div>
            </div>
        </nav>
         <!--                         顶部广告条                                     -->
        <a href="#">
            <div class="top-ad">
                <div class="top-ad-content">
                    <img src="../public/pic/top-ad.jpg" alt="2016VT正在上线" title="2016VT正在上线">
                </div>  
            </div>
        </a>

       

       
