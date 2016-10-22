<?php
    session_start();
    $list=$_SESSION;
     echo '<pre>';
        print_r($list);
    echo '</pre>';
    
    $age=$list['user']['age'];
   
   
   $age = floor((time()-$age)/3600/24/365);
   
   require '../../Common/config.php';

    // 1.连接数据库
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误消息：' . mysqli_connect_error());;

    // 2.设置字符集
    mysqli_set_charset($link , 'utf8');

    $sql = "select *  from `shop_user` where id={$_GET['id']}" ;
    $result = mysqli_query($link , $sql);

    // 5.检测错误
    if(mysqli_errno($link) > 0){
        $errno = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error ：{$sql} , 错误号：{$errno} , 错误信息：{$error}</b></p>";
        exit;
    }
    $userlist = []; // 接收遍历的结果集

    echo '受影响行：' . mysqli_affected_rows($link);
    if(mysqli_affected_rows($link) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $userlist = $row;
        }
    }
     echo '<pre>';
        print_r($userlist);
    echo '</pre>';
    mysqli_free_result($result);

    // 8.关闭连接
    mysqli_close($link);

    if($list['user']['level']>=$userlist['level']){
      echo '无权修改';
      header('refresh:3;url=../user/showuser.php');
      exit;
    }
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
            <form class="form-horizontal" role="form" action="./action.php?a=update" method="post" >
  <div class="form-group" >
    <label for="inputEmail3" class="col-sm-2 control-label">帐号</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $userlist['user'];?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">积分</label>
    <div class="col-sm-10">
      <input type="text" name="integral" class="form-control" value="<?php echo $userlist['integral'];?>">
    </div>
  </div>
  <div class="form-group">
   <label for="inputEmail3" class="col-sm-2 control-label">等级</label>
   <div class="col-sm-10">
  <select class="form-control" name="level">
  <!-- 管理者权限为超级管理员时才可修改管理员权限 -->
  <?php if($list['user']['level']==0):?>
    <option >管理员</option>
<?php else: ?>
    <option disabled>管理员</option>
<?php endif;?>
    <option>铜牌会员</option>
    <option>银牌会员</option>
    <option>金牌会员</option>
    <option>钻石会员</option>
  </select>
  </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">性别</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $userlist['sex'];?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $userlist['email'];?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">年龄</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $age;?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">电话</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $userlist['tel'];?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $userlist['real_name'];?>" disabled>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">添加时间</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="<?php echo $userlist['addtime'];?>" disabled>
    </div>
  </div>
  <input type="hidden" name="userid" value ="<?php echo $_GET['id']; ?>" >
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-default" value="提交">
    </div>
  </div>
</form>
        </div>
    </body>
</html>

