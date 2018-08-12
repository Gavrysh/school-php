<script>
  window.onload = function() {
    document.getElementById('add-notice').onclick = addNotice;
    //document.getElementById('btn-ban-unbun').onclick = banUnban(this.id);
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
        foreach ($outUsers as $key => $val) {
          echo '<div id="user">'.$outUsers[$key]['btn'].' '.$outUsers[$key]['ico'].' '.$outUsers[$key]['name'].'</div>';
        }
      ?>
    </div>
  </div>
  <div class="chat">
    <div id="chat-text" class="inner-wrap">
      <?php
        foreach ($outChat as $key => $val) {
          if (isset($_SESSION['user'])) {
            echo '<input type="checkbox" name="nt">';
          }
          echo $outChat[$key]['text'];
        }
      ?>
    </div>
  </div>
  <div class="clear"></div>
  <div>
    <?php
      for ($i = 1; $i <=7; ++$i) { ?>
        <img id="ch0<?=$i?>" src="/skins/default/img/ch0<?=$i?>.png" alt="smile" width="30px" height="30px" onclick="addUserMsg('[:'+this.id+':]')">
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