<div class="wrapper-applications">
  <h1>Перегляд новини<span><?php echo nl2br(hs($row['title'])); ?></span></h1>
  <div class="inner-wrap">
    <div class="news-show-date">
      <?php echo hs($row['cat']); ?><br>
      <?php echo date('d-m-Y, H:i', strtotime($row['date'])); ?>
    </div>
    <div class="news-show-title">
      <h2><?php echo nl2br(hs($row['title'])); ?></h2>
      <p>
        <?php echo nl2br(hs($row['description'])); ?>
      </p>
    </div>
    <div class="clear"></div>
    <div class="news-show-content-left"></div>
    <div class="news-show-content-center">
      <p>
        <?php echo nl2br(hs($row['text'])); ?>
      </p>
    </div>
    <div class="news-show-content-right"></div>
    <div class="clear"></div>
    <div class="news-show-footer">
      <p>
        <a href="/admin/news">Повернутися до списку новин</a>  
      </p>
    </div>
  </div>
</div>