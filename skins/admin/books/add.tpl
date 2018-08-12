<div class="wrapper-applications">
  <h1>Додавання книжки</h1>
  <form action="" method="post" enctype="multipart/form-data">
  	<div class="inner-wrap">
      <div class="information">
        <?php if(isset($info)) { echo $info; } ?>
      </div>
      <div>
        <span class="information"><?php if(isset($errors['name'])) { echo $errors['name']; } ?></span>
        <label>
          Назва книжки:
          <input type="text" name="name" value="<?php if(isset($_POST['name'])) { echo hs($_POST['name']); } ?>">
        </label>
      </div>
      <div class="left-side">
        <span class="information"><?php if(isset($errors['authors'])) { echo $errors['authors']; } ?></span>
        <label>Автор(и)</label>
        <div class="authors-books">
          <?php
            if(isset($_POST['gns'])) {
              while($rowAuthors = $authors->fetch_assoc()) {
                if(in_array($rowAuthors['id'], $_POST['gns'])) {
                  echo '<label><input type="checkbox" name="gns[]" value="'.$rowAuthors['id'].'" checked>'.hs($rowAuthors['name']).'</label>';
                } else {
                  echo '<label><input type="checkbox" name="gns[]" value="'.$rowAuthors['id'].'">'.hs($rowAuthors['name']).'</label>';
                }
              }
            } else {
              while($rowAuthors = $authors->fetch_assoc()) {
                echo '<label><input type="checkbox" name="gns[]" value="'.$rowAuthors['id'].'">'.hs($rowAuthors['name']).'</label>';
              }
            }
          ?>
        </div>
        <div>
          <span class="information"><?php if(isset($errors['pages'])) { echo $errors['pages']; } ?></span>
          <label>
            Кількість сторінок:
            <input type="text" name="pages" value="<?php if(isset($_POST['pages'])) { echo (int)($_POST['pages']); } ?>">
          </label>
        </div>
        <div>
          <span class="information"><?php if(isset($errors['publication'])) { echo $errors['publication']; } ?></span>
          <label>
            Дата публікації (рік):
            <input type="text" name="publication" value="<?php if(isset($_POST['publication'])) { echo hs($_POST['publication']); } ?>">
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
          <img class="add-img" src="<?php if(isset($_SESSION['booksAddImg'])) { echo hs($uploaddir.$_SESSION['booksAddImg']); } else { echo hs($uploaddir.'booksDefault.png'); } ?>" alt="books">
        </div>
      </div>
      <div class="clear"></div>
      <div>
        <span class="information"><?php if(isset($errors['annotation'])) { echo $errors['annotation']; } ?></span>
        <label>
          Короткий опис:
          <textarea name="annotation"><?php if(isset($_POST['annotation'])) { echo hs($_POST['annotation']); } ?></textarea>
        </label>
      </div>
    </div>
    <input type="submit" name="add" value="Додати книжку">
  </form>
  <?php
    $authors->close();
    DB::close();
  ?>
</div>