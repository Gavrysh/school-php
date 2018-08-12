<script>
  window.onload = function() {
    document.getElementById('add-comment').onclick = addComment;
  }
</script>
<div class="wrapper-applications">
  <h1>Розділ коментарів<span>Загальна кількість на сторінці <?php echo $res->num_rows; ?> шт.</span></h1>
  <span id="inform" class="information"><?php if(isset($info)) { echo '<p>'.$info.'</p><hr>'; } ?></span>
  <div id="comm-show" class="comments-show">
    <?php 
      if($res->num_rows) {
        while($row = $res->fetch_assoc()) { ?>
          <div class="inner-wrap">
            <div class="panel-buttons">
              <a href="/admin/comments/main/delete/<?php echo $row['id']; ?>" onclick="return confirm('Ви дійсно бажаєте видалити цей запис?');">Видалити</a>&nbsp;
              <a href="/admin/comments/edit/<?php echo $row['id']; ?>">Редагувати</a>
            </div><hr>
            <div class="comments-out-name"><?php echo hs($row['name']); ?></div>
            <div class="comments-out-date"><?php echo hs($row['date']); ?></div>
            <div class="comments-out-text"><?php echo nl2br(hs($row['comment'])); ?></div>
          </div>
    <?php } } ?>
  </div>

    <div class="comments-form">
      <p>Напишійть свій коментар</p>
      <form action="" method="post">
        <div id="show-info" class="information"></div>
        <div class="inner-wrap">
        <div>
          <span class="information" id="error-name"><?php if(isset($errors['name'])) { echo $errors['name']; } ?></span>
          <label>Ім'я *<br><input id="name" type="text" name="name" value="<?php if(isset($_POST['name'])) { echo hs($_POST['name']); } ?>"></label>
        </div>
        <div>
          <span class="information" id="error-email"><?php if(isset($errors['email'])) { echo $errors['email']; } ?></span>
          <label>e-mail *<br><input id="email" type="text" name="email" value="<?php if(isset($_POST['email'])) { echo hs($_POST['email']); } ?>"></label>
        </div>
        <div>
          <span class="information" id="error-comment"><?php if(isset($errors['comment'])) { echo $errors['comment']; } ?></span>
          <label>Коментар *<br><textarea id="comment" rows="10" cols="45" name="comment"><?php if(isset($_POST['comment'])) { echo nl2br(hs($_POST['comment'])); } ?></textarea></label>
        </div>
        <p class="footnote">* - поля, обов'язкові для завовнення</p>
        </div>
          <input id="add-comment" type="submit" name="submit" value="Надіслати">
      </form>
    </div>
  
</div>