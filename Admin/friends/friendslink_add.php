<?php 
    // 分类添加
    

   
      
        // // 导入配置文件
        // require '../../Common/config.php';
        // // 1.连接
        // $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());
        // // 2.设置字符集
        // mysqli_set_charset($link,'utf8');

        // // 3.准备SQL
        // $sql = "insert into `".PIX."friendslink` values(null,`name`,`address`,`addtime`)";
        // echo $sql;
        // // 4.发送
        // $result = mysqli_query($link , $sql);

        // if(mysqli_affected_rows($link) > 0){
        //     $parentCate = mysqli_fetch_assoc($result);
        // }

        // // 5.释放资源
        // mysqli_free_result($result);
        // // 6.关闭
        // mysqli_close($link);

        // echo '<pre>';
        //     print_r($parentCate);
        // echo '</pre>';
       


   


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
        <h2>添加友情链接</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="./friends_action.php?a=add" method="post" class="form-horizontal" role="form">
                       <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">网站名</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">网站地址</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
 
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">确认</button>
    </div>
  </div>
                    </form>

                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

    </body>
</html>
