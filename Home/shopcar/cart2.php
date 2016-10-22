<?php
    
    include'cart_head.php';
  
  
?>
     <div class="cart-box">
        <div class="cart-title2"></div>
    </div>
    <div class="cart-info2">
        <form class="form-horizontal" role="form" action="../web_action.php?a=pay" method="post">
            <div style="width:980px;height:50px;font-size:20px;font-weight:bold; ">确认订单信息</div>
            <div class="form-group">
                <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">收货信息</div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">收货人姓名</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="请填写收货人姓名" name="linkman">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">手机号码</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="请填写手机号码" name="phone">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">收货地址</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputPassword3" placeholder="请填写收货地址" name="address">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">付款方式</div>
            
            </div>

            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" name="payWay" id="inlineRadio1" value="1">货到付款
                </label>
                <label class="radio-inline">
                  <input type="radio" name="payWay" id="inlineRadio2" value="2"> 在线支付
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-12 control-label" style="font-size:16px;font-weight:bold;background:#ccc;text-align:left;">订单信息</div>
            </div>
            <div class="cart-info2">
                <table class="cart-table2 table table-hover">
                    <thead>
                        <tr>
                            <td>商品名称</td>
                            <td>图片</td>
                            <td>单价</td>
                            <td>数量</td>
                            <td>小计</td>
                        </tr>
                    </thead>
                    <tbody>
     <?php 
        $totally=0;
        foreach($_SESSION['shopcar'] as $key => $val): ?>
        
                        <tr>
                            <td><?php echo $val['name'] ?></td>
                            <td><img src="../../Common/goodsimage/s_<?php echo $val['picture'] ?>" style="width:50px;"></td>
                            <td>￥ <?php echo $val['price']; ?></td>
                            <td>
                            <input type="text" style="width:25px; border:none;" name="num" value="<?php echo $val['num']; ?>" readonly>
                            </td>
                            <td><?php echo $val['num']*$val['price']; ?></td>                   
                        </tr>
    <?php 
        $totally += $val['num']*$val['price'];
        endforeach;?>

                    </tbody>

                </table>
            <div class="form-group">
                <div class=" col-sm-offset-10 col-sm-10" style="font-size:20px;font-weight:bold;color:#a10000;">总计：<?php echo $totally ?></div>
                <input type="hidden" name="totally" value="<?= $totally;?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-10 col-sm-12">
                <button type="submit" class="btn btn-danger">立即付款</button>
            </div>
        </div>
    </form>
</div>






 <?php
        include'cart_footer.php'

    ?>
