

<?php
    include './head_index.php';
  
   
?>


 <div class="clear"></div>

    <div class="main-ad">   
        <!--                           商品展示                                                  -->
        <div class="hot-shopping"><h2 style="font-size:20px;font:bold;">热销商品</h2>
            <div class="clear"></div>
            <div class="hot-shopping-list">
            <?php


                $sql =  "select * from `shop_goods` where `status`=1 order by `sale` desc limit 10";

                $result = mysqli_query($link , $sql);
                        // 准备空数组
                        $hotSale = [];
                        if(mysqli_affected_rows($link) > 0){
                            // 遍历数组
                            while($row = mysqli_fetch_assoc($result)){
                                
                                $hotSale[] = $row;
                            }
                             
                          
                        }
        
       
                        mysqli_free_result($result);


        
            ?>
                
                <ul class="hot-shopping-list-ul">
                <?php foreach($hotSale as $key => $val): ?>
                        <li><a href="./detail.php?gid=<?= $val['id'];?>"><img height="214" width="232"  src="../Common/goodsimage/m_<?=$val['picture'];?>"></a>
                        <h3><span><em><?=$val['price'];?></em></span><?=$val['name'];?></h3>
                         </li>
                <?php endforeach; ?>
                </ul>
           
            </div>
        
        </div>

        <div class="hot-shopping"><h2 style="font-size:20px;font:bold;">人气商品</h2>
            <div class="clear"></div>
            <div class="hot-shopping-list">
            <?php


                $sql =  "select * from `shop_goods` where `status`=1 order by `views` desc limit 10";

                $result = mysqli_query($link , $sql);
                        // 准备空数组
                        $hotSale = [];
                        if(mysqli_affected_rows($link) > 0){
                            // 遍历数组
                            while($row = mysqli_fetch_assoc($result)){
                                
                                $hotSale[] = $row;
                            }
                             
                          
                        }
        
       
                        mysqli_free_result($result);


        
            ?>
                
                <ul class="hot-shopping-list-ul">
                <?php foreach($hotSale as $key => $val): ?>
                        <li><a href="./detail.php?gid=<?= $val['id'];?>"><img height="214" width="232"  src="../Common/goodsimage/m_<?=$val['picture'];?>"></a>
                        <h3><span><em><?=$val['price'];?></em></span><?=$val['name'];?></h3>
                         </li>
                <?php endforeach; ?>
                </ul>
           
            </div>
        
        </div>
    </div>

<?php
    include './footer_index.php';
?>








