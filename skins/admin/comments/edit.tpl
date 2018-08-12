<div class="wrapper-applications">
  <div class="inner-wrap">
    <h1>Редагування коментару</h1>
      <form action="" method="post">
        <div>
          <label>
            Ім'я *<br>
            <input type="text" name="name" value="<?php if(isset($row['name'])) { echo hs($row['name']); } ?>">
            <?php if(isset($errors['name'])) { echo $errors['name']; } ?>
          </label>
        </div>
        <div>
          <label>
            e-mail *<br>
            <input type="text" name="email" value="<?php if(isset($row['email'])) { echo hs($row['email']); } ?>">
            <?php if(isset($errors['email'])) { echo $errors['email']; } ?>
          </label>
        </div>
        <div>
          <label>
            Коментар *<br>
            <textarea name="comment"><?php if(isset($row['comment'])) { echo hs($row['comment']); } ?>
            </textarea>
            <?php if(isset($errors['comment'])) { echo $errors['comment']; } ?>
          </label>
        </div>
        <input type="submit" name="edit" value="Оновити коментар">
      </form>
  </div>
</div>