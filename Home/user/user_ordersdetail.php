<?php
    
    require './head_user.php';
    $orderid = $_GET['id'];  //订单id
    
    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');
    //从数据库中读取商品详情
    $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    $sql = "select count(*) total from `shop_detail` where `orderid`={$orderid}";
    //发送执行
      
    $result = mysqli_query($link,$sql);
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./cart3.php');
        exit;
    }
    if(mysqli_affected_rows($link)){
        $goodsNum = mysqli_fetch_assoc($result);//$goodsNum = Array( [total] => 商品个数 )
       
        $goodsNum = $goodsNum['total'];//$goodsNum['goodsNum']中'goodsNum'为count(*)的别名 [goodsNum(*)] => 个数/goodsNum => 个数
    }
    
    $totally=0;


    $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    $sql = "select count(*) total from `shop_detail` where `orderid`={$orderid}";
    //发送执行
      
    $result = mysqli_query($link,$sql);
  
    //判断
    if(mysqli_affected_rows($link)){
        $total = mysqli_fetch_assoc($result);//$total = Array( [total] => 个数 )
        
        $total = $total['total'];//$total['total']中'total'为count(*)的别名 [count(*)] => 个数/total =>  个数
    }
   
    //每页显示行数
    $num = 3;

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
    
    //分页显示
    $sql = "select * from `".PIX."detail` where `orderid`={$orderid} order by `id` desc limit {$offset},{$num}";
   
    $result = mysqli_query($link , $sql);
    // 检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./orders.php');
        exit;
    }
     $goodsList = [];
    
    ?>

    <ol class="breadcrumb" style="margin-top:">
        <b>您当前的位置：</b>
        <li><a href ="../main_index.php">凡客首页</a></li>
        <li><a href ="./user.php">个人中心</a></li>
        <li><a href ="active">订单详情</a></li>

    </ol>

    <div class="cart-info3">
        <table class="cart-table3 table table-hover">
            <thead>
                <tr><td style="font-size:16px;font-weight:bold;color:#a10000;">商品详情</td></tr>
                <tr>
                    <td>订单号</td>
                    <td>商品ID</td>
                    <td>商品名称</td>
                    <td>图片</td>
                    <td>单价</td>
                    <td>数量</td>
                    <td>小计</td>

                <?php if(mysqli_affected_rows($link)){
                    while($rows = mysqli_fetch_assoc($result)){
                        $goodList = $rows;
                ?>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $orderid ;?></td>
                    <td><?php echo $goodList['id'] ?></td>
                    <td><?php echo $goodList['name'] ?></td>
                    <td><img src="../../Common/goodsimage/s_<?php echo $goodList['picture'] ?>" style="width:50px;"></td>

                    <td>￥ <?php echo $goodList['price']; ?></td>
                    <td>
                    <input type="text" style="width:25px; border:none;" name="num" value="<?php echo $goodList['num']; ?>" readonly>
                    </td>
                    <td><?php echo $goodList['num']*$goodList['price']; ?></td>               
                </tr>
        
        <?php 
                    } 
                }
        $totally += $goodList['num']*$goodList['price'];

        ?>

            </tbody>

        </table>
        <ul class="pagination">
       
                    <!--               分页              -->
                  

                    <li>
                        <a href="./cart3.php?p=<?= $p - 1;?>&orderid=<?= $orderid;?>" aria-label="Previous"><span aria-hidden="true">上一页</span></a>
                    </li>
                   
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
                                echo "<li class='active'><a  href='./cart3.php?p={$i}&orderid={$orderid}'>{$i}</a></li>";
                            }else{
                                echo "<li><a  href='./cart3.php?p={$i}&orderid={$orderid}'>{$i}</a></li>";
                            }
                        }
                    ?>

            <li>
                <a href="./cart3.php?p=<?= $p + 1;?>&orderid=<?= $orderid;?>" aria-label="Next">
                <span aria-hidden="true">下一页</span></a>
            </li>
                       
        </ul>
        <div class="form-group">
            <div class="cart3-total col-sm-offset-10 col-sm-10" >总计：<?php echo $totally ?></div>
                <input type="hidden" name="totally" value="<?= $totally;?>">
            <div><a class="btn btn-success col-sm-offset-10" href="../main_index.php" role="button">返回首页</a></div>
        </div>

    </div>
















<?php
    require './footer_user.php';
?>
