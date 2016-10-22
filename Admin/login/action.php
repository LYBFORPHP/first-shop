<?php
    
    //开启会话
    session_start();
    
    require '../../Common/config.php';


    //接收处理方式 ： login执行登录区间，out:执行退出登录
    
    $a = $_GET['a'];
    switch($a){
        case 'login':
            echo '执行登录！';


    //接收用户传输的信息 
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $code = $_POST['code'];
   



    //正则匹配
    
    //检查帐号格式
    $preg='/^[a-zA-Z][a-zA-Z0-9_]{1,}$/';
    if(!preg_match($preg,$user)){
        echo '<font color="red">帐号格式错误</font>';
        //回到注册页
        //3秒后跳转
        header('refresh:3;url=./login.php?error=3');
        exit;
    }

    //检查密码
    if(strlen($pass) < 2){
        echo '<font color="red">密码至少2位</font>';
        header('refresh:3;url=./login.php?error=2');
        exit;
    }

    //判断验证码
    $yzm=$_SESSION['code'];
    if(strtolower($code) != strtolower($yzm)){
        $msg = "<p><b style='color:red;font-size:1cm;'>验证码错误！</b></p>";
        $msg .= "<p>3秒后滚！</p>";
        echo $msg;
        header('refresh:3;url=./login.php?error=1');
        exit;
            }
    

    //连接数据库
    $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    // 3.准备SQL
    $sql = "select * from `shop_user` where `user` = '{$user}'";

    // 4.执行
    $result = mysqli_query($link , $sql);

    // 5.检测错误
    $errno = mysqli_errno($link);
        if($errno > 0 ){
            $error = mysqli_error($link);
            $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
            $msg .= "<p>5秒后滚！</p>";
            echo $msg;
            echo $sql;
            header('refresh:5;url=./index.php?error=2');
            exit;
        }
    //处理
    // 受影响行 大于 0
    if(mysqli_affected_rows($link) > 0){
        // 从结果集获取信息
        $info = mysqli_fetch_assoc($result);

    //判断是否有权登录
    if($info['level'] > 1){
        echo '<b style="color:red;">无权登录</b>';
        header('refresh:3;url=./login.php?s=4');
        exit;
    }    
        
    //验证密码是否正确    
    if($info['pass'] === md5($pass)){
            
            // 将用户的信息存储在 session 
            $_SESSION['user'] = $info;    

            echo '<b style="color:green;">登录成功！</b>';
            header('refresh:3;url=../index.php?s=ok');
            }
            else{
            echo '密码错误！！！！！';
            header('refresh:3;url=./login.php?error=2');
            exit;
        }
    }else{
        echo '帐号错误！！！！！';
        header('refresh:3;url=./login.php?error=1');
        exit;
    }
    // 6.释放资源
    mysqli_free_result($result);

    // 7.关闭连接
    mysqli_close($link);

    break;


//                   执行退出                                        //
    case 'logout':
            echo '退出。。';
            session_destroy();
            header('location:./login.php');
    break;

       



//                              执行修改                             //
    case 'update':

      $id=$_POST['userid'];
      $integral = $_POST['integral'];
      $level=$_POST['level'];
      switch($level){
          case '超级管理员':
            $level = 0;
            break;
          case '管理员':
            $level = 1;
            break;
          case '铜牌会员':
            $level = 2;
            break;
          case '银牌会员':
            $level = 3;
            break;
          case '金牌会员':
            $level = 4;
            break;
          case '钻石会员':
            $level = 5;
            break;
            default:
            echo '输入错误，请重新选择';
            header('refresh:3;url=./update.php');
            exit;
        }

    


       //正则匹配
       //积分只能为数
        $preg='/^\d+$/';
        if(!preg_match($preg,$integral)){
            echo '<font color="red">数据错误</font>';
            // 滚回注册页
            // 3秒后跳转
            header('refresh:3;url=./login.php?error=3');
            exit;
        }
        $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

        // 2.设置字符集
        mysqli_set_charset($link , 'utf8');
       
        // 3.准备SQL语句
        $sql = "update `shop_user` set `integral`=$integral, `level`=$level where `id`=$id ";
        echo $sql;

        $result = mysqli_query($link , $sql);

        // 5.检测错误
        if(mysqli_errno($link) > 0){
            $errno = mysqli_errno($link);
            $error = mysqli_error($link);
            echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
            header('refresh:3;url=../user/showuser.php?errno={$errno}');
            exit;
        }
       
        echo '受影响行：' . mysqli_affected_rows($link);
        

        mysqli_close($link);
         
        header('refresh:3;url=../user/showuser.php');
        break;



//                               删除部分                           //
 

    case 'delete':
      
        $id = $_GET['id'];
    
        $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

        mysqli_set_charset($link , 'utf8');

        $sql = "select *  from `shop_user` where id={$_GET['id']}" ;
        $result = mysqli_query($link , $sql);

        // 5.检测错误
        if(mysqli_errno($link) > 0){
            $errno = mysqli_errno($link);
            $error = mysqli_error($link);
            echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
            exit;
        }
        $userlist = []; // 接收遍历的结果集

        echo '受影响行：' . mysqli_affected_rows($link);
        if(mysqli_affected_rows($link) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $userlist= $row;
            }
        }
        
        
         
        if($_SESSION['user']['level']>=$userlist['level']){
          echo '无权删除';
          header('refresh:3;url=../user/showuser.php');
          exit;
        }
        $sql="delete from `shop_user` where id={$id}";
       
        $result=mysqli_query($link,$sql);
        // var_dump($result);

        mysqli_close($link);
        header('refresh:2;url=../user/showuser.php');
        break;

        default:
            echo '你想干嘛？';
            break;
    }
    exit;

