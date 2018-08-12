<div class="wrapper-applications">
  <h1>Користувачі<span>Розділ по адмініструванню користувачів сайту</span></h1>
  <span class="information"><?php if(isset($info)) { echo '<p>'.$info.'</p><hr>'; } ?></span>
  
  <form action="" method="post">
    <div class="user-role-select">
      <select name="access" class="user-role-select">
        <?php
            foreach ($access as $var) {              
                echo '<option>'.$var.'</option>';
            }
        ?>
      </select>   
      <input type="submit" name="filter-role" value="Показати" class="user-filter-btn">
    </div>

    <div class="usr-first-row-right">
      <input type="text" name="search" class="user-search">
      <input type="submit" name="search-btn" value="Пошук користувача" class="user-search-btn">
    </div>

    <div class="clear"></div>

    <div class="usr-second-row-left">
      <select class="user-delete-select" name="active">
        <option selected>Групові дії</option>
      </select>
      <input type="submit" name="delete" value="Видалити" class="user-delete-btn">
    </div>

    <div class="usr-second-row-right">
      <input type="submit" name="add" value="Додати користувача" class="user-add-btn">
    </div>
  
  
  <table class="table_blur">
  <tr>
    <th></th>
    <th class="user-serial-point">п/п</th>
    <th class="user-login">Логін</th>
    <th class="user-name">Ім'я користувача</th>
    <th class="user-email">E-mail</th>
    <th class="user-role">Роль</th>
    <th class="user-chat">Чат</th>
  </tr>
  <?php
        $usp = 0;
        while ($row = $users->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="gns[]" value="'.$row['id'].'"></td>';
            echo '<td>'.++$usp.'</td>';
            echo '<td><a href="/admin/users/edit/'.$row['id'].'">'.hs($row['login']).'</a></td>';
            echo '<td>'.hs($row['name']).'</td>';
            echo '<td>'.hs($row['email']).'</td>';
            echo '<td>'.hs($row['access']).'</td>';
            echo '<td>'.hs($row['access_chat']).'</td></tr>';
        } 
    ?>
  </table>
  </form>
</div>    