<?php 
           
    // 导入配置文件
    require '../../Common/config.php';

    // 连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

    // 设置字符集
    mysqli_set_charset($link , 'utf8');

    $sql="select count(*) goodsNum from `shop_goods`";
     $result = mysqli_query($link , $sql);

    // 检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./goods_index.php');
        exit;
    }
    if(mysqli_affected_rows($link)){
        $goodsNum = mysqli_fetch_assoc($result);//$goodsNum = Array( [total] => 商品个数 )
        
        $goodsNum = $goodsNum['goodsNum'];//$goodsNum['goodsNum']中'goodsNum'为count(*)的别名 [goodsNum(*)] => 个数/goodsNum => 个数
    }
    if($goodsNum <= 0){
        echo 'goodNum';
        echo '商品为空，请添加商品！';
        header('refresh:3;url=./goods_add.php');
        exit;
    }

    //高级分页
    
   
    $where = '';
    // 不存在取空，存在取自己
    $search = isset($_GET['search']) ? $_GET['search'] : '';
   
    //***********起始范围*******************//
    $contentStart = isset($_GET['contentStart'])?$_GET['contentStart'] + 0 : 0;
   

    //****************结束位置************
    $contentEnd = isset($_GET['contentEnd'])?$_GET['contentEnd'] + 0 :0;//+0触发强制类型转换，转换为int型

   

    //不存在时取空，存在时取自己
    $content = isset($_GET['content'])?$_GET['content'] : '';


    switch($search){
        case 'name':
        $where = " where `name` like '%{$content}%'";//前出一个空格，防止拼接时出现错误
        break;
        case 'id':
            if($content==''){
                $where = '';
            }else{  
                $content +=0; // 触发强制类型转换
                $where = "where `id` = {$content}";
            }
            
        break;
        case 'price':
        
            echo '你要搜索:'.$search;
            if($contentStart==''&&$contentEnd!=''){
                $where = "where `price` < {$contentEnd}";
            }elseif($contentStart!=''&&$contentEnd==''){
                $where = "where `price` > {$contentStart}";
            }else{
                $where = " where `price` between {$contentStart} and {$contentEnd} ";
            }
            
        break;
        case 'sale':
             echo '你要搜索:'.$search;
            if($contentStart==''&&$contentEnd!=''){
                $where = "where `sale` < {$contentEnd}";
            }elseif($contentStart!=''&&$contentEnd==''){
                $where = "where `sale` > {$contentStart}";
            }else{
                $where = " where `sale` between {$contentStart} and {$contentEnd} ";
            }
        break;
        case 'store':
             echo '你要搜索:'.$search;
            if($contentStart==''&&$contentEnd!=''){
                $where = "where `store` < {$contentEnd}";
            }elseif($contentStart!=''&&$contentEnd==''){
                $where = "where `store` > {$contentStart}";
            }else{
                $where = " where `store` between {$contentStart} and {$contentEnd} ";
            }
        break;
        case 'views':
             echo '你要搜索:'.$search;
            if($contentStart==''&&$contentEnd!=''){
                $where = "where `views` < {$contentEnd}";
            }elseif($contentStart!=''&&$contentEnd==''){
                $where = "where `views` > {$contentStart}";
            }else{
                $where = " where `views` between {$contentStart} and {$contentEnd} ";
            }
        break;

    }
    //未输入要搜索的内容时$where='',则默认为搜索所有
    

  
    //  SQL语句
    $sql = "select count(*) total from `shop_goods` {$where}";
    //发送执行
    $result = mysqli_query($link , $sql);
    
    $total = 0;
    //判断
    if(mysqli_affected_rows($link)){
        $total = mysqli_fetch_assoc($result);//$total = Array( [total] => 总数 )
        //取出数组中第一个值，即将总数取出
        $total = $total['total'];//$total['total']中'total'为count(*)的别名写作: [count(*)] => 总页数/total => 总数 
    }

    //每页显示行数
    $num = 2;
   
    
    //总页数至少为一页
    $totalPage = max(1,ceil($total / $num));
   
    //当前页数
    $p = isset($_GET['p']) ? $_GET['p'] + 0 : 1 ;
    // 如果当前页小于1，则重新设置为最小页码 保证最小页数为第一页
         
    $p = max($p,1);
  
    // 如果当前页大于总页码，则重新设置$p为最大页码
   
    $p = min($p,$totalPage);

    //求偏移量
    $offset = ($p - 1) * $num;

       
       
    $sql = "select * from `".PIX."goods` {$where} order by `id` desc limit {$offset},{$num}";

        
    // 发送
    $result = mysqli_query($link , $sql);

    // 检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
    // 处理
    
    $goodslist = [];
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
           
            $goodslist[] = $row;
        }

        mysqli_free_result($result);
        }
    



   

    $status = ['新发布', '上架' , '下架'];
   
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
        <!--             第一行                    -->
        <div class="row">
                <form action="./goods_index.php" class="form-inline">
                <?php 
                    $search = isset($_GET['search']) ? $_GET['search'] : '' ;
                ?>
                    <select name="search" style="width:200px" class="form-control">
                        <option value="">请选择</option>
                        <option <?php echo $search == 'price' ? 'selected' : '' ?> value="price">价格</option>
                        <option <?php echo $search == 'sale' ? 'selected' : '' ?> value="sale">销量</option>
                        <option <?php echo $search == 'store' ? 'selected' : '' ?> value="store">库存</option>
                        <option <?php echo $search == 'views' ? 'selected' : '' ?> value="views">浏览量</option>
                    </select>

                    <div class="form-group">
                        <label for="exampleInputName2"> </label>
                        <input name="contentStart" type="text" class="form-control" value="<?php  echo $contentStart = isset($_GET['contentStart']) ? $_GET['contentStart'] : '' ;?>" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName2"> </label>
                        <input name="contentEnd" type="text" class="form-control" id="exampleInputName2" value="<?php  echo $contentEnd = isset($_GET['contentEnd']) ? $_GET['contentEnd'] : '' ;?>">
                    </div>
                    <button type="submit" class="btn btn-default" style="font-weight:bold;background:lightblue;">搜索</button>
                </form>
            </div>

            <!--                               -->

            <!--             搜索第二行
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
            <!-- -======================= -->

        <table class='table table-hover'>
            <tr>
                <td>ID</td>
                <td>所属分类</td>
                <td>图片</td>
                <td>商品名</td>
                <td>价格</td>
                <td>销量</td>
                <td>浏览量</td>
                <td>库存</td>
                <td>描述</td>
                <td>状态</td>
                <td>添加时间</td>
                <td>操作</td>
            </tr>

            <?php foreach($goodslist as $key => $val): ?>

            <tr>
                <td><?php echo $val['id']; ?></td>
                <?php 
                
    

    // 连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：' . mysqli_connect_error());

    // 设置字符集
    mysqli_set_charset($link , 'utf8');
            $sql = "select * from `".PIX."category` where `id`={$val['cateid']}";

       
         // 发送
    $result = mysqli_query($link , $sql);

    // 检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
         // 处理
    
   
    $goodsCate=[];
  
    if(mysqli_affected_rows($link) > 0){
        $goodsCate[] = mysqli_fetch_assoc($result);
       
           
        mysqli_free_result($result);
       
        }
        $goodsPath= $goodsCate[0]['path'];
        $cateId=[];
        $cateId =explode(',',$goodsPath);
       
        
        $sql="select `name` from `".PIX."category` where `id`={$cateId[1]}";
        $result = mysqli_query($link,$sql);
        if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
        if(mysqli_affected_rows($link)){
            $firstId[]=mysqli_fetch_assoc($result);
        }
        

        mysqli_close($link);
?>
                <td><?php echo $firstId[0]['name'] ; ?></td>
                <td>
                <?php if($val['picture']=='default.jpg'):?>
               <img style="width:50px;" src="../../Common/goodsimage/default.jpg">
                <?php else: ?>
                    
                     <img style="width:50px;" src="../../Common/goodsimage/s_<?php echo $val['picture'];?>">
                <?php endif;?> 
                </td>
                <td><?php echo $val['name']; ?></td>
                <td><?php echo $val['price']; ?></td>
                <td><?php echo $val['sale']; ?></td>
                <td><?php echo $val['views']; ?></td>
                <td><?php echo $val['store']; ?></td>
                <td><?php echo $val['description']; ?></td>
                <td><?php echo $val['status']; ?></td>
                <td><?php echo date('Y-m-d',$val['addtime']); ?></td>
                <td>

                <script type="text/javascript" language="javascript">

                    function confirmAct()
                    {
                        if(confirm('确定要删除该商品?'))
                        {
                        return true;
                        }
                        return false;
                    }
                
                </script>
                <a href="./goods_action.php?a=up&id=<?php echo $val['id'];?>" class="btn btn-success">上架</a>
                <a href="./goods_action.php?a=down&id=<?php echo $val['id'];?>" class="btn btn-warning">下架</a>
                <a href="./goods_update.php?id=<?php echo $val['id'];?>" class="btn btn-warning">修改</a>
                <a href="./goods_action.php?a=del&id=<?php echo $val['id'];?>" class="btn btn-danger" onclick="return confirmAct();">删除</a>
               
               
               </td>
            </tr>  

            <?php 
                endforeach; 
            ?>   

            <?php 
                if(empty($goodslist)){
                    echo "<b>未找到符合条件的商品！！</b>";
            } 

            ?>
        </table>

        <nav>
            <ul class="pagination">
                <!-- 
                    要把搜索的内容带到下一页
                -->
              

                <li>
                    <a href="./goods_index.php?search=<?= $search;?>&content=<?= $content;?>&p=<?= $p - 1;?>&contentStart=<?=$contentStart;?>&contentEnd=<?=$contentEnd?>" target="main" aria-label="Previous"><span aria-hidden="true">上一页</span></a>
                </li>
                
                <?php
                    // 起始页码
                    $start = $p - 5;
                    $start = max($start , 1);
                    // 结束页码
                    $end = $p + 5;
                    $end = min($end , $totalPage);

                    // 循环输出页码
                    for($i = $start; $i <= $end; $i++){
                        if($p == $i){
                            echo "<li class='active'><a  href='./goods_index.php?search={$search}&content={$content}&p={$i}&contentStart={$contentStart}&contentEnd={$contentEnd}'>{$i}</a></li>";
                        }else{
                            echo "<li><a href='./goods_index.php?search={$search}&content={$content}&p={$i}&contentStart={$contentStart}&contentEnd={$contentEnd}'>{$i}</a></li>";
                        }
                    }
                ?>

                <li>
                    <a href="./goods_index.php?search=<?= $search;?>&content=<?= $content;?>&p=<?= $p + 1;?>&contentStart=<?=$contentStart;?>&contentEnd=<?=$contentEnd;?>" target="main" aria-label="Next">
                    <span aria-hidden="true">下一页</span></a>
                </li>
                   
            </ul>
        </nav>
    </body>
</html>
