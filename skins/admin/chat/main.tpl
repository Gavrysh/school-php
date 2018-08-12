<script>
  window.onload = function() {
    document.getElementById('add-notice').onclick = addNotice;
  }
  setInterval(loadNotice, 3000);
</script>
<div class="wrapper-applications">
  <h1>Чат<span>Cпілкування відвідувачив сайту у реальному часі. Можливість спілкування з'являється при аутентифікації на цьому сайті</span></h1>
  <div>
    <span id="inform" class="information"><?php if (isset($errors['user'])) { echo '<p>'.$errors['user'].'</p>'; } ?></span>
    <hr>
  </div>
  <div class="chat-list-users">
    <div class="inner-wrap">
      <?php
        while ($row = $listUsers->fetch_assoc()) {?>
          <img src="/uploaded/ban.png" alt="ban-ico" width="40px" height="20px">
          <img src="/uploaded/unban.png" alt="ban-ico" width="40px" height="20px">
          <?php
          if ($row['access'] == 'administrator' || $row['access'] == 'moderator') {
            echo '<img src="/uploaded/admin.png" alt="chat-ico" width="20px" height="20px"> <span id="chat-user" onclick="addUserMsg(this.innerHTML)">'.$row['name'].'</span><br>';
          } else {
            echo '<span id="chat-user" onclick="addUserMsg(this.innerHTML)">'.$row['name'].'</span><br>';
          }
        }
      ?>
    </div>
  </div>
  <div class="chat">
    <div id="chat-text" class="inner-wrap">
      <?php
        while ($row = $chat->fetch_assoc()) {
          echo '<span class="notice-date">'.$row['date'].'</span> <span class="notice-user">'.$row['user'].'</span><br><span class="notice-text">'.$row['text'].'</span><br>';
        }
      ?>
    </div>
  </div>
  <div class="clear"></div>
  <div>
    <?php
      for ($i = 1; $i <=7; ++$i) { ?>
        <img id="ch0<?=$i?>" src="/skins/admin/img/ch0<?=$i?>.png" alt="smile" width="30px" height="30px" onclick="addUserMsg('[:'+this.id+':]')">
      <?php }
    ?>
  </div>
  <form action="" method="post">
    <div id="show-info" class="information"></div>
    <span class="information"><?php if (isset($errors['notice'])) { echo $errors['notice']; } ?></span>
    <label>Повідомлення<input id="notice" type="text" name="notice"></label>
    <input id="add-notice" type="submit" name="submit" value="Надіслати">
  </form>
</div>