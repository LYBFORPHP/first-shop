<?php
    
    //接收处理方式
    $a = $_GET['a'];
    session_start();
    //根据不同操作执行不同区间
    switch($a){
        case 'add':
            echo '执行商品添加<br>';
            echo '<pre>';
                print_r($_POST);
            echo '</pre>';
            echo '<pre>';
                print_r($_FILES);
            echo '</pre>';
            echo '<pre>';
                print_r($_SESSION);
            echo '</pre>';
           


            //接收数据
            $cateid = $_POST['cateid'];
            $name = $_POST['goodsname'];
            $price = $_POST['price'];
            $store = $_POST['store'];
            $desc = $_POST['description'];
            $desc = trim($desc);
            $time = time();

            //数据验证
             





            //上传文件
            //判断是否有上传
            if($_FILES['myfile']['error'] == 4){
            //没有上传则使用默认值
                $picture = 'default.jpg';
            }else{

                // 用户已经上传
                // 导入文件
                require '../../Common/functions.php';
                $filed = 'myfile';//form表单的字段名
                $savePath = '../../Common/goodsimage/'; //保存路径
                $savePath = rtrim($savePath, '/') . '/';
                $maxSize = 0;//限制大小，为0表示不限制

                $allowType = array('image/png','image/jpeg','image/gif','image/jpg');
                //执行上传
                $fileName=$savePath.$_FILES['myfile']['name'];
                
                $upRes = upload($filed , $savePath , $maxSize , $allowType);
                //返回数组
                //如果上传成功，执行缩放
                $pic = $savePath . $upRes['name'];
                
                
                //自定义缩放函数zoom()在functions.php中
                zoom($pic,$savePath,50,50, $prefix = 's_');
                // 商品列表 使用 235,300
                zoom($pic,$savePath,235,300, $prefix = 'm_');
                // 商品列表 使用 500,600
                zoom($pic,$savePath,500,600, $prefix = 'l_');
               
                   
               
                //保存好不同尺寸缩放图后将原图删除
                unlink($pic);//删除上传后生成的原图
                unlink($fileName);//删除原图


                //保存的名字
                $picture = $upRes['name'];
            }
            echo '保存在数据库的名字为: '.$picture; 
            // 4.数据库操作.
            // 导入配置文件
            require '../../Common/config.php';

            // 1.连接数据库
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "insert into `".PIX."goods`(`cateid`,`picture`,`name`,`price`,`store`,`description`,`status`,`addtime`) values({$cateid},'{$picture}','{$name}',{$price},{$store},'{$desc}',0,{$time})";
             echo $sql;

            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
                header('refresh:3;url=./goods_add.php');
                exit;
            }
            //如果受影响行大于0，则插入成功
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>插入成功！</b>";
                header('refresh:3;url=./goods_index.php');
                exit;
            }

            //关闭连接
            mysqli_close($link);
        break;

//__________________________新增结束_________________________//




// _________________________删除_______________________________//


        case 'del':
            echo '执行删除！';
            if($_SESSION['user']['level'] > 1){

                echo '无权删除商品！';
                header('refresh:3;url=./goods_index.php?error=1');
                exit;
            }

            $id = $_GET['id'];
        
            $id += 0;   // 触发了数据类型转换,强制转换为int 
        
            require '../../Common/config.php';
            // 1.连接
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
            // 2.设置字符集
            mysqli_set_charset($link,'utf8');
            $sql = "select * from `shop_goods` where `id` = {$id}";
            $result = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
                
                header('refresh:3;url=./goods_index.php');

                exit;
            }
           
            if(mysqli_affected_rows($link) > 0){
                $goodlist = mysqli_fetch_assoc($result);
               
            }
            $pic = $goodlist['picture'];
   

            //如果是默认图片，则图片不用删除
            if($pic == 'default.jpg'){
                echo '默认图片不用删';
            }else{
                $dirPath = '../../Common/goodsimage/';
                if(!is_dir($dirPath)) return false;
                // 路径处理
                $dirPath = rtrim($dirPath,'/') . '/';
                
                // 打开目录(句柄或标记)
                $source = opendir($dirPath);
                // 读取
         
                while(false !== ($fileName = readdir($source))){
                    // 跳过 . 和 ..
                    if($fileName == '.' || $fileName == '..') continue;
                    $path = $dirPath . $fileName;
                 
                    echo $path.'<br>';
                      
                    if(strstr($path,'_')){
                        $str=explode('_',$path);
       
                      
                        if($goodlist['picture'] == $str[1] ){
                            echo '删除图片成功';
                            unlink($path);
                        }
                    }
                }
            }
       
            $sql = "delete from `shop_goods` where `id` = {$id}";
            $result = mysqli_query($link , $sql);
            if(mysqli_affected_rows($link) > 0){
                echo '删除成功！3秒后滚';
                header('refresh:3;url=./goods_index.php');
                exit;
            }
               


        break;

//_____________________________删除结束_____________________________//





//_____________________________更新_______________________________//

        case 'update': 
            echo '更新';
          
            if($_FILES['myfile']['error'] == 4){
            //没有上传则使用默认值
            $picture = $_POST['picture'];
            $upRes['name']=$picture; //保存路径名
                
              
             }
             else{
                // 用户已经上传
                // 导入文件
                require '../../Common/functions.php';
                $filed = 'myfile';//form表单的字段名
                $savePath = '../../Common/goodsimage/'; //保存路径
                
                $savePath = rtrim($savePath,'/') . '/';
                $maxSize = 0;//限制大小，为0表示不限制

                $allowType = array('image/png','image/jpeg','image/gif','image/jpg');
                //执行上传
                $upRes = upload($filed , $savePath , $maxSize , $allowType);
    
                //如果上传成功，执行缩放
                $pic = $savePath . $upRes['name'];//图片的完整路径
                   
                  
                //自定义缩放函数zoom()在functions.php中
                zoom($pic,$savePath,50,50, $prefix = 's_');
                // 商品列表 使用 235,300
                zoom($pic,$savePath,235,300, $prefix = 'm_');
                // 商品列表 使用 500,600
                 zoom($pic,$savePath,500,600, $prefix = 'l_');
                //保存好不同尺寸缩放图后将原图删除
                
          
               
                unlink($pic);
                $pic = $savePath.$_FILES['myfile']['name'];
                
                unlink($pic);
                
                //保存的名字
                $picture = $upRes['name'];
            }
               
            // 4.数据库操作.
            require '../../Common/config.php';
                $cateid = $_POST['cateid'];
                $picture = $upRes['name'];
                $goodsname=$_POST['goodsname'];
                $price = $_POST['price'];
                $store = $_POST['store'];
                $description = $_POST['description'];
                $goodsid = $_POST['goodsid'];

            // 1.连接数据库
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "update `".PIX."goods` set `cateid`={$cateid},`picture`='{$picture}',`name`='{$goodsname}',`price`={$price},`store`={$store},`description`='{$description}' where `id`={$goodsid}";
            
             
            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>"
                header('refresh:3;url=./goods_update.php');
                exit;
            }
            //如果受影响行大于0，则插入成功
           
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>更改成功！</b>";
              
                header('refresh:3;url=./goods_index.php');
                exit;
            }else{echo '无修改';
                 header('refresh:3;url=./goods_index.php');
                }
                

            //关闭连接
            mysqli_close($link);
        break;
          


//                       上架                        //
        case 'up':
            echo '上架';
      
            $goodsid = $_GET['id'];
            require '../../Common/config.php';
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "update `".PIX."goods` set `status` = 1 where `id`={$goodsid}";
          
            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);
                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
         
                header('refresh:3;url=./goods_index.php');
                exit;
            }
            //如果受影响行大于0，则插入成功
            echo mysqli_affected_rows($link);
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>成功！</b>";
                header('refresh:3;url=./goods_index.php');
                exit;
            }else{
                echo '无修改';
                header('refresh:3;url=./goods_index.php');
              }
              

            //关闭连接
            mysqli_close($link);
        break;
          

//               下架                        //
             
        case 'down':
            echo '下架';
           
            $goodsid = $_GET['id'];
            require '../../Common/config.php';
            $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

            // 2.设置字符集
            mysqli_set_charset($link , 'utf8');

            // 3.准备SQL语句
            $sql = "update `".PIX."goods` set `status` = 2 where `id`={$goodsid}";
            echo $sql;

            // 4.发送执行
            $res = mysqli_query($link , $sql);

            // 5.检测错误
            if(mysqli_errno($link) > 0){
                $errno = mysqli_errno($link);
                $error = mysqli_error($link);

                echo "<b style='color:red;font-size:1cm;'>Error {$errno}: {$error}</b>";
           
                header('refresh:3;url=./goods_index.php');
                exit;
            }
            //如果受影响行大于0，则插入成功
            
            if(mysqli_affected_rows($link) > 0){
                echo "<b style='color:green;font-size:1cm;'>成功！</b>";
                
                header('refresh:3;url=./goods_index.php');
                exit;
            }else{
                echo '无修改';
                header('refresh:3;url=./goods_index.php');
                }
                

            //关闭连接
            mysqli_close($link);
        break;

        default:
        echo '要执行什么操作？？';
    }
