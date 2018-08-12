<div class="wrapper-applications">
  <h1>Розділ новин<span>Відображено <?php echo $news->num_rows; ?> шт. новин</span></h1>
  
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
    <div class="news-first-row-right"></div>
    <div class="clear"></div>
  </form>

  <form action="" method="get">
    <div class="news-third-row">
      <input type="text" name="search" class="news-search">
      <input type="submit" name="" value="Пошук новини" class="news-search-btn">
    </div>
    <div class="clear"></div>
  </form>

  <div class="inner-wrap">
    <?php while($row = $news->fetch_assoc()) { ?>
      <div class="news-wrapper">
        <div class="news-date">
          <?php echo date('d-m-Y', strtotime($row['date'])); ?>
        </div>
        <div class="news-time">
          <?php echo date('H:i', strtotime($row['date'])); ?><br>
          <?php echo hs($row['cat']); ?>
        </div>
        <div class="news-content">
          <a href="/news/show/<?php echo $row['id']; ?>"><?php echo nl2br(hs($row['title'])); ?></a>
          <p>
            <?php echo nl2br(hs(mb_substr($row['description'], 0, 500))).'...'; ?>
          </p>
        </div>
        <div class="clear"></div>
      </div>
    <?php
      }
      $news->close();
      DB::close();
    ?>
  </div>
  <div class="paginator">
    <p>
      <?php echo Pagination::navi($_GET['module'], $_GET['page'], $addon); ?>
    </p>
  </div>
  <div class="clear"></div>
</div>