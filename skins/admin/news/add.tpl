<div class="wrapper-applications">
  <h1>Додавання новини</h1>
    <form action="" method="post">
      <div class="inner-wrap">
        <div>
          <label>
            Заголовок новини:
            <input type="text" name="title" value="<?php if(isset($_POST['title'])) { echo hs($_POST['title']); } ?>">
            <?php if(isset($errors['title'])) { echo $errors['title']; } ?>
          </label>
        </div>
        <div>
          <label>
            Категорія новини:
            <select name="cat">
            <?php
                while ($row = $res->fetch_assoc()) {
                    echo '<option selected>'.$row['name'].'</option>';
                }
                $res->close();
                DB::close();
            ?>
            </select>
            <?php if(isset($errors['cat'])) { echo $errors['cat']; } ?>
          </label>
        </div>
        <div>
          <label>
            Опис новини:
            <textarea name="description"><?php if(isset($_POST['description'])) { echo hs($_POST['description']); } ?></textarea>
            <?php if(isset($errors['description'])) { echo $errors['description']; } ?>
          </label>
        </div>
        <div>
          <label>
            Повний текст новини:
            <textarea name="text"><?php if(isset($_POST['text'])) { echo hs($_POST['text']); } ?></textarea>
            <?php if(isset($errors['text'])) { echo $errors['text']; } ?>
          </label>
        </div>
     </div>
     <input type="submit" name="add" value="Додати новину">
    </form>
</div>