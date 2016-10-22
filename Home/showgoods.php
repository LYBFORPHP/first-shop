<?php
    include './head_index.php';

        //接收分类ID
    $cid = $_GET['cid'] + 0 ;

    $sql = "select * from `shop_goods` where `cateid` = {$cid}";
    
    // 执行
    $result = mysqli_query($link , $sql);

    $goodslist = [];
    // 判断
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $goodslist[] = $row;
        }
        
        // 释放资源
        mysqli_free_result($result);
    }

    $sql = "select * from `shop_category` where `id` = {$cid}";
    $result = mysqli_query($link , $sql);
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./main_index.php?errno='.'$errno');
        exit;
    }
    $categoryList = [];
    // 判断
    if(mysqli_affected_rows($link) > 0){
        $categoryList = mysqli_fetch_assoc($result);
           
        }
       
        $catePath= [] ;
        $catePath=explode(',',$categoryList['path']);


    $sql = "select * from `shop_category` where `id` = {$catePath[2]}";
    $result = mysqli_query($link , $sql);
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./main_index.php?errno={$errno}');
        exit;
    }
     
    if(mysqli_affected_rows($link) > 0){
        $secondId = mysqli_fetch_assoc($result);  
    }
    $sql = "select * from `shop_category` where `id` = {$catePath[1]}";
    $result = mysqli_query($link , $sql);
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
     
    if(mysqli_affected_rows($link) > 0){
        $thirdId = mysqli_fetch_assoc($result);       
    }
       
?>


        <ol class="breadcrumb" style="width:1200px; margin:0 auto;">
            <li class="bread"><b><?= $thirdId['name'] ?></b></li>
            <li class="bread"><b><?= $secondId['name'] ?></b></li>
            <li class="bread"><b><?=$categoryList['name'];?></b></li>     
           
        </ol>
  
       
        <!--遍历商品开始-->
        <div class="main-ad">   
        <!--                           商品展示                                                  -->
    
                <div class="hot-shopping-list">
               

                    <ul class="hot-shopping-list-ul">
                    <?php foreach($goodslist as $key => $val): ?>
                        <li><a href="detail.php?gid=<?= $val['id'];?>"><img height="214" width="232"  src="../Common/goodsimage/m_<?=$val['picture'];?>"></a>
                        <h3 style="font-size:12px;"><span style="font-size:16px;font-weight:bold;"><?=$val['price'];?></span><?=$val['name'];?></h3>
                         </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                
                
               
            </div>
       

<?php include './footer_index.php'?>
