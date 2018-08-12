<div class="wrapper-applications">
    <h1>Міні-гра &laquo;Битва алкоголіків&raquo;<span>Гру закінчено</span></h1>
    <div class="inner-wrap">
      <?php
          if(isset($_SESSION['gamer'], $_SESSION['server'])) {
              if ($_SESSION['gamer'] <= 0 ) {
                  echo $user.'<br>Ти все пропив!!!';
              } elseif ( $_SESSION['server'] <= 0 ) {
                  echo $server.'<br>Система теж непагано закладає!<br> Твоя перемога!!!';
              }
              session_unset();
              session_destroy();
      ?>
      </div>
      <form action="" method="post">
        <input type="submit" name="playagain" value="Грати знову!">
        <input type="submit" name="playnone" value="На головну!">
      </form>
    <?php
        } else {
    ?>
      <form action="" method="post">
      <input type="submit" name="playnone" value="На головну!">
      </form>
    <?php 
        } 
    ?>
</div>  