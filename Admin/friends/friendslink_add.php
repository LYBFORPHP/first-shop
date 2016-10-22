<?php 
 

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
                    <form action="./friendslink_action.php?a=add" method="post" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">网站名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="请填入网站名">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">网站地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address" placeholder="请填入网站地址">
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">确认</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
