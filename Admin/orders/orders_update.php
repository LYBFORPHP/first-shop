<?php
    
    session_start();
   
  
    //导入配置文件
    require '../../Common/config.php';
    $id=$_GET['id'];
    
    //连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

    //设置字符集
    mysqli_set_charset($link , 'utf8');
    
    $sql = "select * from `".PIX."orders` where id = {$id}";

    $result = mysqli_query($link , $sql);
    //检测错误
        $errno = mysqli_errno($link);
        if($errno > 0 ){
            $error = mysqli_error($link);
            $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
            $msg .= "<p>5秒后滚！</p>";
            echo $msg;
            echo $sql;
           header('refresh:5;url=./orders_update.php?error=2');
           
        }
        $ordersinfo = []; // 接收遍历的结果集

    
        if(mysqli_affected_rows($link) > 0){
            $ordersinfo = mysqli_fetch_assoc($result);
        }
      
?>
    
<!DOCTYPE html>
<html>
    <head>
        <title>update</title>
        <meta charset="utf-8"/>
        <script src="../public/js/jquery-2.1.3.min.js"></script>
            <!-- 先引入JS -->
            <script src="../public/js/bootstrap.min.js"></script>
            <!-- 引入样式表 -->
            <link rel="stylesheet" href="../public/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-theme.min.css">
    </head>
    <body>
        <div class="update-box" style="margin-top:100px;">
            <form class="form-horizontal" role="form" action="./orders_action.php?a=update&id=<?=$id;?>"  method="post" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">修改订单状态</label>
                    <div class="col-sm-5">
                    <select name="status" class="form-control ">
                    <option value="0" disabled>新订单</option>
                    <option value="1">已发货</option>
                    <option value="2" disabled>已收货</option>
                    <option value="3">无效订单</option>
                    </select>
                    </div>
                    <button type="submit" class="btn btn-warning">确认修改</button>
                </div>
            </form>
        </div>
    </body>
</html>    
