<div class="wrapper-applications">
  <h1>Міні-гра &laquo;Битва алкоголіків&raquo;, ціль якої показати що алкоголізм - це пагано<span>Будь ласка, введіть число від 1 до 3</span></h1>
    <div class="div-content">
      <div class="inner-wrap">
        <table class="table-state">
          <tr>
            <td>
              user HP: <?php echo $_SESSION['gamer']; ?>
            </td>
            <td>
              computer HP: <?php echo $_SESSION['server']; ?>
            </td>
          </tr>
          <tr>
            <td><img src="/img/<?php 
                switch($_SESSION['gamer']) {
                    case 10:
                        echo $user[0];
                        break;
                    case 9: case 8: case 7:
                        echo $user[1];
                        break;
                    case 6: case 5: case 4:
                        echo $user[2];
                        break;
                    case 3: case 2: case 1: 
                        echo $user[3];
                        break;
                    default:
                        echo $user[0];
                        break;
                } ?>" alt="user"></td>
            <td><img src="/img/<?php
                switch($_SESSION['server']) {
                    case 10:
                        echo $server[0];
                        break;
                    case 9: case 8: case 7:
                        echo $server[1];
                        break;
                    case 6: case 5: case 4:
                        echo $server[2];
                        break;
                    case 3: case 2: case 1: 
                        echo $server[3];
                        break;
                    default:
                        echo $server[0];
                        break;
                } ?>" alt="comp"></td>
          </tr>
          <tr>
            <td>Удар: <?php echo $user_hit; ?></td>
            <td>Блок: <?php echo $server_block; ?></td>
          </tr>
        </table>
      </div>
      <div class="inner-wrap">
        <p><?php
          if($gamer_pass > 0) {
              echo 'Сервер заблокував стопарік і налив у відповідь '.$gamer_pass.' літрів зілля!!! Прийдеться випити...';
          } elseif($server_pass > 0) {
              echo 'Ви заливаєте у комп\'ютер '.$server_pass.' літрів зілля. Його екран змінюється...';
          } else {
              echo 'Ви та комп\'ютер перебуваєте у тверозому стані!';
          }
        ?></p>
      </div>
        <form action="" method="post">
          <div class="inner-wrap">
            <label>Введіть число від 1 до 3<br><input type="text" name="hit" value="<?php echo @htmlspecialchars($_POST['hit']); ?>"></label><?php echo @$errors['hit']; ?>
          </div>
            <input type="submit" name="againPlay" value="Вдарити!">
        </form>
    </div>
</div>  