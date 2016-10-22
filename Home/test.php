<?php
    // 先导入配置文件
    require '../Common/config.php';

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');



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
                
                    <span id="top-title">您好,11111111111111111欢迎光临凡客诚品！</span>
                    <span id="top-login">
                        <a href="./login.php">登录</a>&nbsp;|&nbsp;<a href="./register.php">注册</a>
                    </span>
                    </ul>
                </div>
                <div class="top-head-middle">
                    <span >
                        <a href="#">我的订单</a>
                    </span>
                    <span>
                        <a href="#">收藏本站</a>
                    </span>

                </div>
                <div class="top-head-right">
                    <ul class="nav nav-pills">
                        <li><a href="#">我的凡客</a></li>
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
        <div class="top-search">
            <a href="#"><div class="top-search-left"></div></a>
            <div class="top-search-box">
                <div class="top-search-input">
                    <div class="top-search-input-left">
                        <input class="top-search-text"  type="text" placeholder="搜“卡其裤”，体验与众不同" />
                        <input class="top-search-button"  type="button" value=""/>
                    </div>

        <!--                         搜索部分                                   -->
                    <a href="#">
                        <div class="top-search-cart">
                            <div class="top-search-cart-icon">
                            </div>
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
        </div>


 <div class="clear"></div>

        <div class="main-ad">   
            <div class="cate-nav" >
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
                <a class="cate-link"><?= $val['name'] . $val['id']; ?></a>

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
                        <div class="cate-hidden-three">

                            <a href="#">3级</a>

                        </div>
                    <?php endforeach; ?>


                </div>



            </li>
            <?php endforeach; ?>



        </ul>
    </div>

              

           
             <!--                        中部大广告                                    -->
            <div class="main-foucs">
                
                
               <div id="myCarousel" class="carousel slide ">
                <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active">
                <li data-target="#myCarousel" data-slide-to="1">
                <li data-target="#myCarousel" data-slide-to="2">
                </ol>
                <div class="carousel-inner">
                <div class="item active">
                <img src="public/pic/focus-ad1.jpg" alt="First slide">
                </div>
                <div class="item">
                <img src="public/pic/focus-ad-2.jpg" alt="Second slide">
                </div>
                <div class="item">
                <a herf="#"><img src="public/pic/focus-ad-2.jpg" alt="Third slide"></a>
                </div>
                </div>
                <a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>
                </div>
                <div class="main-focus-right">
                        <div class="main-foucs-right-ad"><a href="#"><img src="public/pic/focus-ad2.jpg"/></a></div>
                        <div class="main-foucs-right-ad"><a href="#"><img src="public/pic/focus-ad3.jpg"/></a>
                    </div>
                </div>
                </div>


<!--                           商品展示                                                  -->












    <div class="hot-shopping"><h2>当季推荐</h2>
                <div class="hot-shopping-list">
                <?php
    

    $sql =  "select * from `shop_goods` where `status`=1 order by `sale` desc limit 10";

    $result = mysqli_query($link , $sql);
            // 准备空数组
            $hotSale = [];
            if(mysqli_affected_rows($link) > 0){
                // 遍历数组
                while($row = mysqli_fetch_assoc($result)){
                    
                    $hotSale[] = $row;
                }
                 
              
            }

           
mysqli_free_result($result);


            
?>

                    <ul class="hot-shopping-list-ul">
                    <?php foreach($hotSale as $key => $val): ?>
                        <li><a href="#"><img height="232" width="232"  src="../Common/goodsimage/m_<?=$val['picture'];?>"></a> </li>
                        <?php endforeach; ?>
                    </ul>
                    <ul class="hot-shopping-list-ul">
                        <li><a href="#"><img src="./pic/hot-shopping-6.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/hot-shopping-7.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/hot-shopping-8.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/hot-shopping-9.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/hot-shopping-10.jpg"></a> </li>
                    </ul>
                </div>
                <div class="void-block"></div>
                <div class="hot-shopping">
                <h2>上装</h2>
                <ul class="hot-shopping-cloth">
                    <li><a href="#"><img src="./pic/cloth-1.jpg"></a> </li>
                    <li><a href="#"><img src="./pic/cloth-2.jpg"></a> </li>
                    <li><a href="#"><img src="./pic/cloth-3.jpg"></a> </li>
                </ul>
                <ul class="hot-shopping-list-ul">
                    <li><a href="#"><img src="./pic/cloth-4.jpg"></a> </li>
                    <li><a href="#"><img src="./pic/cloth-5.jpg"></a> </li>
                    <li><a href="#"><img src="./pic/cloth-6.jpg"></a> </li>
                    <li><a href="#"><img src="./pic/cloth-7.jpg"></a> </li>
                    <li><a href="#"><img src="./pic/cloth-8.jpg"></a> </li>
                </ul>
                </div>
                <div class="hot-shopping">
                <h2>下装</h2>
                    <ul class="hot-shopping-cloth">
                        <li><a href="#"><img src="./pic/pants-1.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/pants-2.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/pants-3.jpg"></a> </li>
                    </ul>
                    <ul class="hot-shopping-list-ul">
                        <li><a href="#"><img src="./pic/pants-4.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/pants-5.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/pants-6.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/pants-7.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/pants-8.jpg"></a> </li>
                    </ul>
                </div>
                <div class="hot-shopping"><h2>更多精彩</h2>
                    <ul class="hot-shopping-cloth">
                        <li><a href="#"><img src="./pic/other-1.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/other-2.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/other-3.jpg"></a> </li>
                    </ul>
                    <ul class="hot-shopping-list-ul">
                        <li><a href="#"><img src="./pic/other-4.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/other-5.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/other-6.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/other-7.jpg"></a> </li>
                        <li><a href="#"><img src="./pic/other-8.jpg"></a> </li>
                    </ul>
                </div>
            </div>
        </div>


<!--                          尾部                                -->



<div class="foot">
            <div class="foot-info">
                <ul class="foot-info-box">
                    <li class="foot-info-box-list">
                        <p>关于凡客</p>
                        <p><a href="#">公司简介</a></p>
                        <p><a href="#"><b>联系我们</b></a></p>
                        <p><a href="#">友情链接</a></p>
                    </li>
                    <li class="foot-info-box-list"><p>新手指南<p>
                        <p><a href="#">账户注册</a></p>
                        <p><a href="#">购物流程</a></p>
                    </li>
                    <li class="foot-info-box-list"><p>配送范围及时间</p>
                        <p><a href="#">国内配送</a></p>
                        <p><a href="#">订单拆分</a></p></li>
                    <li class="foot-info-box-list"><p>支付方式</p>
                        <p><a href="#">货到付款</a></p>
                        <p><a href="#">在线支付</a></p>
                        <p><a href="#">礼品卡及账户余额</a></p>
                        <p><a href="#">其他支付方式</a></p></li>
                    <li class="foot-info-box-list"><p>售后服务</p>
                        <p><a href="#">退换货政策</a></p>
                        <p><a href="#">退换货办理流程</a></p>
                        <p><a href="#">退换货网上办理</a></p>
                        <p><a href="#">退款说明</a></p></li>
                    <li class="foot-info-box-list"><p>帮助中心</p>
                        <p><a href="#">在线客服</a></p>
                        <p><a href="#">找回密码</a></p>
                        <p><a href="#">隐私声明</a></p></li>
                </ul>
            </div>
            <div class="foot-icon">
                <ul >
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                </ul>   
            </div>
            <div class="foot-bottom">
                <div class="foot-bottom-box">
                    <p>Copyright 2007 - 2016 vancl.com All Rights Reserved 京ICP证100557号 京公网安备11011502002400号 出版物经营许可证新出发京批字第直110138号</p>
                    <p>凡客诚品（北京）科技有限公司</p>
                </div>
            </div>
            <div class="bottom">
                <ul >
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"></a></li>
                    <li><a href="#"><img src="./public/pic/brand.png"/></a></li>
                </ul>   
            </div>
        </div>
    </body>
</html>

<?php
mysqli_close($link);
?>









