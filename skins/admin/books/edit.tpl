<div class="wrapper-applications">
  <h1>Редагування книжки<?php echo ': '.hs($rowBooks['name']); ?></h1>
  <form action="" method="post" enctype="multipart/form-data">
  	<div class="inner-wrap">
      <div class="information">
        <?php if(isset($info)) { echo $info; } ?>
      </div>
      <div>
        <span class="information"><?php if(isset($errors['resizeImg'])) echo $errors['resizeImg']; ?></span>
        <span class="information"><?php if(isset($errors['upload'])) echo $errors['upload']; ?></span>
        <label>
          Назва книжки:
          <input type="text" name="name" value="<?php if(isset($rowBooks['name'])) { echo hs($rowBooks['name']); } ?>">
        </label>
      </div>
      <div class="left-side">
        <span class="information"><?php if(isset($errors['authors'])) echo $errors['authors']; ?></span>
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
              $rowAuthorsChecked  = $authorsChecked->fetch_assoc();
              while($rowAuthors = $authors->fetch_assoc()) {
                if($rowAuthorsChecked['id_author'] == $rowAuthors['id']) {
                  echo '<label><input type="checkbox" checked name="gns[]" value="'.$rowAuthors['id'].'">';
                  echo hs($rowAuthors['name']).'</label>';
                  $rowAuthorsChecked  = $authorsChecked->fetch_assoc();
                } else {
                  echo '<label><input type="checkbox" name="gns[]" value="'.$rowAuthors['id'].'">';
                  echo hs($rowAuthors['name']).'</label>';
                }
              }
            }
          ?>
        </div>
        <div>
          <span class="information"><?php if(isset($errors['pages'])) echo $errors['pages']; ?></span>
          <label>
            Кількість сторінок:
            <input type="text" name="pages" value="<?php if(isset($rowBooks['pages'])) { echo (int)($rowBooks['pages']); } ?>">
          </label>
        </div>
        <div>
          <span class="information"><?php if(isset($errors['publication'])) echo $errors['publication']; ?></span>
          <label>
            Дата публікації (рік):
            <input type="text" name="publication" value="<?php if(isset($rowBooks['publication'])) { echo hs($rowBooks['publication']); } ?>">
          </label>
        </div>
        <div>
          <span class="information"><?php if(isset($errors['price'])) echo $errors['price']; ?></span>
          <label>
            Ціна:
            <input type="text" name="price" value="<?php if(isset($rowBooks['price'])) { echo (float)($rowBooks['price']); } ?>">
          </label>
        </div>
      </div>
      <div class="right-side">
        <div class="right-side-img">
          <span class="information"><?php if(isset($errors['img'])) echo $errors['img']; ?></span>
          <label>
            Зображення:
          </label>
          <div>
            <input type="file" name="file">
          </div>
          <label>Попередній перегляд</label>
          <img class="goods-edit-image" src="<?php 
            if(isset($_SESSION['booksAddImg']) && $_SESSION['booksAddImg'] !='') { 
              echo hs($uploaddir.$_SESSION['booksAddImg']); 
            } elseif($rowBooks['img'] == 'booksDefault.png') {
              echo hs($uploaddir.'booksDefault.png');
            } else { 
              echo hs($uploaddir.'full/'.$rowBooks['img']);
            } ?>" alt="books">
        </div>
      </div>
      <div class="clear"></div>
      <div>
        <span class="information"><?php if(isset($errors['annotation'])) echo $errors['annotation']; ?></span>
        <label>
          Короткий опис:
          <textarea name="annotation"><?php if(isset($rowBooks['annotation'])) { echo hs($rowBooks['annotation']); } ?></textarea>
        </label>
      </div>
    </div>
    <input type="submit" name="edit" value="Внести зміни">
  </form>
  <?php
    $authors->close();
    $authorsChecked->close();
    DB::close();
  ?>
</div>