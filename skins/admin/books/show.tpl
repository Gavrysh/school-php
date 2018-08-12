<div class="wrapper-applications">
  <h1>Перегляд інформації про книжку<?php echo ': '.hs($rowBooks['name']); ?></h1>
  <form action="" method="post">  
    <input type="submit" name="delete" value="Видалити книгу">
    <input type="submit" name="edit" value="Редагувати книгу"><hr>
    <div class="inner-wrap books-show">
      <div class="books-show-left-side">
        <img class="books-show-img" src="<?php if($rowBooks['img'] === '') { echo hs($uploaddir.'booksDefault.png'); } else { echo hs($uploaddir.'full/'.$rowBooks['img']); } ?>" alt="books-img">
      </div>
      <div class="books-show-central-side">
        <h2><?php echo hs($rowBooks['name']); ?></h2>
        <p><span>Кількість сторінок: <?php echo (int)($rowBooks['pages']); ?></span></p>
        <p><span>Дата публікації: <?php echo hs($rowBooks['publication']); ?></span></p>
        <p>
          <span>Автор(и): 
            <?php
              if (isset($a)) {
                foreach($a as $key => $val) {
                  echo '<br><a href="/admin/books/authors_show/'.$a[$key]['id'].'">'.hs($a[$key]['name']).'</a>';
                }
              }
            ?>
          </span>
        </p>
      </div>
      <div class="books-show-right-side">
        <p><span>Ціна: <?php echo (float)($rowBooks['price']); ?> грн.</span></p>
        <form action="" method="post">
          <input type="submit" name="by" value="Купувати">
        </form>
      </div>
      <div class="clear"></div>
      <div class="books-show-annotation">
        <h5>Анотація</h5>
        <p><?php echo nl2br(hs($rowBooks['annotation'])); ?></p>
      </div>
      <div class="books-show-footer">
        <p><a href="/admin/books">Повернутися до каталогу книжок</a></p>
      </div>
    </div>
  </form>
</div>
