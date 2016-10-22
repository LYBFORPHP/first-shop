<?php
    
    $a = $_GET['a'];
    require '../../Common/config.php';
   
    switch($a){
        //                     添加                 //
        case 'add':
            echo '添加友情链接:';

            $name = $_POST['name'];
            $address = $_POST['address'];

            //正则判断


            // 1.连接数据库
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "insert into `".PIX."friendslink` values(null,'{$name}','{$address}',now())";
             echo $sql;
            
            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
               
                header('refresh:3;url=./friendslink_add.php');
                exit;
            }
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>插入成功！</b>";
                echo "<b style='color:green;font-size:1cm;'>最后插入ID：" . mysqli_insert_id($link) . '</b>';
                header('refresh:3;url=./friendslink_index.php');
                exit;
            }

            //关闭连接
            mysqli_close($link);

        break;






        //              删除                        //
        
        case 'delete':
            $id = $_GET['id'];
            // 1.连接数据库
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "delete from `".PIX."friendslink` where `id` = {$id}";
             echo $sql;
            
            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
               
                header('refresh:3;url=./friendslink_add.php');
                exit;
            }
            if(mysqli_affected_rows($link) > 0){
                    echo '删除成功！3秒后滚';
                    header('refresh:3;url=./friendslink_index.php');
                        }
                exit;
        break;

        default :
            echo '未知错误！';
            header('refresh:3;url=./friendslink_index.php');
            exit;
    }
