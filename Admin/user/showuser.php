<?php
    
    // 先导入配置文件
    require '../../Common/config.php';

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    // 1.每页显示条数,分页显示
    $num = 5;

    // 3.准备SQL语句
    $sql = "select count(*) total from `shop_user`";
    $total = mysqli_query($link , $sql);
    $total = mysqli_fetch_assoc($total)['total'];
   
    $totalPage = ceil($total / $num);
    
    $p = isset($_GET['p']) ? $_GET['p'] : 1 ;
    // 如果当前页小于1，则重新设置为最小页码
    if($p < 1){
        $p = 1;
    }
    // 如果当前页大于总页码，则重新设置为最大页码
    if($p > $totalPage){
        $p = $totalPage;
    }
    

    // 5.求偏移量
    $offset = ($p - 1) * $num;

    if($total>0){   
    // 倒序
    $sql = "select * from `".PIX."user` order by `id` limit {$offset},{$num}";}
    
    
 

    // 4.发送
    $result = mysqli_query($link , $sql);

    // 5.检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }

    // 6.处理
    $userlist = []; // 接收遍历的结果集

    
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $userlist[] = $row;
        }
    }

    // 7.释放资源   
    mysqli_free_result($result);

    // 8.关闭连接
    mysqli_close($link);


    $level = ['超级管理员','管理员','铜牌会员','银牌会员','金牌会员','钻石会员'];
    $sex = ['女','男','保密'];

?>
<!doctype html>
<html>
    <head>
        <title>Document</title>
        <meta charset='utf-8'/>
         <script src="../public/js/jquery-2.1.3.min.js"></script>
        <!-- 先引入JS -->
        <script src="../public/js/bootstrap.min.js"></script>
        <!-- 引入样式表 -->
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    </head>
    <body>
        <h1>商品浏览</h1>
        <!--               搜索栏                     -->
        <div class="container">
      

            <!--             搜索第一行
                                 -->
            <div class="row">
                <form action="./goods_index.php" class="form-inline">
                    <select name="search" style="width:200px" class="form-control">
                        <option value="">请选择</option>
                        <option value="name">商品名</option>
                        <option value="id">ID</option>
                    </select>
                    <div class="form-group">
                        <label for="exampleInputName2"> </label>
                        <input name="content" type="text" class="form-control" id="exampleInputName2" value="<?php  echo $content = isset($_GET['content']) ? $_GET['content'] : '' ;?>">
                    </div>
                    <button type="submit" class="btn btn-default" style="font-weight:bold;background:lightblue;">搜索</button>
                </form>
            </div>
        <h2>用户浏览</h2>

        <table class="table table-hover">
            <tr>
                <td>ID</td>
                <td>帐号</td>
                <td>头像</td>
                <td>积分</td>
                <td>等级</td>
                <td>性别</td>
                <td>邮箱</td>
                <td>年龄</td>
                <td>电话</td>
                <td>姓名</td>
                <td>添加时间</td>
                <td>操作</td>
            </tr>
            
            <!-- 如果数组大于0，则开始遍历 -->
            <?php if(count($userlist) > 0): ?>

            <!-- 开始遍历 -->
            <?php foreach($userlist as $key => $val): ?>
            <tr>
                <td><?php echo $val['id']; ?></td>
                <td><?php echo $val['user']; ?></td>
                <td>
                <?php if($val['icon']=='default.jpg'):?>
               <img style="width:50px;" src="../../Home/user/usericon/default.jpg">
                <?php else: ?>
                    
                     <img style="width:50px;" src="../../Home/user/usericon/<?php echo $val['icon'];?>">
                <?php endif;?> 
                </td>
                <td><?php echo $val['integral']; ?></td>
                <td><?php echo $level[ $val['level'] ]; ?></td>
                <td><?php echo $sex[ $val['sex'] ]; ?></td>
                <td><?php echo $val['email']; ?></td>
                <td>
                    <?php
                        if($val['age'] <= 0){
                            echo '未设置';
                        }else{
                            
                            echo date('Y-m-d',$val['age']);  
                        }

                    ?>
                </td>
                <td><?php echo $val['tel']; ?></td>
                <td><?php echo $val['real_name']; ?></td>
                <td>
                    <?php
                        if($val['addtime'] <= 0){
                            echo '未设置';
                        }else{
                            echo date('Y-m-d',$val['addtime']);  
                        }

                    ?>
                </td>
        
                <td> 
                    <a href="../login/update.php?id=<?php echo $val['id'] ?>" class="btn btn-info" >修改</a>
                </td>
                <td> 
                    <a href="../login/action.php?a=delete&id=<?php echo $val['id'] ?>" class="btn btn-info">删除</a>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php else: ?>
            <tr>
                <td colspan="12">查无数据！</td>
            </tr>
            <?php endif; ?>
            <tr>
                <td colspan="9">
                    <?php echo "总数：" . $total ?>
                    <?php echo "当前页：{$p} / {$totalPage}" ?>
                    <?php
                        $pre = $p - 1;
                        echo "<a href='./showuser.php?p={$pre}'>上一页</a>";
                        $next = $p + 1;
                        echo "<a href='./showuser.php?p={$next}'>下一页</a>";
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
