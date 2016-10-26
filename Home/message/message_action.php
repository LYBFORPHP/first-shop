<?php
    
    session_start();
    require '../../Common/config.php';
    $message = $_POST['message'];
    $gid = $_GET['gid'];
    
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

    //设置字符集
    mysqli_set_charset($link , 'utf8');
    if(!isset($_SESSION['home_userinfo'])){
        echo '不能评论该商品';
        header("refresh:3;url=../detail.php?gid=$gid");
        exit;
    }else{


        //获取用户ID
        $userid=$_SESSION['home_userinfo']['id'];
        $user = $_SESSION['home_userinfo']['user'];

        $sql = "select * from shop_detail where `goodsid` in(select `id` from `shop_orders` where `uid` = {$userid})";
        $result = mysqli_query($link , $sql);

        if(!mysqli_affected_rows($link)){
            echo '未购买物品不能评论';
            header("refresh:3;url=../detail.php?gid=$gid");
        exit;
        }
        $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

        //设置字符集
         mysqli_set_charset($link , 'utf8');


        $sql = "select count(*) total from `".PIX."message` where `uid`={$userid} and `gid`={$gid}";

        $result = mysqli_query($link , $sql);
        
        $total = 0;
        //判断
        if(mysqli_affected_rows($link)){
            $total = mysqli_fetch_assoc($result);//$total = Array( [total] => 总数 )
            //取出数组中第一个值，即将总数取出
            $total = $total['total'];//$total['total']中'total'为count(*)的别名写作: [count(*)] => 总页数/total => 总数 
        }

        if($total>=2){
            echo '每个用户，每件商品最多评价两次！';

            header("refresh:3;url=../detail.php?gid=$gid");
            mysqli_free_result($result);
            mysqli_close($link);
         
            exit;
        }


        $sql = "insert into `".PIX."message` values(null,{$userid},'{$gid}','{$user}','{$message}',unix_timestamp())";
       
        
        $result = mysqli_query($link,$sql);

        //检测错误
        if(mysqli_errno($link)>0){
            $errno = mysqli_errno($link);
            $error = mysqli_error($link);
            echo "<p><b style='font-size:1cm;color:red;'>Error:{$sql},错误号：{$errno},错误信息:{$error}</b></p>";
            header('refresh:3;url=../main_index.php');
            exit; 
        }
        if(mysqli_affected_rows($link)>0){
            $messageinfo=mysqli_fetch_assoc($result);
            header("location:../detail.php?gid={$gid}");
        }
         mysqli_free_result($result);
         mysqli_close($link);
         exit;
    }
