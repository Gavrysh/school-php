<div class="wrapper-applications">
  <h1>Редагування товару</h1>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="inner-wrap">
    <div class="information">
      <?php if(isset($info)) { echo $info; } ?>
    </div>
      <div>
        <span class="information"><?php if(isset($errors['header'])) echo $errors['header']; ?></span>
        <label>
          Заголовок
          <input type="text" name="header" value="<?php if(isset($rowGoods['header'])) { echo hs($rowGoods['header']); } ?>">
        </label>
      </div>
      <div class="left-side">
        <div>
          <span class="information"><?php if(isset($errors['code'])) { echo $errors['code']; } ?></span>
          <label>
            Код товару
            <input type="text" name="code" maxlength="6" value="<?php if(isset($rowGoods['code'])) { echo hs($rowGoods['code']); } ?>">
          </label>
        </div>
        <div>
          <label>
            Категорія товару
            <select name="category">
            <?php            
                foreach($category as $var) {
                    if($var == $rowGoods['category']) {
                        echo '<option selected>'.$var.'</option>';
                    } else {
                        echo '<option>'.$var.'</option>';
                    }
                }
            ?>          
            </select>
          </label>
        </div>
        <div>
          <label>
            Наявність
            <select name="availability">
            <?php            
                foreach($availability as $var) {
                    if($var == $rowGoods['availability']) {
                        echo '<option selected>'.$var.'</option>';
                    } else {
                        echo '<option>'.$var.'</option>';
                    }
                }
            ?>
            </select>
          </label>
        </div>
        <div>
          <span class="information"><?php if(isset($errors['price'])) { echo $errors['price']; } ?></span>
          <label>
            Ціна
            <input type="text" name="price" value="<?php if(isset($rowGoods['price'])) { echo (float)($rowGoods['price']); } ?>">
          </label>
        </div>
      </div>
      <div class="right-side">
        <div class="right-side-img">
          <span class="information"><?php if(isset($errors['resizeImg'])) { echo $errors['resizeImg']; } ?></span>
          <span class="information"><?php if(isset($errors['upload'])) { echo $errors['upload']; } ?></span>
          <label>
            Зображення:
          </label>
          <div>
            <input type="file" name="file">
          </div>
          <label>Попередній перегляд</label>
          <img class="goods-edit-image" src="<?php if(isset($_SESSION['goodsEditImg']) && $_SESSION['goodsEditImg'] !='') { echo hs($uploaddir.$_SESSION['goodsEditImg']); } else { echo hs($uploaddir.'mini/'.$rowGoods['img']); } ?>" alt="goods">
        </div>
      </div>
      <div class="clear"></div>
      <div>
        <span class="information"><?php if(isset($errors['description'])) { echo $errors['description']; } ?></span>
        <label>
          Опис
          <textarea name="description"><?php if(isset($rowGoods['description'])) { echo hs($rowGoods['description']); } ?></textarea>
        </label>
      </div>
      <div>
        <span class="information"><?php if(isset($errors['delivery'])) { echo $errors['delivery']; } ?></span>
        <label>
          Доставка
          <textarea name="delivery"><?php if(isset($rowGoods['delivery'])) { echo hs($rowGoods['delivery']); } ?></textarea>
        </label>
      </div>
      <div>
        <span class="information"><?php if(isset($errors['warranty'])) { echo $errors['warranty']; } ?></span>
        <label>
          Гарантія
          <textarea name="warranty"><?php if(isset($rowGoods['warranty'])) { echo hs($rowGoods['warranty']); } ?></textarea>
        </label>
      </div>
    </div>
    <input type="submit" name="edit" value="Зберегти зміни">
  </form>
</div>  