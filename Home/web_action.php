<?php
    session_start();
    

    require '../Common/config.php';
    ob_start();


$a= $_GET['a'];
switch($a){


//               注册新用户            //
 case 'registe':
    echo '执行注册';
    if($_POST['check']=='-1'){
        echo '请阅读《vancl凡客诚品服务条款》';
        exit;
    }
    $user = $_POST['userName'];
    $pass = $_POST['pass'];
    $re_pass = $_POST['re_pass'];
    $code = $_POST['yzm'];
    $preg='/^[a-zA-Z][a-zA-Z0-9_]{1,}$/';
    if(!preg_match($preg,$user)){
        echo '<font color="red">帐号格式错误</font>';
        //滚回注册页
        //3秒后跳转
        header('refresh:3;url=./login/web_register.php?error=3');
        exit;
    }

    //检查密码
    if(strlen($pass) < 2){
         echo '<font color="red">密码至少2位</font>';
        header('refresh:3;url=./login/web_register.php?error=2');
        exit;
    }
    if($pass !== $re_pass){
        echo '两次输入的密码不一致';
         header('refresh:3;url=./login/web_register.php?error=2');
        exit;


    }
    $pass = md5($pass);
    //判断验证码
    $yzm=$_SESSION['code'];
    if(strtolower($code) != strtolower($yzm)){
                $msg = "<p><b style='color:red;font-size:1cm;'>验证码错误！</b></p>";
                $msg .= "<p>3秒后滚！</p>";
                echo $msg;
                header('refresh:3;url=./login/web_register.php?error=1');
                exit;
            }
            

    //连接数据库
    $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');


    //检测用户名是否已经存在
    $sql="select `user` from `".PIX."user`";
    $result = mysqli_query($link , $sql);
    // 5.检测错误
            $errno = mysqli_errno($link);
            if($errno > 0 ){
                $error = mysqli_error($link);
                $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
                $msg .= "<p>5秒后滚！</p>";
                echo $msg;
                echo $sql;
               // header('refresh:5;url=./index.php?error=2');
                exit;
            }
            $userlist = []; // 接收遍历的结果集

    echo '受影响行：' . mysqli_affected_rows($link);
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $userlist= $row;

            if($userlist['user']===$user){
                echo '该帐号名已被注册!请重新输入！';
                header('refresh:5;url=./main_index.php?error=2');
                exit;
            }
        }
    }


    // 3.准备SQL
    $sql = "insert into `".PIX."user`(`user`,`pass`,`addtime`) values('{$user}','{$pass}',unix_timestamp())";
    echo $sql;
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
              header('refresh:5;url=./login/main_index.php?error=2');
                exit;
            }
    //处理
    // 受影响行 大于 0
    if(mysqli_affected_rows($link) > 0){
       

echo '注册成功！！';
echo "<b style='color:green;font-size:1cm;'>最后插入ID：" . mysqli_insert_id($link) . '</b>';
header('refresh:5;url=./login/main_index.php?s=ok');
}
break;




//               登录区间                     //
    case 'login':
    echo '执行登录';

    $user_name=$_POST['user_name'];
    $user_pass=$_POST['user_pass'];
    $code=$_POST['yzm'];

//判断验证码
     $yzm=$_SESSION['code'];
    if(strtolower($code) != strtolower($yzm)){
                $msg = "<p><b style='color:red;font-size:1cm;'>验证码错误！</b></p>";
                $msg .= "<p>3秒后滚！</p>";
                echo $msg;
                header('refresh:3;url=./login/web_login.php?error=1');
                exit;
            }
            
            
    //判断是否用户存在
    //连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');


    //检测用户名是否已经存在
    $sql="select * from `".PIX."user` where `user`='{$user_name}'";
    $result = mysqli_query($link , $sql);
    // 5.检测错误
            $errno = mysqli_errno($link);
            if($errno > 0 ){
                $error = mysqli_error($link);
                $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
                $msg .= "<p>5秒后滚！</p>";
                echo $msg;
                echo $sql;
               header('refresh:5;url=./login/main_index.php?error=2');
               
            }
            $userinfo = []; // 接收遍历的结果集

    echo '受影响行：' . mysqli_affected_rows($link);
    if(mysqli_affected_rows($link) > 0){
       $userinfo = mysqli_fetch_assoc($result);
            
           if($userinfo['pass'] === md5($user_pass)){

           $_SESSION['home_userinfo'] = $userinfo;
           echo '结果：';
            echo '<pre>';
                print_r($_SESSION);
            echo '</pre>';
         
            echo '<b style="color:green;">登录成功！</b>';
            echo $_SESSION['REFERER'];

            header('refresh:3;url='.$_SESSION['REFERER']);
            exit;
           }  else{
            echo '密码错误！！！！！';
            header('refresh:3;url=./login/web_login.php?error=2');
            exit;
        }
           
           }else{
            echo '用户名不存在！';
            header('refresh:3;url=./login/web_login.php?s=4');
            exit;
}

            
        
//               登录区间                      //



//              注销区间                     //
           case 'logout':
            echo '退出。。';
            session_destroy();
            header('location:./web_login.php');
            break;

//        注销结束                 //









//           加入购物车          //
            case 'addshopcar':

            if(!isset($_SESSION['home_userinfo'])){
                header('location:./login/web_login.php');
                exit;
            }
            
            // 商品ID
            $gid = $_GET['gid'];
            // 购买数量
            $num = $_GET['num'];
           
            // 如果下标已经存在，表示购物车中已经存在该商品了
            if(isset($_SESSION['shopcar'][$gid])){
                // 存在，数量增加
                echo '该商品已经存在了';
                $_SESSION['shopcar'][$gid]['num'] +=$num;
            }else{
                

                $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败，错误信息:'.
                    mysqli_connect_error());

                mysqli_set_charset($link,'utf8');

                $sql="select * from `".PIX."goods` where `id` = {$gid}";
                $result = mysqli_query($link,$sql);
                $goods = [];
                if(mysqli_affected_rows($link)){
                    $goods = mysqli_fetch_assoc($result);

                    $goods['num']=$num;
                    
                  mysqli_free_result($result);
                }

                //在SESSION中建一个建一个键名为shopcar的数组存放商品
                $_SESSION['shopcar'][$gid] = $goods;

                 
            }

            //跳到购物车
            header('location:./shopcar/cart.php');

        break;




 //              添加到购物车                 //
 


 



  //               购物车+1操作         //
            case 'jia':
            $id = $_GET['id'];
            $_SESSION['shopcar'][$id]['num']++ ;

            header('location:./shopcar/cart.php');
            break;




//                购物车-1操作     //

            case 'jian':
             $id = $_GET['id'];

            $_SESSION['shopcar'][$id]['num']-- ;

            //购物车内最少有一件商品
            if($_SESSION['shopcar'][$id]['num']<1){
            $_SESSION['shopcar'][$id]['num']=1;
        }   
            //最多不能超过库存
            if($_SESSION['shopcar'][$id]['num']>$_SESSION['shopcar'][$id]['store']){
            $_SESSION['shopcar'][$id]['num']=$_SESSION['shopcar'][$id]['store'];
        }   
            header('location:./shopcar/cart.php');
            break;
             




            //                        删除购物车内商品        //
            case 'delete':
            $id = $_GET['id'];
            echo '<pre>';
                print_r($_SESSION['shopcar']);
            echo '</pre>';

            unset($_SESSION['shopcar'][$id]);
            header('location:./shopcar/cart.php');
            break;







            //     付款                                   //
            case 'pay':
            echo '<pre>';
        print_r($_POST);
    echo '</pre>';
    echo '<pre>';
        print_r($_SESSION);
    echo '</pre>';
          echo '已提交';
            //  接收订单数据
            $linkman=$_POST['linkman'] ;
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $totally = $_POST['totally'];
            $uid = $_SESSION['home_userinfo']['id'];
            $num = $_POST['num'];   
            $status = 0;
            //默认状态是新订单
              
            
              //连接数据库 
              $link = mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
              // 2.设置字符集
              mysqli_set_charset($link , 'utf8');

              //SQL语句
              $sql = "insert into `".PIX."orders` values(null,{$uid},'{$linkman}','{$address}','{$totally}',unix_timestamp(),'{$status}');";
              echo $sql;
            
              $result = mysqli_query($link,$sql);
              if(mysqli_errno($link)){
                $errno = mysqli_errno($link);
                 $error = mysqli_error($link);
                $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
                $msg .= "<p>5秒后滚！</p>";
              }
              //处理
              if(mysqli_affected_rows($link)){
                echo '添加成功！';

                //得到订单ID
                $orderid=mysqli_insert_id($link);
                echo $orderid;
              
                
              }

              //插入商品详情到数据库
            foreach($_SESSION['shopcar'] as $k => $v){
                $id = $v['id'];
                $name = $v['name'];
                $picture = $v['picture'];
                $price = $v['price'];
                $num = $v['num'];
                $sql="insert into `".PIX."detail` values(null,{$orderid},{$id},'{$picture}','{$name}',{$price},{$num})";
                $result = mysqli_query($link,$sql);
                if(mysqli_errno($link)){
                    $errno = mysqli_errno($link);
                    $error = mysqli_error($link);
                    $msg = "<p style='color:red;font-size:1cm;'><b>Error {$errno}:{$error}</b></p>";
                    $msg .= "<p>5秒后滚！</p>";
                    header("refresh:3;url=./shopcar/cart2.php?error=2");
                    exit;
            }
            //处理
                if(mysqli_affected_rows($link)){
                    echo '添加成功！';
                    header("refresh:3;url=./shopcar/cart3.php?orderid=$orderid");
                // exit;
            }
            }
            
             
              mysqli_close($link);
            break; 



    //                 清空购物车                           //
    
            case 'clearall':
            echo '<pre>';
                print_r($_SESSION['shopcar']);
            echo '</pre>';
           
           $_SESSION['shopcar'] = [];
            
            header('location:./shopcar/cart.php');
            break;


            //         提交订单       //
           

            case 'submit':
            if(empty($_SESSION['shopcar'])){
                echo '请挑选商品后再提交订单！';
                header('refresh:3;url=./main_index.php');
                exit;
            }else{
                echo '订单提交成功，请填写收货信息';
                header('refresh:3;url=./shopcar/cart2.php');
                exit;
            }
            break;
        default:
            echo '你想干嘛？';
            break;
    








}         //switch结束
