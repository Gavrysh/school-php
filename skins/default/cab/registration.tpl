<div class="wrapper-applications">
  <h1>Форма реєстрації нового користувача сайту<span>Будь ласка, заповніть коректно усі поля форми позначені зірочкою (*)</span></h1>
  <?php if(!isset($_SESSION['regok'])) { ?>
  <div class="section"><span>1</span>Логін, Пароль, Ім'я, e-mail, вік</div>
  <form action="" method="post" class="reg-form">
      <div class="inner-wrap">
      <div>
        <label>Логін*<br><input type="text" name="login" class="input-type" value="<?php echo @htmlspecialchars($_POST['login']); ?>"></label><?php echo @$errors['login']; ?>
      </div>
      <div>
        <label>Пароль*<br><input type="password" name="pass" class="input-type" value="<?php echo @htmlspecialchars($_POST['pass']); ?>"></label><?php echo @$errors['pass']; ?>
      </div>
      <div>
        <label>Ім'я*<br><input type="text" name="name" class="input-type" value="<?php echo @htmlspecialchars($_POST['name']); ?>"></label><?php echo @$errors['name']; ?>
      </div>
      <div>
        <label>e-mail*<br><input type="text" name="email" class="input-type" value="<?php echo @htmlspecialchars($_POST['email']); ?>"></label><?php echo @$errors['email']; ?>
      </div>
      <div>
        <label>Вік*<br><input type="text" name="age" class="input-type" value="<?php echo @htmlspecialchars($_POST['age']); ?>"></label><?php echo @$errors['age']; ?>
      </div>
      <p class="footnote">* - поля, обов'язкові для завовнення</p>
      </div>
      <div class="div-submit">
        <input type="submit" name="submit" value="Зареєструватися">
      </div>      
    </form>
    <?php } else { unset($_SESSION['regok']); unset($errors); ?>
  <div>
      Ви вдало зареєструвалися на сайті!<br>
      На зазначений e-mail висланий лист на підтвердження реєстрації.
  </div>
  <?php } ?>
</div>