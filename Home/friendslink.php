<?php
    session_start();
    // 先导入配置文件
    require '../Common/config.php';

    // 解决不能跳转的问题
    ob_start();

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    $sql = "select * from `".PIX."friendslink`";
    $result = mysqli_query($link,$sql);
     if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./cart3.php');
        exit;
    }

?>


<!doctype html>
<html>
    <head>  
        <title>凡客</title>
        <meta charset="utf-8"/>
        <link href="../Admin/public/css/bootstrap.min.css" rel="stylesheet">
        <script src="../Admin/public/js/jquery-2.1.3.min.js"></script>
        <script src="../Admin/public/js/bootstrap.min.js"></script>
        <link type="text/css" rel="stylesheet" href="./public/css/index.css"/>
        </script>
        
        <style type="text/css">
            #myCarousel{
               width: 710px;
               height:475px;
            }
        </style>
    <body>
    <!--                              网页顶部导航                                  -->


        <nav class="top-nav navbar navbar-default" role="navigation">
            <div class="top-head">
                <div class="top-head-left">
                <ul class="nav nav-pills">
                <?php if(isset($_SESSION['home_userinfo'])): ?>
                    <li><a id="top-title">您好!<?php echo $_SESSION['home_userinfo']['user'] ?>欢迎光临凡客诚品！</a></li>
                    <li><a href="./web_action.php?a=logout">注销</a></li>
                <?php else: ?>
                    <li><a href="./login/web_login.php?a=login">登录</a></li>
                    <li><a href="./login/web_register.php">注册</a></li>
                <?php  endif; ?>
                    <li><a href="./user/user.php">我的订单</a></li>
                    <li><a href="#">收藏本站</a></li>
                    </ul>
                </div>
               
                    

                
                <div class="top-head-right">
                    <ul class="nav nav-pills">
                    <li><a href="./main_index.php">返回首页</a></li>

                        <li class="nav-hide">
                        <a href="#">我的凡客</a>
                        <div class="hidebox"> 
                        <a href="./user/user.php">个人中心</a>
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
                    <img src="public/pic/top-ad.jpg" alt="2016VT正在上线" title="2016VT正在上线">
                </div>  
            </div>
        </a>

        <ol class="breadcrumb" style="margin-top:">
            <b>您当前的位置：</b>
            <li><a href ="./main_index.php">凡客首页</a></li>
            
            <li><a href ="#">友情链接</a></li>

        </ol>

        <div class="container">
            <table class=" table table-hover">
                <thead>
                    <tr><td style="font-size:16px;font-weight:bold;color:#a10000;">友情链接</td></tr>
                </thead>
                <tbody>
        <?php 
            $friendsLink = [];
            if(mysqli_affected_rows($link)){
                while($row = mysqli_fetch_assoc($result)){
                $friendLink = $row;
                $address=$friendLink['address'];
            
    
        ?>
                   <tr>
                        <td>
                            <a href="<?=$address;?>">
                            <?php 
                                echo $friendLink['name'] ;
                                    }  //while  结束
                                } //if结束
                                mysqli_free_result($result);
                                mysqli_close($link);
                            ?>
                            </a>
                        </td>
    
                    </tr>
                </tbody>

            </table>
   
    </div>



<?php
    include './footer_index.php';
?>
