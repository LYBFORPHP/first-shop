<?php 

    
    // 接收处理方式
    $a = $_GET['a'];
    switch($a){
        case 'add':
            
            // 1.接收数据
            $pid = $_POST['pid'];
            $path = $_POST['path'];
            $catename = $_POST['catename'];
         
            // 2.数据验证
            $preg='/^[\x{4e00}-\x{9fa5}0-9a-zA-Z][\x{4e00}-\x{9fa5}\w]*$/u';
            if(!preg_match($preg,$catename)){
            echo '<font color="red">输入错误,请输入正确信息</font>';
        
            header('refresh:3;url=../login/login.php?error=3');
            exit;
            }

            //限制层数不能超过三成
                    
            if(substr_count($path,',')>3){
            echo '<b style="color:red">不允许超过3层</b>';
                header('refresh:4;url=../index.php');
                exit;
            }



            // 3.操作数据库
            // 导入配置文件
            require '../../Common/config.php';
            // 1.连接
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
            // 2.设置字符集
            mysqli_set_charset($link,'utf8');

            // 3.准备SQL
            $sql = "insert into `".PIX."category`(`pid`,`name`,`path`) values({$pid},'{$catename}','{$path}')";
            // 先检查SQL语句是否有误
            echo $sql;

            // 4.发送
            $result = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                echo 'SQL语句错误:' . $sql;
                echo '错误信息：' . mysqli_error($link);
                exit;
            }

            // 6.处理
            if(mysqli_affected_rows($link) > 0){
                echo '插入成功！';
                header('refresh:3;url=./index.php?p=<?php echo $p;?>');
            }else{
                echo '插入失败！';
               header('refresh:3;url=./add.php');
            }

            
            // 7.关闭连接
            mysqli_close($link);

            break;




//                           删除区间                              //   


                                  
        case 'del':
            echo '删除分类。。。';
            echo '<pre>';
                print_r($_GET);
            echo '</pre>';
            // 1.接收要删除的ID
            $id = $_GET['id'];
        
            $id += 0;   // 触发了数据类型转换,强制转换为int 
        

            // 3.操作数据库
            // 导入配置文件
            require '../../Common/config.php';
            // 1.连接
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
            // 2.设置字符集
            mysqli_set_charset($link,'utf8');

            // 该分类下有子类，不可以删除！！！
            // 想知道是否成为父亲 , 只需要查询 PID 是否存在
            // 3.sql语句
            $sql = "select * from `shop_category` where `pid` = {$id} ";

            // 4.执行
            $result = mysqli_query($link , $sql);

            // 5.判断受影响行
           
            if(mysqli_affected_rows($link) > 0){
                echo '还有子分类！';
                header('refresh:3;url=./index.php');
            }else{
                $sql = "delete from `shop_category` where `id` = {$id}";
                $result = mysqli_query($link , $sql);
                if(mysqli_affected_rows($link) > 0){
                    echo '删除成功！';
                    header('refresh:3;url=./index.php');
                    exit;
                }
            }   

            // 7.关闭
            mysqli_close($link);
            break;
    }


