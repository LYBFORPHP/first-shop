<?php
    
    session_start();
    $list=$_SESSION;
   
    //导入配置文件
    require '../../Common/config.php';
    $id=$_GET['id'];
    
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
   
 $sql = "select * from `".PIX."goods` where `id`={$id}";
       
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
    $goodslist = [];//创建一个空数组，接收遍历的结果集

    //如果受影响行大于0，则执行遍历
    if(mysqli_affected_rows($link)>0){
       $goodslist = mysqli_fetch_assoc($result);
           
        
    }
    


   
      
    //释放资源
    mysqli_free_result($result);

    //关闭连接
    mysqli_close($link);
?> 
<!DOCTYPE html>
<html>
    <head>
        <title>update</title>
        <meta charset="utf-8"/>
        <script src="../public/js/jquery-2.1.3.min.js"></script>
            <!-- 先引入JS -->
            <script src="../public/js/bootstrap.min.js"></script>
            <!-- 引入样式表 -->
            <link rel="stylesheet" href="../public/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-theme.min.css">
            <style type="text/css">
                .update-box{
                    width:500px;
                    margin:50px auto;
            }
        </style>
    </head>
    <body>
        <div class="update-box">
            <form class="form-horizontal" role="form" action="./goods_action.php?a=update" enctype="multipart/form-data" method="post" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">所属分类</label>
                    <div class="col-sm-10">
                    <select name="cateid" class="form-control ">
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
                                $selected = '';
                               
                                // 判断是否该禁用,只有第三级可以添加商品
                                if($num > 2){
                                  
                                    $disabled = '';
                                  
                                    if($val['id'] == $goodslist['cateid']){
                                       
                                        $selected='selected';
                                    }
                                }

                              echo "<option value='{$val['id']}' {$disabled} {$selected} >{$str} {$val['name']}</option>";
                            }
                            
                        ?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label ">图片</label>
                    <div class="col-sm-6 ">

                    <?php if($goodslist['picture']!='default.jpg'):?>

                        <img style="width:50px;" src="../../Common/goodsimage/s_<?php echo $goodslist['picture'];?>">
                        <input type="hidden" name="picture" value="<?php echo $goodslist['picture'] ?>">
                        <?php else: ?>
                            <img style="width:50px;" src="../../Common/goodsimage/default.jpg?" class="img-circle">
                            <input type="hidden" name="picture" value="<? ='default.jpg' ?>">
                        <?php endif; ?> 
                       
                            
                        <input type ="file" id="exampleInputFile" name="myfile" value="<?php echo $goodslist['picture'] ?>">
                        <p class    ="help-block">请选择要上传的新图片</p>
                      
                    </div>
                </div>
      
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">商品名</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='goodsname' value="<?php echo $goodslist['name'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"  class="col-sm-2 control-label">价格</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='price' value="<?php echo $goodslist['price'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"  class="col-sm-2 control-label">库存</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='store' value="<?php echo $goodslist['store'];?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"  class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <input type="text" name='description' class="form-control" value="<?php echo $goodslist['description'];?>" >
                    </div>
                </div>
                    <input type="hidden" name="goodsid" value ="<?php echo $_GET['id']; ?>" > 
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-default" value="提交">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
