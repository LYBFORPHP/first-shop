<?php

    echo '<pre>';
        print_r($_POST);
    echo '</pre>';
    
    
    $id = $_GET['id'];
    require '../../Common/config.php';


    $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

    mysqli_set_charset($link , 'utf8');

    $sql="delete from `shop_user` where id={$id}";
    echo $sql;
    $result=mysqli_query($link,$sql);
    var_dump($result);

    mysqli_close($link);
    header('refresh:2;url=./showuser.php');
