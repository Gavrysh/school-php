<div class="wrapper-applications">
  <h1>Перегляд інформації по автору<?php echo ': '.hs($rowAuthors['name']); ?></h1>
  <div class="inner-wrap books-show">
    <div class="books-show-left-side">
      <img class="books-show-img" src="<?php if($rowAuthors['img'] === '') { echo hs($uploaddir.'authorsDefault.png'); } else { echo hs($uploaddir.'full/'.$rowAuthors['img']); } ?>" alt="books-img">
    </div>
  
    <div class="books-show-central-side">
      <h2><?php echo hs($rowAuthors['name']); ?></h2>
      <p><span>Твори письменника:
      <?php
        if (isset($a)) {
          foreach($a as $key => $val) {
            echo '<br><a href="/books/show/'.$a[$key]['id'].'">'.hs($a[$key]['name']).'</a>';
          }
        }
        ?></span></p>
    </div>
    <div class="books-show-right-side">
    </div>
    <div class="clear"></div>
    <div class="books-show-annotation">
      <h5>Біографія</h5>
      <p><?php echo nl2br(hs($rowAuthors['biography'])); ?></p>
    </div>
    <div class="books-show-footer">
      <p><a href="/books/authors">Повернутися до списку авторів</a></p>
    </div>
  </div>
</div>