<div class="wrapper-applications">
  <h1>Редагування інформації по автору<?php echo ': '.hs($rowAuthors['name']); ?></h1>
  <form action="" method="post" enctype="multipart/form-data">
  	<div class="inner-wrap">
      <div class="information">
        <?php if(isset($info)) { echo $info; } ?>
      </div>
      <div class="left-side">
	    	<div>
          <span class="information"><?php if(isset($errors['name'])) echo $errors['name']; ?></span>
		      <label>
		        Ім'я, творчий псевдонім:
		        <input type="text" name="name" value="<?php if(isset($rowAuthors['name'])) { echo hs($rowAuthors['name']); } ?>">
		      </label>
		    </div>
      	<div>
          <span class="information"><?php if(isset($errors['biography'])) { echo $errors['biography']; } ?></span>
	        <label>
	          Біографія:
	          <textarea name="biography"><?php if(isset($rowAuthors['biography'])) { echo hs($rowAuthors['biography']); } ?></textarea>
	        </label>
	      </div>
      </div>
      <div class="right-side">
      	<div class="right-side-img">
          <span class="information"><?php if(isset($errors['resizeImg'])) { echo $errors['resizeImg']; } ?></span>
          <span class="information"><?php if(isset($errors['upload'])) { echo $errors['upload'].'<br>'; } ?></span>
          <label>
            Зображення:
          </label>
          <div>
            <input type="file" name="file">
          </div>
          <label>Попередній перегляд</label>
          <img class="goods-edit-image" src="<?php 
            if(isset($_SESSION['authorsEditImg']) && $_SESSION['authorsEditImg'] !='') { 
              echo hs($uploaddir.$_SESSION['authorsEditImg']); 
            } elseif($rowAuthors['img'] == 'authorsDefault.png'){
              echo hs($uploaddir.'authorsDefault.png');
            } else { 
              echo hs($uploaddir.'full/'.$rowAuthors['img']); 
            } ?>" alt="authors">
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <input type="submit" name="edit" value="Внести зміни">
  </form>
</div>