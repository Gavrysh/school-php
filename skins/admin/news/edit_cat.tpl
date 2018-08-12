<div class="wrapper-applications">
  <h1>Редагування категорії новини</h1>
  <form action="" method="post">
    <div class="inner-wrap">
      
      <label>
        Назва категорії:
        <input type="text" name="name" value="<?php if(isset($row['name'])) { echo hs($row['name']); } ?>">
      </label>
      <div class="errorMessage">
        <?php if(isset($errors['name'])) { echo $errors['name']; } ?>
      </div>
    </div>
    <input type="submit" name="edit" value="Внести зміни">
  </form>
</div>