<div class="wrapper-applications">
  <h1>Додавання автора</h1>
  <form action="" method="post" enctype="multipart/form-data">
  	<div class="inner-wrap">
      <div class="information">
        <?php if(isset($info)) { echo $info; } ?>
      </div>
      <div class="left-side">
	    	<div>
          <span class="information"><?php if(isset($errors['name'])) { echo $errors['name']; } ?></span>
		      <label>
		        Ім'я, творчий псевдонім:
		        <input type="text" name="name" value="<?php if(isset($_POST['name'])) { echo hs($_POST['name']); } ?>">
		      </label>
		    </div>
      	<div>
          <span class="information"><?php if(isset($errors['biography'])) { echo $errors['biography']; } ?></span>
	        <label>
	          Біографія:
	          <textarea name="biography"><?php if(isset($_POST['biography'])) { echo hs($_POST['biography']); } ?></textarea>
	        </label>
	      </div>
      </div>
      <div class="right-side">
      	<div class="right-side-img">
          <span class="information"><?php if(isset($errors['upload'])) { echo $errors['upload'].'<br>'; } ?></span>
          <span class="information"><?php if(isset($errors['resizeImg'])) { echo $errors['resizeImg']; } ?></span>
          <label>
            Зображення:
          </label>
          <div>
            <input type="file" name="file">
            <!-- <input type="submit" name="uploadImage" value="Завантажити файл"> -->
          </div>
          <img class="add-img" src="<?php if(isset($_SESSION['authorsAddImg'])) { echo hs($uploaddir.$_SESSION['authorsAddImg']); } else { echo hs($uploaddir.'authorsDefault.png'); } ?>" alt="books">
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <input type="submit" name="add" value="Додати автора">
  </form>
</div>