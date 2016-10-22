<?php
    
    include'cart_head.php';
   echo '<pre>';
       print_r($_SESSION);
   echo '</pre>';
   // exit;
   $totally=0;
    ?>


    
    <div class="cart-box">
        <div class="cart-title"></div>
    </div>
    <div class="cart-info">
        <?php 
        if(isset($_SESSION['shopcar'])): ?>
        <table class="cart-table table table-hover">
        <thead class="cart-table-head">
        <tr>

        <td>商品名称</td>
        <td>图片</td>
        <td>单价</td>
        <td>数量</td>
        <td>小计</td>
        <td>操作</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($_SESSION['shopcar'] as $key => $val): ?>
        
     
            
        <tr>
        <td><?php echo $val['name'] ?></td>
        <td><img src="../../Common/goodsimage/s_<?php echo $val['picture'] ?>" style="width:50px;"></td>

        <td>￥ <?php echo $val['price']; ?></td>



        <td>

       <a href="../web_action.php?a=jian&id=<?= $val['id'] ?>" > <p class="glyphicon glyphicon-minus"></p></a>

        <input type="text" style="width:25px" name="num" value="<?php echo $val['num']; ?>" readonly>

        <a href="../web_action.php?a=jia&id=<?= $val['id'] ?>" ><p class="glyphicon glyphicon-plus"></p></a>

        </td>



        <td><?php echo $val['num']*$val['price']; ?></td>
        <td><a href="../web_action.php?a=delete&id=<?= $val['id'] ?>">删除</a></td>
        </tr>
        <?php 
        $totally += $val['num']*$val['price'];
        endforeach;?>
       

        </tbody>

        </table>
    </div>
    <div class="total-price">总计：<?php echo $totally ?></div>
    <div class="cart-pay">

        <a href="../web_action.php?a=clearall" class="clear-button btn btn-danger">清空购物车</a>
        <a href="../web_action.php?a=submit" class="pay-button btn btn-danger">提交订单</a>
        <a href="../main_index.php" class="pay-button btn btn-success">继续购物</a>
        <?php else:
        echo "<b>购物车内无商品！</b>";
        header('refresh:3;url=../main_index.php');
        
    
    endif;
    ?>
    </div>

   
    <?php
        include'cart_footer.php'

    ?>
