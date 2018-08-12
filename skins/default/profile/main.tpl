<div class="wrapper-applications">
  <h1>Профайл користувача<span>Перегляд даних користувача</span></h1>
  <div class="inner-wrap profile">
    <div class="information">
      <?php if(isset($info)) { echo $info; } ?>
    </div>
    <div class="profile-name-user">
      <p><img class="profile-user-image" src="<?php if(isset($_SESSION['user']['img']) && $_SESSION['user']['img'] !='') { echo hs($uploaddir.'full/'.$_SESSION['user']['img']); } else { echo hs($uploaddir.'default.png'); } ?>" alt="avatar"></p>
      <p>Ім'я - <span><?php echo hs($row['name']) ?></span></p>
    </div>
    <div class="profile-user-contacts">
      <p>Електрона адреса - <span><?php echo hs($row['email']) ?></span></p>
    </div>
    <div class="profile-user-other">
      <p>Вік - <span><?php echo hs($row['age']) ?></span></p>
      <div class="profile-user-block-image">
        <p>Змінити зображення облікового запису</p>
        <form action="" method="post" enctype="multipart/form-data">
          <input type="file" name="file">
          <input type="submit" name="uploadImage" value="Завантажити файл">
        </form>
      </div>
      <p>Попередній перегляд</p>
      <img class="profile-user-image" src="<?php if(isset($_SESSION['img'])) { echo hs($uploaddir.$_SESSION['img']); } else { echo hs($uploaddir.'default.png'); } ?>" alt="avatar">
    </div>
  </div>
  <form action="" method="post">
    <input type="submit" name="save" value="Зберегти зміни">
  </form>
</div>