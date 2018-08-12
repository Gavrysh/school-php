<div class="wrapper-applications goods">
  <h1>Каталог товарів<span>Загальна кількість на сторінці <?php echo mysqli_num_rows($goods); ?> шт.</span></h1>
  <?php while($row = mysqli_fetch_assoc($goods)) { ?>
    <div class="inner-wrap goods">
      <div class="image-goods">
        <img src="<?php if($row['img'] === '') { echo hs($uploaddir.'goodsDefault.png'); } else { echo $uploaddir.'mini/'.$row['img']; } ?>" alt="goods-img" class="goods-img">
      </div>
      <div class="goods-header">
          <a href="/goods/show/<?php echo $row['id'] ?>"><?php echo hs($row['header']); ?></a>
        <p>
          <?php echo nl2br(hs(mb_substr($row['description'], 0, 500))).'...'; ?><br>
          <a href="/goods/show/<?php echo $row['id'] ?>">Детальніше &raquo;</a>
        </p>
      </div>
      <div class="clear"></div>
    </div>
  <?php } ?>
</div>