<div class="wrapper-applications">
  <h1>Розділ новин<span>Відображено <?php echo mysqli_num_rows($news); ?> шт. новин</span></h1>
    <div class="information">
      <?php if(isset($info)) { echo '<p>'.$info.'</p><hr>'; } ?>
    </div>
    <form action="" method="get">
      <div class="news-cat-select">
        <select name="cat" class="news-cat-select">
          <?php
              while($rowCat = $cat->fetch_assoc()) {              
                  echo '<option>'.$rowCat['name'].'</option>';
              }
              $cat->close();
          ?>
        </select>   
        <input type="submit" name="" value="Фільтр по категоріям" class="news-cat-filter-btn">
      </div>
    </form>

    <form action="" method="post">
      <div class="news-first-row-right">
        <input type="submit" name="showCat" value="Категорії новин" class="news-cat-add-btn">
      </div>
      <div class="clear"></div>
      <div class="news-second-row">
        <input type="submit" name="add" value="Додати новину" class="news-add-btn">
      </div>
    </form>
    <div class="clear"></div>

    <form action="" method="get">
      <div class="news-third-row">
        <input type="text" name="search" class="news-search">
        <input type="submit" name="" value="Пошук новини" class="news-search-btn">
      </div>
    </form>
    <div class="clear"></div>
    
    <form action="" method="post">
      <div class="news-fourth-row">
        <input type="submit" name="delete" value="Видалити відмічені новини">
      </div>

      <div class="clear"></div>

      <?php while($row = $news->fetch_assoc()) { ?>
        <div class="inner-wrap">
          <div>
            <div class="panel-buttons">
              <input type="checkbox" name="ids[]" value="<?php echo $row['id']; ?>"> 
              <a href="/admin/news/main/delete/<?php echo $row['id']; ?>">Видалити</a> 
              <a href="/admin/news/edit/<?php echo $row['id']; ?>">Редагувати</a><hr>
              <div class="news-date">
                <?php echo date('d-m-Y', strtotime($row['date'])); ?>
              </div>
              <div class="news-time">
                <?php echo date('H:i', strtotime($row['date'])); ?><br>
                <?php echo hs($row['cat']); ?>
              </div>

              <div class="news-content">
                <a href="/admin/news/show/<?php echo $row['id']; ?>"><?php echo nl2br(hs($row['title'])); ?></a>
                <p>
                  <?php echo nl2br(hs(mb_substr($row['description'], 0, 500))).'...'; ?>
                </p>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </div>
      <?php 
        } 
        $news->close();
        DB::close();
      ?>
    </form>
  <div class="paginator">
    <p>
      <?php echo Pagination::navi('./admin/'.$_GET['module'], $_GET['page'], $addon); ?>
    </p>
  </div>
  <div class="clear"></div>
</div>