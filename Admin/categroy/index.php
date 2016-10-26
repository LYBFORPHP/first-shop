<?php
    
//导入表
    require '../../Common/config.php';

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    //分页 每页显示数
    $num =10;
    
    // 3.准备SQL语句
    $sql = "select count(*) total from `".PIX."category` ";

    
    $total = mysqli_query($link,$sql);
   
    $total = mysqli_fetch_assoc($total)['total'];
    
    $totalPage = ceil($total / $num);
    $p = isset($_GET['p'])?$_GET['p']:1;
    // 如果当前页小于1，则重新设置为最小页码
    if($p < 1){
        $p = 1;
    }
    if($p > $totalPage){
        $p = $totalPage;
    }
    

    //偏移量
    

   
    // 4.发送
    $result = mysqli_query($link , $sql);

    $userlist = []; // 接收遍历的结果集

    
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $userlist[] = $row;
        }
    }
      
    $sql = "select * from `".PIX."category` order by concat(`path`,`id`)";

    $result = mysqli_query($link , $sql);
    // 5.检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
        $offset = ($p - 1)*$num;
    if($total>0){
        $sql = "select * from `".PIX."category` order by concat(`path`,`id`) limit {$offset},{$num}";
        
        }
        $result = mysqli_query($link , $sql);
        if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
    // 6.处理
    $category = []; // 接收遍历的结果集

    
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $category[] = $row;
        }
    }
    
    // 7.释放资源   
    mysqli_free_result($result);

    // 8.关闭连接
    mysqli_close($link);
?> 
<!DOCTYPE html>
<html>
    <head>
        <title>document</title>
        <meta charset='utf-8'/>
        <script src="../public/js/jquery-2.1.3.min.js"></script>
        <!-- 先引入JS -->
        <script src="../public/js/bootstrap.min.js"></script>
        <!-- 引入样式表 -->
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    </head>
</head>
    <body>
        <h2>分类浏览</h2>

            <table class="table table-hover">
                <tr>
                    <td>ID</td>
                    <td>父级ID</td>
                    <td>分类名</td>
                    <td>路径</td>
                    <td>操作</td>
                </tr>
                
                <!-- 如果数组大于0，则开始遍历 -->
                <?php if(count($category) > 0): ?>

                <!-- 开始遍历 -->
                <?php foreach($category as $key => $val): ?>

                    <?php 
                        // 1.获取逗号的数量
                        $num = substr_count($val['path'],',');
                        //  2.重复一个字符串
                        $str = str_repeat('|---',$num - 1);
                    ?>
                <tr>
                    <td><?php echo $val['id']; ?></td>
                    <td><?php echo $val['pid']; ?></td>
                    <td><?php echo $str . $val['name']; ?></td>
                    <td><?php echo $val['path'];?></td>
                    
                    <td> 
                        <a href="./add.php?id=<?php echo $val['id'];?>" class="btn btn-info">添加子分类</a>
                        <a href="./action.php?a=del&id=<?php echo $val['id'];?>" class="btn btn-danger">删除</a>
                    </td>
                </tr>
                
                <?php endforeach; ?>
                <tr>
                    <td colspan="5">
                        <?php echo "总数:". $total?>
                        <?php echo "当前页：{$p} / {$totalPage}" ?>
                    <?php
                        $pre = $p - 1;
                        echo "<a href='./index.php?p={$pre}'>上一页</a>";
                        $next = $p + 1;
                        echo "<a href='./index.php?p={$next}'>下一页</a>";
                    ?>
                    </td>        
                </tr>
                <?php else: ?>
                <tr>
                    <td colspan="5">查无数据！</td>
                </tr>
                <?php endif; ?>
            </table>
    </body>
</html>
