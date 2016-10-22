<?php
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
        <meta charset="utf-8"/>
        <script src="../public/js/jquery-2.1.3.min.js"></script>
        <!-- 先引入JS -->
        <script src="../public/js/bootstrap.min.js"></script>
        <!-- 引入样式表 -->
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-theme.min.css">

        <style type="text/css">
            .top-bg{
        
                height: 60px;
                background: #606060;
            } 
            .top-left{
                float:left;
            }
            .top-left b{
                color:white;
                font-size:30px;
                line-height:60px;
                margin-left:30px;
            } 
          .panel{
                
                width: 400px;
                margin :100px auto;
               
           }
          
          
           .form-group{
            width:100%;
            margin-top: 30px;
            margin-bottom: 10px;
            margin-left :50px;
         }
          .button{
            margin: 20px auto;
            width:80%;

          }

          div label{
            margin-right:10px;
          }
        </style>
    </head>
    <body>
        <div class="top-bg">
            <div class="top-left">
                <b>G22 商城后台登陆</b>
            </div> 
        </div> 

        <div class="panel panel-primary">
            <div class="panel-heading" style="text-align:center;">后台登录</div>
            <form role="form" class="form-inline" action="./action.php?a=login" method="post">
                <div class="form-group form-group-lg">
                    <label for="exampleInputEmail1">帐号 </label>
                    <input type="text" class="form-control input-lg" name="user" id="exampleInputEmail1" placeholder="请输入帐号" >
                </div>

                <div class="form-group form-group-lg">
                    <label for="exampleInputPassword1">密码 </label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="请输入密码" name="pass">
                </div>
                
                <div class="form-group form-group-lg">
                    <label for="exampleInputPassword1">验证码</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="code" placeholder="请输入验证码"  style="width:60%;">

                    <div style="margin-top:10px;">
                        <img style="cursor:pointer;margin-left:90px;margin-top:20px" src="../../Common/yzm.php" onclick="this.src = '../../Common/yzm.php?id=' + Math.random();" alt="">
                    </div>
                </div>
                    <div class="button">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="登录">
                    </div>
            </form>
        </div>
    </body>
</html>       
