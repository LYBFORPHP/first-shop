<?php
  
    require './head_user.php';
    require '../../Common/functions.php';

    
    $a=$_GET['a'];
   
    
    switch($a){

//                   更新信息                    //
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
            if($pass!=''){
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

                if(md5($pass)!=$_SESSION['home_userinfo']['pass']){
                echo '原密码错误！！';
                    header('refresh:3;url=./user_update.php');
                    exit;
                }elseif($newPass!=$re_newPass){
                    echo '两次输入的密码不一致！';
                    header('refresh:3;url=./user_update.php');
                exit;
                }
                $pass=$newPass;
            }else{
                $pass=$_SESSION['home_userinfo']['pass'];

            }

            if($tel!=''){
                $preg='/^[1][358][0-9]{9}$/';
                if(!preg_match($preg,$tel)){
                     echo '<font color="red">手机号码格式错误</font>';
                    //回到注册页
                    //3秒后跳转
                   header('refresh:3;url=./user_update.php?error=2');
                    exit;
                }
            }
            if($realname!=''){
                $preg='/^[\x{4e00}-\x{9fa5}0-9a-zA-Z][\x{4e00}-\x{9fa5}\w]*$/u';
                if(!preg_match($preg,$realname)){
                    echo '<font color="red">姓名格式错误</font>';
                    //回到注册页
                    //3秒后跳转
                    header('refresh:3;url=./user_update.php?error=2');
                    exit;
                }
            }
            if($email!=''){
                $preg = '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/';
                if(!preg_match($preg,$email)){
                    echo '<font color="red">邮箱格式错误</font>';
                    //回到注册页
                    //3秒后跳转
                    header('refresh:3;url=./user_update.php?error=2');
                    exit;
                }
            }


            

            //判断是否有上传
            if($_FILES['myfile']['error'] == 4){
                //没有上传则使用默认值
                $picture = 'defaulticon.jpg';

            }else{
                // 用户已经上传
                // 导入文件
                
                $filed = 'myfile';//form表单的字段名
                $savePath = './usericon/'; //保存路径
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
            $sql = "update `".PIX."user` set `pass`='{$pass}',`icon`='{$icon}',`sex`='{$sex}',`email`='{$email}',`age`='{$age}',`tel`='{$tel}',`real_name`='{$realname}' where `id`={$userid}";
             
             
            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
                
                header('refresh:3;url=./user_update.php');
                exit;
            }
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>成功！</b>";
                "<b style='color:green;font-size:1cm;'>最后插入ID：" . mysqli_insert_id($link) . '</b>';
                header('refresh:3;url=./user_update.php');
                exit;
            }else{echo "<b style='color:green;font-size:1cm;'>无修改</b>";
                 header('refresh:3;url=./user_update.php');
                }

                mysqli_close($link);
                break;

        case 'status':
            $id=$_GET['id'];
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            $sql = "select * from `".PIX."orders` where `id`={$id}";
            $result = mysqli_query($link , $sql);
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
                
                header('refresh:3;url=./user_update.php');
                exit;
            }
            if(mysqli_affected_rows($link) > 0){
                $ordersStatus = mysqli_fetch_assoc($result);
            }
           
            mysqli_free_result($result);
            mysqli_close($link);
            if($ordersStatus['status']==0){
                echo '<div style="width:300px;text-align:center;margin:100px auto;">';
                echo '<b class="text-center" style="color:green;">请付款！！</b>';
                echo '</div>';
                header('refresh:3;url=./user.php');
                exit;
            }elseif($ordersStatus['status']==1){
                $ordersStatus = $ordersStatus['status'];
                $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

                // 2.设置字符集
                mysqli_set_charset($link , 'utf8');
                $sql = "update `".PIX."orders` set `status`='2' where `id`={$id}";
               
                // 4.发送执行
                $res = mysqli_query($link , $sql);

                // 5.检测错误
                if(mysqli_errno($link) > 0){
                    $errno = mysqli_errno($link);
                    $error = mysqli_error($link);

                    echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
                
                    header('refresh:3;url=./user.php');
                    exit;
                }
                if(mysqli_affected_rows($link) > 0){
                    
                    header('location:./user.php');
                    exit;
                }
                

            mysqli_close($link);
            }else{
                    header('location:./user.php');
                    exit;
                }
        break;
            

    }




    require './footer_user.php';
?>
