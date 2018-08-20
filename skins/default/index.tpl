<!doctype html>
<html lang="ru">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title><?php echo hs(Core::$META['title']); ?></title>
  <meta name="description" content="<?php echo hs(Core::$META['description']); ?>">
  <meta name="keywords" content="<?php echo hs(Core::$META['keywords']); ?>">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700%7CYanone+Kaffeesatz:300,400,700%7CPoppins:300,400,600" rel="stylesheet"> 
  <link href="/css/style.css" type="text/css" rel="stylesheet">
  <link href="/css/app.css" type="text/css" rel="stylesheet">
  <?php if(array_key_exists($_GET['module'], Core::$CSS)) { echo Core::$CSS[$_GET['module']]."\n"; } ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="/skins/default/js/scripts_v1.js?v=1"></script>
  <?php if(array_key_exists($_GET['module'], Core::$JS)) { echo Core::$JS[$_GET['module']]."\n"; } ?>
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

  <div class="slider">
    <div class="slider-logo">
      <img src="/img/logo_b.png" alt="logo" width="304" height="263">
      <h1>Art Idea</h1>
      <h2>STUDIO OF PAINTERS</h2>
    </div>
  </div>
    <div class="navigation-top">
      <div class="navigation-top-content-wrapper">
        <div class="navigation-top-content-wrapper-left">
          <ul class="nav">
            <li><a href="/" class="homeLink">HOME</a></li>
            <li><a href="/games/gameAlcohol" class="gameLink">Game</a></li>
            <li><a href="/programs/fm" class="fmLink">File manager</a></li>
            <li><a href="/comments/comment" class="commentsLink">Comments</a></li>
            <li><a href="/news" class="newsLink">News</a></li>
            <li><a href="/goods" class="goodsLink">Goods</a></li>
            <li><a href="/books" class="booksLink">Books</a></li>
            <li><a href="/chat">Chat</a></li>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['active'] == 'активний') { echo '<li><a href="/profile" class="profile">Profile</a></li>'; } ?>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['active'] == 'активний' && $_SESSION['user']['access'] == 'administrator') { echo '<li><a href="/admin" class="adminLink">Admin</a></li>'; } ?>
          </ul>
        </div>
        <div class="navigation-top-content-wrapper-right">
          <span><?php if(isset($_SESSION['user']) && $_SESSION['user']['active'] == 'активний') { echo '<a href="/cab/exit">Вихід</a>'; } else { echo '<a href="/cab/auth" onclick="hideShowElement(\'modal-authorization\'); return false;">Вхід</a>'; } ?></span>
          <span><?php if(!isset($_SESSION['user'])) { echo '&nbsp;&nbsp;<a href="/cab/registration">Реєстрація</a>'; } ?></span>
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
            <li><a href="/">HOME</a></li>
            <li><a href="/games/gameAlcohol" class="gameLink">Game</a></li>
            <li><a href="/programs/fm" class="fmLink">File manager</a></li>
            <li><a href="/comments/comment" class="commentsLink">Comments</a></li>
            <li><a href="/news" class="newsLink">News</a></li>
            <li><a href="/goods" class="goodsLink">Goods</a></li>
            <li><a href="/books" class="booksLink">Books</a></li>
            <li><a href="/chat">Chat</a></li>
          </ul><br>
          <span class="footer-content-copyright"><?php echo Copyright(); ?><span>|</span> <a href="#">Privacy Policy</a></span>
        </div>
      </div>
    </div>
</body>
</html>
