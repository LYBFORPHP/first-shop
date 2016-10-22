<?php
  
    require './head_user.php';
    // echo '<pre>';
    //     print_r($_SESSION);
    // echo '</pre>';
    $userid=$_SESSION['home_userinfo']['id'];
   
    //连接
    $link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！错误信息：'.mysqli_connect_error());

    //设置字符集
    mysqli_set_charset($link , 'utf8');

    $sql = "select * from `".PIX."user` where `id`={$userid}";

    $result = mysqli_query($link,$sql);

    //检测错误
    if(mysqli_errno($link)>0){
        $erron = mysqli_errno($link);
        $error = mysqli_error($link);
        echo "<p><b style='font-size:1cm;color:red;'>Error:{$sql},错误号：{$errno},错误信息:{$error}</b></p>";
        header('refresh:3;url=../main_index.php');
        exit; 
    }    

    //处理
    $userinfo = [];//创建一个空数组，接收遍历的结果集

    //如果受影响行大于0，则执行遍历
    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_assoc($result)){
            $userinfo= $row;
        }
    }

    mysqli_free_result($result);
    echo '<pre>';
        print_r($userinfo);
    echo '</pre>';
?>

<div class="cart-box">
        
    </div>
    <div class="cart-info2">
    <form class="form-horizontal" role="form" action="./user_action.php?a=updateinfo" method="post" enctype="multipart/form-data">
    <ol class="breadcrumb" style="width:930px; margin:0 auto;">
            <li style="content:'>';"><b>个人中心</b></li>
            <li ><b>修改个人信息</b></li>     
    </ol>
    
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label ">头像</label>
    <div class="col-sm-6 ">
      <?php if($userinfo['icon']!='defaulticon.jpg'):?>
                <img style="width:50px;" src="./usericon/<?php echo $userinfo['icon'];?>">
                <input type="hidden" name="icon" value="<?php echo $userinfo['icon'];?>">
                <?php else: ?>
                    <img style="width:50px;" src="./defaulticon.jpg?" class="img-circle">
                    <input type="hidden" name="icon" value="<? ='defaulticon.jpg' ?>">
                <?php endif; ?> 
                <?php
                
    
   
                ?>
                    
                    <input type ="file" id="exampleInputFile" name="myfile" value="<?php echo $userinfo['icon'] ?>">
                    <p class    ="help-block">请选择要上传的新头像</p>
              
    </div>
  </div>
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
    <div class="col-sm-2">
      <input type="text" class="form-control" name="user" value="<?php echo $userinfo['user'];?>" disabled >
    </div>
  </div>
  <div class="form-group">
   <label for="inputEmail3"  class="col-sm-2 control-label lg">修改密码</label>
  </div> 
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">原密码</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" name='pass' ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">请输入新密码</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" name='newPass' ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">再次确认新密码</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" name='re_newPass' ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">电话</label>
    <div class="col-sm-4">
      <input type="text" name='tel' class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">真实姓名</label>
    <div class="col-sm-4">
      <input type="text" name='realname' class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">邮箱</label>
    <div class="col-sm-4">
      <input type="text" name='email' class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">性别</label>
    <div class="col-sm-4">
      <select name="sex">
      <option value=2>保密</option>
      <option value=1>男</option>
      <option value=0>女</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">出生日期</label>
    <div class="col-sm-4">
      <input type="date" name='birth' class="form-control">
    </div>
  </div>
  
    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
    <input type="hidden" name="user" value="<?php echo $userinfo['user'];?>" >
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-info" value="确认">
      <a href="./user.php" class="btn btn-danger">返回个人中心</a>
    </div>
  </div>
</form>
</div>













<?php
    require './footer_user.php';
?>
