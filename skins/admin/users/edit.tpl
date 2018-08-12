<div class="wrapper-applications">
  <h1>Редагування користувача</h1>
  <form action="" method="post">
    <div class="inner-wrap">

      <span class="information"><?php if(isset($errors['login'])) { echo $errors['login']; } ?></span>
      <label>Логін:
        <input type="text" name="login" value="<?php if(isset($row['login'])) { echo hs($row['login']); } ?>">
      </label>
      
      <span class="information"><?php if(isset($errors['pass'])) { echo $errors['pass']; } ?></span>
      <label>Пароль:
        <input type="text" name="pass" value="<?php if(isset($row['password'])) { echo hs($row['password']); } ?>">
      </label>

      <span class="information"><?php if(isset($errors['name'])) { echo $errors['name']; } ?></span>
      <label>Ім'я користувача:
        <input type="text" name="name" value="<?php if(isset($row['name'])) { echo hs($row['name']); } ?>">
      </label>
      
      <span class="information"><?php if(isset($errors['email'])) { echo $errors['email']; } ?></span>
      <label>E-mail:
        <input type="text" name="email" value="<?php if(isset($row['email'])) { echo hs($row['email']); } ?>">
      </label>
      
      <span class="information"><?php if(isset($errors['age'])) { echo $errors['age']; } ?></span>
      <label>Вік:
        <input type="text" name="age" value="<?php if(isset($row['age'])) { echo hs($row['age']); } ?>">
      </label>
      
      <span class="information"><?php if(isset($errors['active'])) { echo $errors['active']; } ?></span>
      <label>Активність:
        <select name="active">
          <?php
              foreach ($active as $var) {
                  if ($var == $row['active']) {
                      echo '<option selected>'.$var.'</option>';
                  } else {
                      echo '<option>'.$var.'</option>';
                  }
              }
          ?>
        </select>
      </label>
      
      <span class="information"><?php if(isset($errors['access'])) { echo $errors['access']; } ?></span>
      <label>Рівень доступу:
        <select name="access">
          <?php
              foreach ($access as $var) {
                  if ($var == $row['access']) {
                      echo '<option selected>'.$var.'</option>';
                  } else {
                      echo '<option>'.$var.'</option>';
                  }
              }
          ?>
        </select>
      </label>
      
      <span class="information"><?php if(isset($errors['remote_addr'])) { echo $errors['remote_addr']; } ?></span>
      <label>IP адреса:
        <input type="text" name="remote_addr" value="<?php if(isset($row['remote_addr'])) { echo hs($row['remote_addr']); } ?>">
      </label>
      
      <span class="information"><?php if(isset($errors['http_user_agent'])) { echo $errors['http_user_agent']; } ?></span>
      <label>Юзер агент:
        <input type="text" name="http_user_agent" value="<?php if(isset($row['http_user_agent'])) { echo hs($row['http_user_agent']); } ?>">
      </label>

      <span class="information"><?php if(isset($errors['access_chat'])) { echo $errors['access_chat']; } ?></span>
      <label>Можливість писати у чат:
        <select name="access_chat">
          <?php
              foreach ($access_chat as $var) {
                  if ($var == $row['access_chat']) {
                      echo '<option selected>'.$var.'</option>';
                  } else {
                      echo '<option>'.$var.'</option>';
                  }
              }
          ?>
        </select>
      </label>
      
    </div>
    <input type="submit" name="edit" value="Внести зміни">
  </form>
</div>