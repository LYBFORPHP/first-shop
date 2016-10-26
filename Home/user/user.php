<?php
    require './head_user.php';

   
?>  
    <ol class="breadcrumb" style="margin-top:">
        <b>您当前的位置：</b>
        <li><a href ="../main_index.php">凡客首页</a></li>
        <li><a href ="active">个人中心</a></li>
    </ol>
    <div class="container user-box">
       <div class="form-group">
            <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">个人资料</div>
        </div>
    </div>

<!-- 导入个人资料 -->

<?php 
    //连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

    //设置字符集
    mysqli_set_charset($link , 'utf8');
    //获取用户ID
    $userid=$_SESSION['home_userinfo']['id'];
    
    $sql = "select * from `".PIX."user` where `id`={$userid}";
   
    
    $result = mysqli_query($link,$sql);

    //检测错误
    if(mysqli_errno($link)>0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error:{$sql},错误号：{$errno},错误信息:{$error}</b></p>";
        header('refresh:3;url=../main_index.php');
        exit; 
    }
    if(mysqli_affected_rows($link)>0){
        $userinfo=mysqli_fetch_assoc($result);
    }
     mysqli_free_result($result);
    ?>
    <div class="userinfo-content">
        <div class="cart-info2">
            <form class="form-horizontal" role="form" action="./user_action.php?a=updateinfo" method="post" enctype="multipart/form-data">
    
    
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label ">头像</label>
                    <div class="col-sm-6 ">


    <?php if($userinfo['icon']!='defaulticon.jpg'):?>
            <img style="width:50px;" class="img-rounded" src="./usericon/<?php echo $userinfo['icon'];?>">
            <input type="hidden" name="icon" value="<?php echo $userinfo['icon'];?>">
    <?php else: ?>
            <img style="width:50px;" src="./defaulticon.jpg?" class="img-circle">
            <input type="hidden" name="icon" value="<? ='defaulticon.jpg' ?>">
    <?php endif; ?> 
    <?php
                
   
            $userSex=['女','男','保密'];
            if($userinfo['age']==0){
                $age = 0;
            }else{
                $age = date('Y-m-d',$userinfo['age']);
            }
            
            ?>
                    
              
                    </div>
                </div>
  
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="user" value="<?php echo $userinfo['user'];?>" disabled >
                    </div>
                    <label for="inputEmail3"  class="col-sm-2 control-label">电话</label>
                    <div class="col-sm-4">
                        <input type="text" name='realname' class="form-control" value="<?php echo $userinfo['tel'];?>" disabled >
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3"  class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-4">
                       <input type="text" name='realname' class="form-control" value="<?php echo $userinfo['real_name'];?>" disabled >
                    </div>
                    <label for="inputEmail3"  class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-4">
                       <input type="text" name='email' class="form-control" value="<?php echo $userinfo['email'];?>" disabled >
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3"  class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-4">
                       <input type="text" name='email' class="form-control" value="<?php echo $userSex[$userinfo['sex']];?>" disabled >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"  class="col-sm-2 control-label">出生日期</label>
                    <div class="col-sm-4">
                       <input type="text" name='email' class="form-control" value="<?php echo $age;?>" disabled >
                    </div>
                </div>
                  
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                       <a href="user_update.php" class="btn btn-info">修改个人信息</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="container orderinfo">
        <div class="form-group">
            <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">我的订单</div>
        </div>
        <div class="cart-info2">
            <table class="cart-table2 table table-hover">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>用户id</td>
                        <td>联系人姓名</td>
                        <td>联系人地址</td>
                        <td>总金额</td>
                        <td>下单时间</td>
                        <td>订单状态</td>
                        <td>订单详情</td>
                    </tr>
                </thead>
                <tbody>
    <?php 
    $totally=0;
    $status=['新订单','已发货','已收货','无效订单'];
     //  SQL语句
    $sql = "select count(*) total from `shop_orders` where `uid`={$userid}";
    //发送执行
    
    $result = mysqli_query($link , $sql);
  
    //判断
    if(mysqli_affected_rows($link)){
        $total = mysqli_fetch_assoc($result);//$total = Array( [total] => 7 )
        
        $total = $total['total'];//$total['total']中'total'为count(*)的别名 [count(*)] => 7/total => 7 
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
    
    //连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

    //设置字符集
    mysqli_set_charset($link , 'utf8');
    //获取用户ID

    //遍历订单，进行分页
    $sql = "select * from `".PIX."orders`  where `uid`={$userid}  order by `id` desc limit {$offset},{$num}";
   
    $result = mysqli_query($link,$sql);
    
    
    // 检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        header('refresh:3;url=./orders.php');
        exit;
    }
    $ordersList=[];
    
    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_assoc($result)){
            $orderList[]=$row;
            
    
    ?>
    <?php foreach($orderList as $key => $val): 
        $time = date('Y-m-d H:i:s',$val['addtime']);
        
    ?>
                    <tr>
                        <td><?php echo $val['id'] ?></td>
                        <td><?php echo $val['uid'] ?></td>
                        <td><?php echo $val['linkman'] ?></td>
                        <td><?php echo $val['address'] ?></td>
                        <td>￥ <?php echo $val['total']; ?></td>
                        <td><?php echo $time ?></td>
                        <td><?php echo $status[$val['status']]; ?>
                        <a class="btn btn-primary" href="user_action.php?a=status&id=<?php echo $val['id'];?>">确认收货</a></td>
                        <td><a href="./user_ordersdetail.php?id=<?=$val['id'];?>">查看</a></td>
                    </tr>
    <?php endforeach; 
         }
    }
    mysqli_free_result($result);
    mysqli_close($link);
    ?>
      
                </tbody>

            </table>
                <ul class="pagination">
   
                <!--               分页                  -->
              

                <li>
                    <a href="./user.php?p=<?= $p - 1;?>" aria-label="Previous"><span aria-hidden="true">上一页</span></a>
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
                            echo "<li class='active'><a  href='./user.php?p={$i}'>{$i}</a></li>";
                        }else{
                            echo "<li><a  href='./user.php?p={$i}'>{$i}</a></li>";
                        }
                    }
                ?>

                <li>
                    <a href="./user.php?p=<?= $p + 1;?>" aria-label="Next">
                    <span aria-hidden="true">下一页</span></a>
                </li>
                   
            </ul>
            <div class="form-group">
                <div class="cart3-total col-sm-offset-10 col-sm-10" >总计：<?php echo $totally ?></div>
                <input type="hidden" name="totally" value="<?= $totally;?>">
                <div><a class="btn btn-success col-sm-offset-10" href="../main_index.php" role="button">返回首页</a></div>
            </div>
        </div>
    </div>

<?php

 require './footer_user.php';
?>
