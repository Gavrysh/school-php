<div class="wrapper-applications">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="inner-wrap">
    <div class="information">
      <?php if(isset($info)) { echo $info; } ?>
    </div>
      <div>
        <span class="information"><?php if(isset($errors['header'])) { echo $errors['header']; } ?></span>
        <label>
          Заголовок:
          <input type="text" name="header" value="<?php if(isset($_POST['header'])) { echo hs($_POST['header']); } ?>">
        </label>
      </div>
      <div class="left-side">
        <div>
          <span class="information"><?php if(isset($errors['code'])) { echo $errors['code']; } ?></span>
          <label>
            Код товару:
            <input type="text" name="code" maxlength="6" value="<?php if(isset($_POST['code'])) { echo hs($_POST['code']); } ?>">
          </label>
        </div>
        <div>
          <label>
            Категорія товару:
            <select name="category">
            <?php
                foreach($category as $var) {
                    if(isset($_POST['category']) && $_POST['category'] == $var) {
                        echo '<option selected>'.$_POST['category'].'</option>';
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
            Наявність:
            <select name="availability">
            <?php
                foreach($availability as $var) {
                    if(isset($_POST['availability']) && $_POST['availability'] == $var) {
                        echo '<option selected>'.$_POST['availability'].'</option>';
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
            Ціна:
            <input type="text" name="price" value="<?php if(isset($_POST['price'])) { echo (float)($_POST['price']); } ?>">
          </label>
        </div>
      </div>
      <div class="right-side">
        <div class="right-side-img">
          <span class="information"><?php if(isset($errors['upload'])) { echo $errors['upload'].'<br>'; } ?></span>
          <span class="information"><?php if(isset($errors['resizeImg'])) { echo $errors['resizeImg']; } ?></span>
          <label>
            Зображення:
          </label>
          <div>
            <input type="file" name="file">
            <!-- <input type="submit" name="uploadImage" value="Завантажити файл"> -->
          </div>
          <label>Попередній перегляд</label>
          <img class="goods-add-img" src="<?php if(isset($_SESSION['goodsAddImg'])) { echo hs($uploaddir.$_SESSION['goodsAddImg']); } else { echo hs($uploaddir.'goodsDefault.png'); } ?>" alt="goods">
        </div>
      </div>
      <div class="clear"></div>
      <div>
        <span class="information"><?php if(isset($errors['description'])) { echo $errors['description']; } ?></span>
        <label>
          Опис:
          <textarea name="description"><?php if(isset($_POST['description'])) { echo hs($_POST['description']); } ?></textarea>
        </label>
      </div>
      <div>
        <span class="information"><?php if(isset($errors['delivery'])) { echo $errors['delivery']; } ?></span>
        <label>
          Доставка:
          <textarea name="delivery"><?php if(isset($_POST['delivery'])) { echo hs($_POST['delivery']); } ?></textarea>
        </label>
      </div>
      <div>
        <span class="information"><?php if(isset($errors['warranty'])) { echo $errors['warranty']; } ?></span>
        <label>
          Гарантія:
          <textarea name="warranty"><?php if(isset($_POST['warranty'])) { echo hs($_POST['warranty']); } ?></textarea>
        </label>
      </div>
    </div>
    <input type="submit" name="add" value="Додати товар">
  </form>
</div>  