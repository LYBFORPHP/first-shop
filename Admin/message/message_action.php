<?php
    
    session_start();
    require '../../Common/config.php';

    $a = $_GET['a'];
    switch($a){

        case 'delete':
            $id = $_GET['id'];
            $id += 0;   // 触发了数据类型转换,强制转换为int 

            //连接
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
            //设置字符集
            mysqli_set_charset($link,'utf8');

            $sql = "delete from `".PIX."message` where `id`={$id}";
            $result = mysqli_query($link , $sql);
                if(mysqli_affected_rows($link) > 0){
                    echo '删除成功！';
                    header('refresh:3;url=./message_index.php');
                    exit;
                }
        break;
    }
