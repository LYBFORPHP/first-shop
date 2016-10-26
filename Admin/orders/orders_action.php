<?php
    
    session_start();
    require '../../Common/config.php';
    ob_start();

    $a = $_GET['a'];
    





    //           订单修改                     //
    
    switch($a){
        case 'update':
            $status = $_POST['status'];
            $id = $_GET['id'];
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');
            
            $sql = "update `".PIX."orders` set `status`={$status} where `id`={$id}";

            $result = mysqli_query($link , $sql);
            // 5.检测错误
            $errno = mysqli_errno($link);
            if($errno > 0 ){
                $error = mysqli_error($link);
                $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
                $msg .= "<p>5秒后滚！</p>";
                echo $msg;
               header('refresh:5;url=./orders.php?error=2');
            }

            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>成功！</b>";
                 header('refresh:3;url=./orders.php');
                exit;
            }else{echo '无修改';
                 header('refresh:3;url=./orders.php');
                }
        
        break;

    
