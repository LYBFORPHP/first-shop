<?php
  
    require './head_user.php';
    require '../../Common/functions.php';

    echo '<pre>';
        print_r($_POST);
    echo '</pre>';
    echo '<pre>';
        print_r($_FILES);
    echo '</pre>';
    $a=$_GET['a'];
    echo '<pre>';
        print_r($_SESSION['home_userinfo']);
    echo '</pre>';
    
    switch($a){

        case 'updateinfo':

        $userid=$_POST['userid'];
        $user = $_POST['user'];
        $icon = $_POST['icon'];
        $pass = $_POST['pass'];
        $newPass = $_POST['newPass'];
        $re_newPass = $_POST['re_newPass'];
        $sex = $_POST['sex'];
        $age = strtotime($_POST['birth']);//存时间戳
        $tel = $_POST['tel'];
        $realname = $_POST['realname'];
        $email = $_POST['email'];
        //数据验证
        //检查密码
    if(strlen($pass) < 2){
        echo '<font color="red">密码至少应该为2位</font>';
        header('refresh:3;url=./user_update.php?error=2');
        exit;
    }
    if(strlen($newPass) < 2){
        echo '<font color="red">密码至少应该为2位</font>';
        header('refresh:3;url=./user_update.php?error=2');
        exit;
    }
    if(strlen($re_newPass) < 2){
        echo '<font color="red">密码至少应该为2位</font>';
        header('refresh:3;url=./user_update.php?error=2');
        exit;
    }

    $preg='/^[1][358][0-9]{9}$/';
    if(!preg_match($preg,$tel)){
         echo '<font color="red">手机号码格式错误</font>';
        //回到注册页
        //3秒后跳转
       header('refresh:3;url=./user_update.php?error=2');
        exit;
    }
     
    $preg='/^[a-zA-Z][a-zA-Z]{1,}$/';
    if(!preg_match($preg,$user)){
        echo '<font color="red">姓名格式错误</font>';
        //回到注册页
        //3秒后跳转
        header('refresh:3;url=./user_update.php?error=2');
        exit;
    }

    $preg = '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/';
    if(!preg_match($preg,$email)){
        echo '<font color="red">邮箱格式错误</font>';
        //回到注册页
        //3秒后跳转
        header('refresh:3;url=./user_update.php?error=2');
        exit;
    }


         if(md5($pass)!=$_SESSION['home_userinfo']['pass']){
            echo '原密码错误！！';
            header('refresh:3;url=./user_update.php');
            exit;
         }elseif($newPass!=$re_newPass){
            echo '两次输入的密码不一致！';
            header('refresh:3;url=./user_update.php');
            exit;
         }

         //判断是否有上传
             if($_FILES['myfile']['error'] == 4){
                //没有上传则使用默认值
                $picture = 'defaulticon.jpg';

             }else{
                // 用户已经上传
                // 导入文件
                
                $filed = 'myfile';//form表单的字段名
                $savePath = '../../Common/goodsimage/'; //保存路径
                $savePath = rtrim($savePath, '/') . '/';
                $maxSize = 0;//限制大小，为0表示不限制

                $allowType = array('image/png','image/jpeg','image/gif','image/jpg');
                //执行上传
                $fileName=$savePath.$_FILES['myfile']['name'];
                
                $upRes = upload($filed , $savePath , $maxSize , $allowType);
                 $icon = $upRes['name'];
    }
    
    

                  $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "update `".PIX."user` set `pass`='{$newPass}',`icon`='{$icon}',`sex`='{$sex}',`email`='{$email}',`age`={$age},`tel`='{$tel}',`real_name`='{$realname}' where `id`={$userid}";
             echo $sql;
             
            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
                // 遗留的问题：已经上传的图片怎么办？  删除
                // header('refresh:3;url=./user_update.php');
                exit;
            }
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>成功！</b>";
                echo "<b style='color:green;font-size:1cm;'>最后插入ID：" . mysqli_insert_id($link) . '</b>';
                header('refresh:3;url=./user_update.php');
                exit;
            }else{echo '无修改';
                 header('refresh:3;url=./user_update.php');
                }

                mysqli_close($link);
                break;



    }




















    require './footer_user.php';
?>
