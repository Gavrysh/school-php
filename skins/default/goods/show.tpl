<div class="wrapper-applications">
  <h1>Перегляд товару<?php echo ': '.hs($row['header']); ?>
    <span>Код товару: <?php echo hs($row['code']); ?></span>
    <span><?php if(hs($row['availability']) == '1') { echo 'У наявності'; } else { echo 'Відсутній'; } ?></span>
  </h1>
  <div class="inner-wrap goods-show">
    <div class="goods-show-left-side">
      <img class="goods-show-img" src="<?php if($row['img'] === '') { echo hs($uploaddir.'goodsDefault.png'); } else { echo $uploaddir.'full/'.$row['img']; } ?>" alt="goods-img">
    </div>
    <div class="goods-show-central-side">
      <h2><?php echo hs($row['header']); ?></h2>
      <p><span>Код товару: <?php echo hs($row['code']); ?></span></p>
      <p><span>Категорія: <?php echo hs($row['category']); ?></span></p>
      <p><span>Дата надходження: <?php echo hs($row['date']); ?></span></p>
      <p><span>Наявність: <?php echo hs($row['availability']); ?></span></p>
    </div>
    <div class="goods-show-right-side">
      <p><span>Ціна: <?php echo (float)($row['price']); ?> грн.</span></p>
      <form action="" method="post">
        <input type="submit" name="by" value="Купувати">
      </form>
    </div>
    <div class="clear"></div>
    <div class="goods-show-description">
      <h5>Опис</h5>
      <p><?php echo nl2br(hs($row['description'])); ?></p>
    </div>
    <div class="goods-show-dw">
      <div class="goods-show-dw-left">
        <h5>Умови доставки</h5>
        <p><?php echo nl2br(hs($row['delivery'])); ?></p>
      </div>
      <div class="goods-show-dw-divider"></div>
      <div class="goods-show-dw-right">
        <h5>Гарантійні умови</h5>
        <p><?php echo nl2br(hs($row['warranty'])); ?></p>
      </div>
      <div class="clear"></div>
    </div>
    <div class="goods-show-footer">
      <p><a href="/goods">Повернутися до списку товарів</a></p>
    </div>
  </div>
</div>