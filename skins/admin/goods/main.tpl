<div class="wrapper-applications goods">
  <h1>Каталог товарів<span>Загальна кількість на сторінці <?php echo mysqli_num_rows($goods); ?> шт.</span></h1>
  <div class="information">
    <?php if(isset($info)) { echo '<p>'.$info.'</p><hr>'; } ?>
  </div>
  <a href="/admin/goods/add"><input class="goods-main-btn-add" type="submit" name="add" value="Додати товар"></a>
  <form action="" method="post">  
  <input type="submit" name="delete" value="Видалити відмічений товар"><hr>
  <?php while($row = mysqli_fetch_assoc($goods)) { ?>
    <div class="inner-wrap goods">
      <div class="image-goods">
        <img src="<?php if($row['img'] === '') { echo hs($uploaddir.'goodsDefault.png'); } else { echo $uploaddir.'mini/'.$row['img']; } ?>" alt="goods-img" class="goods-img">
      </div>
      <div class="goods-header">
        <input type="checkbox" name="gns[]" value="<?php echo $row['id'] ?>">
        <a href="/admin/goods/edit/<?php echo $row['id'] ?>"><?php echo hs($row['header']); ?></a>
        <p>
          <?php echo nl2br(hs(mb_substr($row['description'], 0, 500))).'...'; ?><br>
          <a href="/admin/goods/show/<?php echo $row['id'] ?>">Детальніше &raquo;</a>
        </p>
      </div>
      <div class="clear"></div>
    </div>
  <?php } ?>
  </form>
</div>