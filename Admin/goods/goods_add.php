<?php
    
    //导入配置文件
    require '../../Common/config.php';

    //连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

    //设置字符集
    mysqli_set_charset($link , 'utf8');

    //准备SQL语句
    $sql = "select * from `".PIX."category` order by concat(`path`,`id`)";
      
    //发送执行
    $result = mysqli_query($link,$sql);

    //检测错误
    if(mysqli_errno($link)>0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error:{$sql},错误号：{$errno},错误信息:{$error}</b></p>";
        header('refresh:3;url=./goods_index.php');
        exit; 
    }    

    //处理
    $category = [];//创建一个空数组，接收遍历的结果集

    //如果受影响行大于0，则执行遍历
    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_assoc($result)){
            $category[]= $row;
        }
    }
          
    //释放资源
    mysqli_free_result($result);

    //关闭连接
    mysqli_close($link);
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
        <h1>商品添加</h1>

        <form action="./goods_action.php?a=add" method="post" enctype="multipart/form-data" class="form-horizontal">

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">所属分类</label>
                <div class="col-sm-6">
                    <select name="cateid" class="form-control input-lg">
                        <option value="0">请选择</option>
                        <?php
                           

                            // 循环分类
                            foreach($category as $key => $val){
                                // 计算逗号
                                $num = substr_count($val['path'],',');
                                // 根据数量填充占位符
                                $str = str_repeat('|--',$num - 1);
                                // 禁止
                                $disabled = 'disabled';

                                // 判断是否该禁用,只有第三级可以添加商品
                                if($num > 2){
                                    $disabled = '';
                                }

                                echo "<option value='{$val['id']}' {$disabled} >{$str} {$val['name']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">图片上传</label>
                <div class="col-sm-6">
                    <input type="file" name="myfile" class="form-control" id="inputEmail3" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">商品名</label>
                <div class="col-sm-6">
                    <input type="text" name="goodsname" class="form-control" id="inputEmail3" placeholder="商品名">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">价格</label>
                <div class="col-sm-6">
                    <input type="text" name="price" class="form-control" id="inputEmail3" placeholder="价格">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">库存</label>
                <div class="col-sm-6">
                    <input type="text" name="store" class="form-control" id="inputEmail3" placeholder="库存">
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">描述</label>
                <div class="col-sm-6">
                    <textarea style="max-width:630px;" name="description" placeholder="商品描述" class="form-control" rows="3"></textarea>

                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-success">确认添加</button>
                </div>
            </div>
        </form>
    </body>
</html>

