<!doctype html>
<html lang="ru">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title><?php echo hs(Core::$META['title']); ?></title>
  <meta name="description" content="<?php echo hs(Core::$META['description']); ?>">
  <meta name="keywords" content="<?php echo hs(Core::$META['keywords']); ?>">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700%7CYanone+Kaffeesatz:300,400,700%7CPoppins:300,400,600" rel="stylesheet"> 
  <link href="/skins/admin/css/style.css" type="text/css" rel="stylesheet">
  <link href="/skins/admin/css/app.css" type="text/css" rel="stylesheet">
  <?php if(array_key_exists($_GET['module'], Core::$CSS_ADMIN)) { echo Core::$CSS_ADMIN[$_GET['module']]."\n"; } ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="/skins/admin/js/scripts_v1.js?v=1"></script>
</head>
<body>

  <div class="modal" id="modal-authorization" style="display: none;">
    <div class="modal-header">
      <h1>Авторизація на сайті<span>Будь ласка, введіть логін та пароль, або зареєструйтесь на сайті</span></h1>
    </div>
    <form action="/cab/auth" method="post">
      <div class="modal-body">
        <span class="information" id="modal-error-login"></span>
        <label>Логін: <input type="text" name="login" id="modal-login"></label>
        <span class="information" id="modal-error-pass"></span>
        <label>Пароль: <input type="password" name="pass" id="modal-pass"></label>
      </div>
      <div class="modal-footer">
        <input id="modal-submit-input" type="submit" name="input" value="Підтвердити" onclick="return subInput();">
        <input id="modal-submit-cancel" type="submit" name="cancel" value="Відмовитись" onclick="return subCancel();">
      </div>
    </form>
  </div>

  <div class="navigation-top">
    <div class="navigation-top-content-wrapper">
      <div class="navigation-top-content-wrapper-left">
        <ul class="nav">
          <li><a href="/" class="homeLink">BACK TO SITE</a></li>
          <?php if(isset($_SESSION['user']) && $_SESSION['user']['active'] == 'активний' && $_SESSION['user']['access'] == 'administrator') { ?>
          <li><a href="/admin/comments">Comments</a></li>
          <li><a href="/admin/news">News</a></li>
          <li><a href="/admin/goods">Goods</a></li>
          <li><a href="/admin/books" class="booksLink">Books</a></li>
          <li><a href="/admin/users">Users</a></li>
          <?php } ?>
        </ul>
      </div>
      <div class="navigation-top-content-wrapper-right">
        <span><?php if(isset($_SESSION['user']) && $_SESSION['user']['active'] == 'активний') { echo '<a href="/cab/exit">Вихід</a>'; } else { echo '<a href="/cab/auth" onclick="hideShowElement(\'modal-authorization\'); return false;">Вхід</a>'; } ?></span>
        <span><?php if(!isset($_SESSION['user'])) { echo '&nbsp;&nbsp;<a href="/cab/registration">Registration</a>'; } ?></span>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <?php echo $content; ?>    
  <div class="footer">
    <div class="footer-wrapper">
      <div class="footer-left">
        <img src="/img/logo_b.png" alt="" width="84" height="73">
        <h1>Art Idea</h1>
        <h2>STUDIO OF PAINTERS</h2>
      </div>
      <div class="footer-right">
        <ul class="nav">
          <li><a href="/" class="homeLink">BACK TO SITE</a></li>
          <?php if(isset($_SESSION['user']) && $_SESSION['user']['active'] == 'активний' && $_SESSION['user']['access'] == 'administrator') { ?>
          <li><a href="/admin/comments">Comments</a></li>
          <li><a href="/admin/news">News</a></li>
          <li><a href="/admin/goods">Goods</a></li>
          <li><a href="/admin/books" class="booksLink">Books</a></li>
          <li><a href="/admin/chat">Chat</a></li>
          <li><a href="/admin/users">Users</a></li>
          <?php } ?>
        </ul><br>
        <span class="footer-content-copyright"><?php echo Copyright(); ?><span>|</span> <a href="#">Privacy Policy</a></span>
      </div>
    </div>
  </div>
</body>
</html>
