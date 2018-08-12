<div class="wrapper-applications">
  <h1>Авторизація на сайті</h1>
    <?php if(!isset($status) || $status != 'OK') { echo @$error; ?>
      <form action="" method="post">
        <div class="inner-wrap">
          <label>Логін: <input type="text" name="login"></label>
          <label>Пароль: <input type="password" name="pass"></label>
          <p><label><input type="checkbox" name="autoAuth">&nbsp;Запам'ятати мене</label></p>
        </div>
        <input type="submit" name="submit" value="Вхід">
      </form>
    <?php } else { ?>
    <p>Вітаю, Ви авторизовані!</p>
    <?php } ?>
</div>