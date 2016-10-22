<?php
// 分类添加
    

    // 判断用户是否传递ID
    if(isset($_GET['id'])){
        // 接收ID
        $id = $_GET['id'];
        // 导入配置文件
        require '../../Common/config.php';
        // 1.连接
        $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
        // 2.设置字符集
        mysqli_set_charset($link,'utf8');

        // 3.准备SQL
        $sql = "select * from `".PIX."category` where `id` = {$id}";
        echo $sql;
        // 4.发送
        $result = mysqli_query($link , $sql);

        if(mysqli_affected_rows($link) > 0){
            $parentCate = mysqli_fetch_assoc($result);
        }

        // 5.释放资源
        mysqli_free_result($result);
        // 6.关闭
        mysqli_close($link);

        echo '<pre>';
            print_r($parentCate);
        echo '</pre>';
        // 父类ID
        $pid = $parentCate['id'];
        // 路径
        $path = $parentCate['path'] . $pid . ',';


    }else{
        
        // 父类ID
        $pid = 0;
        // 路径
        $path = '0,';
    }


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
        <h2>添加<?php echo isset($parentCate['name']) ? $parentCate['name'].' 子分类' : '顶级';?></h2>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="./action.php?a=add" method="post">
                        <!-- 通过隐藏域将父级ID和路径提交 -->
                        <input type="hidden" name="pid" value="<?php echo $pid;?>">
                        <input type="hidden" name="path" value="<?php echo $path;?>">


                        <div class="form-group">
                            <label for="exampleInputEmail1">分类名：</label>
                            <input type="text" name="catename" class="form-control" id="exampleInputEmail1" placeholder="category">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>

                </div>
               
            </div>
        </div>
    </body>
</html>
