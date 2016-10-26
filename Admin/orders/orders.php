<?php
 
    // 导入配置文件
    require '../../Common/config.php';

    // 连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

    // 设置字符集
    mysqli_set_charset($link , 'utf8');


    //高级分页
   
    //  SQL语句
    $sql = "select count(*) total from `shop_orders`";
    //发送执行
      
    $result = mysqli_query($link , $sql);
  
    //判断
    if(mysqli_affected_rows($link)){
        $total = mysqli_fetch_assoc($result);//$total = Array( [total] => 7 )
        
        $total = $total['total'];//$total['total']中'total'为count(*)的别名 [count(*)] => 7/total => 7 
    }

    //每页显示行数
    $num = 5;

    //总页数至少为一页
    $totalPage = max(1,ceil($total / $num));
   
    //当前页数
    $p = isset($_GET['p']) ? $_GET['p'] + 0 : 1 ;
    // 如果当前页小于1，则重新设置为最小页码 保证最小页数为第一页
         
    $p = max($p,1);
      
    // 如果当前页大于总页码，则重新设置$p为最大页码
       
    $p = min($p,$totalPage);
    
    //求偏移量
    $offset = ($p - 1) * $num;
    
   
?>


<!doctype html>
<html>
    <head>
        <title>Document</title>
        <meta charset='utf-8'/>
        <script src="../public/js/jquery-2.1.3.min.js"></script>
        <!-- 先引入JS -->
        <script src="../public/js/bootstrap.min.js"></script>
        <!-- 引入样式表 -->
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    </head>
    <body>
        <h1>订单浏览</h1>
        
            <!-- -======================= -->

        <div class="form-group">
            <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">订单信息</div>
        </div>
        <div class="cart-info2">
            <table class="cart-table2 table table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>用户id</td>
                        <td>联系人姓名</td>
                        <td>联系人地址</td>
                        <td>总金额</td>
                        <td>添加时间</td>
                        <td>订单状态</td>
                        <td>查看</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
<?php 
    $totally=0;
    $status=['新订单','已发货','已收货','无效订单'];

    //遍历订单
    $sql = "select * from `".PIX."orders` order by `id` desc limit {$offset},{$num}";
   
    $result = mysqli_query($link,$sql);
    
    // 检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./orders.php');
        exit;
    }
    $ordersList=[];
    if(mysqli_affected_rows($link)){
        while($row = mysqli_fetch_assoc($result)){
            $ordersList[]=$row;
        }
    }

    mysqli_free_result($result);
   
?>
    <?php foreach($ordersList as $key => $val): ?>

                    <tr>
                        <td><?php echo $val['id'] ?></td>
                        <td><?php echo $val['uid'] ?></td>
                        <td><?php echo $val['linkman'] ?></td>
                        <td><?php echo $val['address'] ?></td>
                        <td>￥ <?php echo $val['total']; ?></td>
                        <td><?php echo $val['addtime'] ?></td>
                        <td><?php echo $status[$val['status']] ?></td>
                        <td><a href="./detailList.php?orderid=<?=$val['id']?>">查看</a></td>
                        <td><a href="orders_update.php?a=update&id=<?=$val['id'] ?>" class="btn btn-warning">修改</a></td>
                    </tr>
    <?php endforeach; ?>
        


                </tbody>

            </table>

        </div>
        <nav>
            <ul class="pagination">
                <!-- 
                    要把搜索的内容带到下一页
                -->
              

                <li>
                    <a href="./orders.php?p=<?= $p - 1;?>" target="main" aria-label="Previous"><span aria-hidden="true">上一页</span></a>
                </li>
                <?php

                    // 先计算下一页
                    $_GET['p'] = $p + 1;
                    // 组装成URL参数
                    $query = http_build_query($_GET);
                    
                ?>

                <?php
                    // 起始页码
                    $start = $p - 5;
                    $start = max($start , 1);
                    // 结束页码
                    $end = $p + 5;
                    $end = min($end , $totalPage);

                    // 循环输出页码
                    for($i = $start; $i <= $end; $i++){
                        if($p == $i){
                            echo "<li class='active'><a  href='./orders.php?p={$i}'>{$i}</a></li>";
                        }else{
                            echo "<li><a href='./orders.php?p={$i}'>{$i}</a></li>";
                        }
                    }
                ?>

                <li>
                    <a href="./orders.php?p=<?= $p + 1;?>"- target="main" aria-label="Next">
                    <span aria-hidden="true">下一页</span></a>
                </li>
                   
            </ul>
        </nav>
    </body>
</html>
