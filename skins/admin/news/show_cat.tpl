<div class="wrapper-applications">
  <h1>Розділ категорій новин<span>Перегляд, додавання, редагування, видалення</h1>
  <div class="information">
  	<?php if(isset($info)) { echo '<p>'.$info.'</p><hr>'; } ?>
  </div>
  <form action="" method="post">
  	<div class="usr-first-row-left">
      <select class="user-delete-select" name="active">
        <option selected>Групові дії</option>
      </select>
      <input type="submit" name="delete" value="Видалити" class="user-delete-btn">
    </div>
    <div class="usr-first-row-right">
    	<input type="text" name="name" class="news-cat" value="<?php if(isset($_POST['name'])) { echo hs($_POST['name']); } ?>">
      <input type="submit" name="add" value="Додати категорію" class="user-add-btn">
      <div class="information">
      	<?php if(isset($errors['name'])) { echo $errors['name']; } ?>
      </div>
    </div>
    <div class="clear"></div>
  	<div class="inner-wrap">
	  	<table class="table_blur">
			  <tr>
			    <th></th>
			    <th class="news-cat-serial-point">№ п/п</th>
			    <th class="news-cat-name">Назва категорії</th>
			  </tr>
		  	<?php
		        $ncsp = 0;
		        while($row = $res->fetch_assoc()) {
		            echo '<tr class="news_cat_check"><td><input type="checkbox" name="gns[]" value="'.$row['id'].'"></td>';
		            echo '<td>'.++$ncsp.'</td>';
		            echo '<td><a href="/admin/news/edit_cat/'.$row['id'].'">'.hs($row['name']).'</a></td>';
		            echo '</tr>';
		        }
		        $res->close();
		        DB::close();
		    ?>
			</table>
	  </div>
	</form>
</div>