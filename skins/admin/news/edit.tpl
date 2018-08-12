<div class="wrapper-applications">
    <h1>Редагування новини</h1>
    <form action="" method="post">
      <div class="inner-wrap">
        <div>
          <label>Заголовок новини:
            <input type="text" name="title" value="<?php if(isset($row['title'])) { echo hs($row['title']); } ?>">
            <?php if(isset($errors['title'])) { echo $errors['title']; } ?>
          </label>
        </div>
        <div>
          <label>Категорія новини:
            <select name="cat">
            <?php
                while ($sel = $res->fetch_assoc()) {
                    if($sel['name'] === $row['cat']) {
                        echo '<option selected>'.$sel['name'].'</option>';
                    } else {
                        echo '<option>'.$sel['name'].'</option>';
                    }
                }
                $res->close();
                DB::close();
            ?>
            </select>
            <?php if(isset($errors['cat'])) { echo $errors['cat']; } ?>
          </label>
        </div>
        <div>
          <label>Опис новини:
            <textarea name="description"><?php if(isset($row['description'])) { echo hs($row['description']); } ?></textarea>
            <?php if(isset($errors['description'])) { echo $errors['description']; } ?>
          </label>
        </div>
        <div>
          <label>
            Повний текст новини:
            <textarea name="text"><?php if(isset($row['text'])) { echo hs($row['text']); } ?></textarea>
            <?php if(isset($errors['text'])) { echo $errors['text']; } ?>
          </label>
        </div>
      </div>
      <input type="submit" name="edit" value="Внести зміни до новини">
    </form>
</div>