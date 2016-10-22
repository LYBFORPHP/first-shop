
<?php
    session_start();
   
   //判断是否已经登录
   if(empty($_SESSION['user'])){
    header('refresh:3;url=./login/login.php');
    echo '请登录';
    exit;
   }
   
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
        <meta charset="utf-8"/>
        <script src="./public/js/jquery-2.1.3.min.js"></script>
        <!-- 先引入JS -->
        <script src="./public/js/bootstrap.min.js"></script>
        <!-- 引入样式表 -->
        <link rel="stylesheet" href="./public/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="public/css/bootstrap-theme.min.css">

        <style type="text/css">
            .top-bg{
        
                height: 60px;
                background: #606060;
            } 
            .top-left{
                float:left;
            }
            .top-left b{
                color:white;
                font-size:30px;
                line-height:60px;
                margin-left:30px;
            } 
            .top-right{
                float:right;
        </style>
    </head>
    <body>
        <div class="top-bg">
            <div class="top-left">
                <b>G22 商城后台</b>
            </div> 
            <div class="top-right">
            <!-- 顶端右侧下拉按钮 -->
              <div class="btn-group" style="margin-top:13px;margin-right:10px;">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-user" style="margin-right:10px;"></span>
                        <?php echo $_SESSION['user']['user'];?>管理员
                        <span style="" class="caret"></span>
                    </button>

                    <!-- top 使用顶层窗口打开 -->
                    <ul class="dropdown-menu" style="left:-20px;">
                        <li><a href="login/action.php?a=logout" target="top">注销</a></li>
                        
                    </ul>
                </div>
            </div>
        </div> 

        <!-- 顶部结束 -->

        <!-- 主体开始 -->
        <div class="col-md-2">
            <div class="list-group" style="margin-top:5px;">
                <a class="list-group-item active"><i style="margin-right:10px;" class="glyphicon glyphicon-th-list"></i>用户管理</a>

                <a href="./user/showuser.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>用户浏览</a>
            </div>
            <div class="list-group">
                <a class="list-group-item active"><i style="margin-right:10px;" class="glyphicon glyphicon-th-list"></i>分类管理</a>

                <a href="./categroy/index.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>分类浏览</a>

                <a href="./categroy/add.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>分类添加</a>
            </div>
            <div class="list-group">
                <a class="list-group-item active"><i style="margin-right:10px;" class="glyphicon glyphicon-th-list"></i>商品管理</a>

                <a href="./goods/goods_index.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>商品浏览</a>

                <a href="./goods/goods_add.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>商品添加</a>
            </div>
            <div class="list-group" style="margin-top:5px;">
                <a class="list-group-item active"><i style="margin-right:10px;" class="glyphicon glyphicon-th-list"></i>订单管理</a>

                <a href="../Admin/orders/orders.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>订单浏览</a>
                <a href="../Admin/orders/detailList.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>订单详情</a>
            </div>
            <div class="list-group" style="margin-top:5px;">
                <a class="list-group-item active"><i style="margin-right:10px;" class="glyphicon glyphicon-th-list"></i>其他管理</a>

                <a href="..//Admin/friends/friendslink_index.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>友情链接</a>
                <a href="..//Admin/friends/friendslink_add.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>新增链接</a>
                <a href="../Admin/friends/addLink.php" target="main" class="list-group-item"><i style="margin-left:5px;margin-right:10px;" class="glyphicon glyphicon-chevron-right"></i>留言评论</a>
            </div>
        </div>
               

                <div class="col-md-10"  style="height:700px;">
                    <!-- 嵌套框架集 -->
                    <iframe src="./public/welcome.html" name="main" frameborder="0" style="width:100%;height:100%;"></iframe>
                </div>

            </div><!-- row end -->
        </div>
    
    </body>
</html>
