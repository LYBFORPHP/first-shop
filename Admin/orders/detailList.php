<?php
    session_start();
    // 导入配置文件
    require '../../Common/config.php';

    // 连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

    // 设置字符集
    mysqli_set_charset($link , 'utf8');
    $totally=0;
    //遍历每个订单的商品
    $sql = "select `id` from `".PIX."orders`";


    $result = mysqli_query($link,$sql);

    //检测错误
    $errno = mysqli_errno($link);
    if($errno > 0 ){
        $error = mysqli_error($link);
        $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
        $msg .= "<p>出错啦！</p>";
        echo $msg;
        echo $sql;
        header('refresh:3;url=./orders.php?error=2');
    }
    $orderid = [];
    if(mysqli_affected_rows($link)){
        while($row = mysqli_fetch_assoc($result)){
            $orderid[] = $row; 
        }
    
    }
    
    //释放资源   
    mysqli_free_result($result);
    mysqli_close($link);
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
        <h1>订单详情</h1>
        
            <!-- -======================= -->

        <div class="form-group">
            <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">订单详情</div>
        </div>
        <div class="cart-info2">
            <table class="cart-table2 table table-hover" >
                <thead>
                    <tr>
                        
                        <td>订单号</td>
                        <td>商品ID</td>
                        <td>商品名称</td>
                        <td>单价</td>
                        <td>数量</td>
                       
                    </tr>
                </thead>
                <tbody>


            <?php foreach($orderid as $key => $val){
                //获得订单ID
                $id=$val['id'];
                
                $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

                // 设置字符集
                mysqli_set_charset($link , 'utf8');
                //查找每个订单ID内的商品
                $sql = "select * from `".PIX."detail` where `orderid`={$id}";
                $result = mysqli_query($link,$sql);

                // 检测错误
                $errno = mysqli_errno($link);
                if($errno > 0 ){
                    $error = mysqli_error($link);
                    $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
                    $msg .= "<p>5秒后滚！</p>";
                    echo $msg;
                    echo $sql;
                  // header('refresh:5;url=./orders.php?error=2');
                }
                $goodList = [];
      
                if(mysqli_affected_rows($link)){
                    while($row = mysqli_fetch_assoc($result)){
                        $goodList['detail'] = $row; 
                
         
       
            ?>
                    <tr>
                        <td><?php echo $id ;?></td>
                        <td><?php echo $goodList['detail']['goodsid'] ;?></td>
                        <td><?php echo $goodList['detail']['name'] ;?></td>
                        <td><?php echo $goodList['detail']['price']; ?></td>
                        <td><input type="text" style="width:25px; border:none;" name="num" value="<?php echo $goodList['detail']['num'];?>"></td>
                    </tr>
            <?php  
                    }
                }

                //释放资源   
                mysqli_free_result($result);
                mysqli_close($link);
            }?>

                </tbody>

            </table>
        </div>
    </body>
</html>
