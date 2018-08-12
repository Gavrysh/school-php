<div class="wrapper-applications">
  <h1>Список авторів книжок<span>Загальна кількість на сторінці <?php echo (isset($books) ? $books->num_rows : $authors->num_rows) ?> шт.</span></h1>
  <div class="information">
    <?php if(isset($info)) { echo '<p>'.$info.'</p><hr>'; } ?>
  </div>
  <div class="top">
    <div class="top-left">
      <form action="" method="post">
        <input type="submit" name="books" value="Каталог книжок" class="search-btn">
      </form>
    </div>
    <div class="top-center">
      <form action="" method="post">
        <input type="text" name="searchBook" class="search">
        <input type="submit" name="" value="Знайти книжку" class="search-btn"> 
      </form>
    </div>
    <div class="top-right">
      <form action="" method="post">
        <input type="text" name="searchAuthor" class="search">
        <input type="submit" name="" value="Знайти автора" class="search-btn">
      </form>
    </div>
    <div class="clear"></div>
  </div>
  <form action="" method="post">
    <?php if (isset($output) && count($output)) {
      foreach($output as $key => $value) { ?>
        <div class="inner-wrap">
          <div>
            <div class="image-books">
              <img src="<?php if($output[$key]['img'] === '') { echo hs($uploaddir.'booksDefault.png'); } else { echo $uploaddir.'mini/'.$output[$key]['img']; } ?>" alt="books-img" class="books-img">
            </div>
            <div class="books-header">
              <?php echo hs($output[$key]['name'].'. '.$output[$key]['nameAuthor']); ?>
              <p>
                <?php echo nl2br(hs(mb_substr($output[$key]['annotation'], 0, 500))); ?>&hellip;<br>
                <a href="/books/show/<?php echo $output[$key]['id'] ?>">Детальніше &raquo;</a>
              </p>
            </div>
            <div class="clear"></div>
          </div>
        </div>
    <?php } }
      else { 
        if(isset($authors)) {
          while($row = $authors->fetch_assoc()) { ?>
            <div class="inner-wrap">
              <div>
                <div class="image-books">
                  <img src="<?php if($row['img'] === '') { echo hs($uploaddir.'authorsDefault.png'); } else { echo $uploaddir.'mini/'.$row['img']; } ?>" alt="authors-img" class="books-img">
                </div>
                <div class="books-header">
                  <?php echo hs($row['name']); ?>
                  <p>
                    <?php echo nl2br(hs(mb_substr($row['biography'], 0, 500))); ?>&hellip;<br>
                    <a href="/books/authors_show/<?php echo $row['id'] ?>">Детальніше &raquo;</a>
                  </p>
                </div>
                <div class="clear"></div>
              </div>
            </div>
        <?php
          }
        }
        if(isset($authors)) {$authors->close();}
        if(isset($books)) {$books->close();}
        DB::close();
      } 
        ?>
  </form>
</div>