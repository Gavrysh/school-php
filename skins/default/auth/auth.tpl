<div class="wrapper-applications">
  <h1>Форма для авторизації та вихід<span>Будь ласка, заповніть коректно усі поля форми нижче</span></h1>
  <div class="inner-wrap">      
    <?php
        if(isset($_COOKIE['access']) && $_COOKIE['access']) {
            echo '<a href="/auth/auth/exit">Вихід</a><br>';
        } else { 
            echo '<a href="/auth/auth">Вхід</a><br>';
        }
    ?>    
  </div>
  <div class="section">
    <span>1</span>Логін, Пароль, e-mail
  </div>
    <form action="" method="post" class="reg-form">
      <div class="inner-wrap">
      <div>
        <label>Логін<br><input type="text" name="login" class="input-type" value="<?php echo @htmlspecialchars($_POST['login']); ?>"></label><?php echo @$errors['login']; ?>
      </div>
      <div>
        <label>Пароль<br><input type="password" name="pass" class="input-type" value="<?php echo @htmlspecialchars($_POST['pass']); ?>"></label><?php echo @$errors['pass']; ?>
      </div>
      <div>
        <label>e-mail<br><input type="text" name="email" class="input-type" value="<?php echo @htmlspecialchars($_POST['email']); ?>"></label><?php echo @$errors['email']; ?>
      </div>
        <p><label><input type="checkbox" name="autoAuth">&nbsp;Запам'ятати мене</label></p>
      </div>
      <div class="div-submit">
        <input type="submit" name="submit" value="Вхід">
      </div>      
    </form>
    <div class="inner-wrap">
      <span class="note"><a href="#">Реєстрація</a> | <a href="#">Забули пароль?</a><br><a href="/">Повернутися на головну</a></span>
    </div>
</div>