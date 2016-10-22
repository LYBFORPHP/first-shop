<?php
    session_start();
    // 先导入配置文件
    require '../Common/config.php';

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    // 解决不能跳转的问题
    ob_start();


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
    </head>    
    <body>



    <!--                              网页顶部导航                                  -->


        <nav class="top-nav navbar navbar-default" role="navigation">
            <div class="top-head">
                <div class="top-head-left">
                    <ul class="nav nav-pills">
                    <?php if(isset($_SESSION['home_userinfo'])): ?>
                        <li><a id="top-title">您好!<?php echo $_SESSION['home_userinfo']['user'] ?>欢迎光临凡客诚品！</a></li>
                        <li><a href="./web_action.php?a=logout">注销</a</li>
                    <?php else: ?>
                        <li><a href="./login/web_login.php">登录</a></li>
                        <li><a href="./login/register.php">注册</a></li>
                    <?php  endif; ?>
                        <li><a href="#">我的订单</a></li>
                        <li><a href="#">收藏本站</a></li>
                    </ul>
                </div>
   
                <div class="top-head-right">
                    <ul class="nav nav-pills">
                        <li><a href="./main_index.php">返回首页</a></li>
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
                    <img src="public/pic/top-ad.jpg" alt="2016VT正在上线" title="2016VT正在上线">
                </div>  
            </div>
        </a>


        <!--                         搜索部分                                   -->        
        <div class="top-search">
            <a href="#"><div class="top-search-left"></div></a>
            <div class="top-search-box">
                <div class="top-search-input">
                    <div class="top-search-input-left">
                        <input class="top-search-text"  type="text" placeholder="搜“卡其裤”，体验与众不同" />
                        <input class="top-search-button"  type="button" value=""/>
                    </div>


  
                    <a href="shopcar/cart.php">
                        <div class="top-search-cart">
                            <div class="top-search-cart-icon"></div>
                            <p>我的购物车</p>
                        </div>
                    </a>
                </div>
                <div class="top-search-hotword">
                    热门搜索：
                    <a href="#">帆布鞋</a>
                    <a href="#">衬衫</a>
                    <a href="#">T恤</a>
                    <a href="#">外套</a>
                    <a href="#">卫衣</a>
                </div>
            </div>
        </div>


        <!--                         主广告部分                                    -->
        <div class="main-nav">
            <a href="#"><div class="main-nav-left">全部商品分类</div></a>
            <ul class="main-nav-right">
                <a href="#"><li>新品</li></a>
                <a href="#"><li>T恤</li></a>
                <a href="#"><li>衬衫</li></a>
                <a href="#"><li>外套</li></a>
                <a href="#"><li>裤装</li></a>
                <a href="#"><li>帆布鞋</li></a>
                <a href="#"><li>内衣袜品</li></a>
                <a href="#"><li>Nautilus</li></a>
            </ul>

            <div class="cate-nav">
            <?php
                        // 1.查找出所有顶级分类
                        $sql = "select * from shop_category where `pid` = 0";
                        // 2.执行
                        $result = mysqli_query($link,$sql);

                        $topCate = [];
                        // 3.判断
                            if(mysqli_affected_rows($link) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $topCate[] = $row;
                            }
                            // 释放资源
                            mysqli_free_result($result);
                        }   
            ?>
                <ul class="cate-nav-ul nav nav-stacked" >
                <?php foreach($topCate as $key => $val): ?>
                    <li class="cate-nav-li">
                        <a class="cate-link" style="background-color:#E5E6E6;"><?= $val['name']; ?></a>

                        <div class="cate-hidden-two">
                        <?php
                            // 查找出二级分类
                            $sql = "select * from shop_category where `pid` = {$val['id']}";
                            // 执行
                            $result = mysqli_query($link,$sql);
                            $secondCate = [];
                            if(mysqli_affected_rows($link) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $secondCate[] = $row;
                                }
                                // 释放资源
                                mysqli_free_result($result);
                            }
                        ?>
                        <?php foreach($secondCate as $k2 => $v2 ):?>
                                <p class="cate-p"><?= $v2['name'];?></p>
                            <?php 
                                $sql = "select * from shop_category where `pid` = {$v2['id']}";
                                // 执行
                                $result = mysqli_query($link,$sql);
                                $thirdCate = [];
                                if(mysqli_affected_rows($link) > 0){
                                    while($row = mysqli_fetch_assoc($result)){
                                        $thirdCate[] = $row;
                                    }
                                // 释放资源
                                mysqli_free_result($result);
                                }   

                            ?>
                            <?php foreach($thirdCate as $k3 => $v3 ):?>
                                <div class="cate-hidden-three">

                                    <a href="./showgoods.php?cid=<?= $v3['id'];?>"><?= $v3['name'];?></a>

                                </div>
                            <?php endforeach; ?>
                                       
                        <?php endforeach; ?>


                        </div>



                    </li>
                <?php endforeach; ?>
                </ul>
            </div>

              

           
             <!--                        中部大广告                                    -->
            <div class="main-foucs" >
            <?php
                $gid = $_GET['gid'] + 0 ;          
                if($gid<1){
                    header('location:./index.php');
                    exit;
                }   

                $sql = "select * from `shop_goods` where `id` = {$gid}";
    
                // 执行
                $result = mysqli_query($link , $sql);

                $goodsInfo = [];

                // 判断
                if(mysqli_affected_rows($link) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $goodsInfo = $row;
                }
               
                //  exit;
                // 释放资源
                mysqli_free_result($result);
                }
            
                $sql = "select * from `shop_category` where `id` = {$goodsInfo['cateid']}";

                $result = mysqli_query($link , $sql);

                if(mysqli_errno($link) > 0){
                    $errno = mysqli_errno($link);
                    $error = mysqli_error($link);
                    echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
                    exit;
                }
                $categoryList = [];
                // 判断
                if(mysqli_affected_rows($link) > 0){
                $categoryList = mysqli_fetch_assoc($result);
                   
                }
               
                $catePath= [] ;
                $catePath=explode(',',$categoryList['path']);
               

                $sql = "select * from `shop_category` where `id` = {$catePath[2]}";

                $result = mysqli_query($link , $sql);

                if(mysqli_errno($link) > 0){
                    $errno = mysqli_errno($link);
                    $error = mysqli_error($link);
                    echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
                    header('refresh:3;url=./main_index.php?errno={$errno}');
                    exit;
                }
                 
                if(mysqli_affected_rows($link) > 0){
                    $secondId = mysqli_fetch_assoc($result);
                   
                 }
                $sql = "select * from `shop_category` where `id` = {$catePath[1]}";
                $result = mysqli_query($link , $sql);
                
                if(mysqli_errno($link) > 0){
                    $errno = mysqli_errno($link);
                    $error = mysqli_error($link);
                    echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
                    header('refresh:3;url=./main_index.php?errno={$errno}');
                    exit;
                }
                 
                if(mysqli_affected_rows($link) > 0){
                    $thirdId = mysqli_fetch_assoc($result);
                }

                        //设置默认数量
                        $num = isset($_GET['num'])?$_GET['num'] + 0:1;
                        $num = max(1,$num);
                        $num = min($num,$goodsInfo['store']);
               
            ?>


                <ol class="breadcrumb" style="width:930px; margin:0 auto;">
                    <li class="bread"><b><?= $thirdId['name'] ?></b></li>
                    <li class="bread"><b><?= $secondId['name'] ?></b></li>
                    <li class="bread"><b><?=$categoryList['name'];?></b></li>     
                </ol> 
                <div class="detail-pic">
                    <img  src="../Common/goodsimage/m_<?= $goodsInfo['picture'];?>"/>
                </div>      
                <div class="detail-shopcar">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <h2><?= $goodsInfo['name'] ?></h2>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10">
                                <h1>售价：￥<?= $goodsInfo['price'] ?></h1>
                            </div>
                        </div>

                        <div class="form-group">            
                            <div style="height:40px;width:550px; margin-left:15px;">
                                <span>浏览量 : <?= $goodsInfo['views'] ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                       
                            <div style="height:40px;width:550px; margin-left:15px;">
                                <span>库存 : <?= $goodsInfo['store'] ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div style="height:40px;width:550px; margin-left:15px;">
                                <span>销量 : <?= $goodsInfo['sale'] ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div style="height:40px;width:550px; margin-left:15px;">
                                <span>数量：</span>
                                <span >
                                    <a href="./detail.php?gid=<?= $goodsInfo['id'];?>&num=<?= $num -1?>" class="glyphicon glyphicon-minus control-label"></a>
                                    <input type="text" readonly style="width:30px;" name="num" value="<?= $num; ?>">
                                  
                                    <a href="./detail.php?gid=<?= $goodsInfo['id'];?>&num=<?= $num + 1;?>" class="glyphicon glyphicon-plus control-label"></a>
                                </span>

                            </div>
                        </div>
                        <div class="form-group">
                            <!-- 如果库存小于0，则显示已售完 -->
                            <?php if( $goodsInfo['store'] < 1):?>
                                    <div class="col-sm-offset-2 col-sm-10"><a  class="btn disabled btn-default ">商品已售完</a></div>
                            <?php else:?>
                            <div class="col-sm-offset-2 col-sm-10">
                                <a href="./web_action.php?a=addshopcar&num=<?= $num;?>&gid=<?= $goodsInfo['id']?>" class="btn btn-default" style="background:#B81C22;color:white;">加入购物车</a>
                            </div>
                            <?php endif;?>
                        </div>

                    </form>
                </div>

            </div>
        </div>

<?php include './footer_index.php'?>
