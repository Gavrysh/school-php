<div class="wrapper-applications">
    <h1>Чат<span>спілкування у реальному часі з іншими відвідувачами сайту</span></h1>
    <div class="inner-wrap">
        <div class="chat-list-users">

        </div>
        <div class="chat">

        </div>
        <div class="clear"></div>

        <div class="smiles"></div>

        <form action="" method="post">
            <div id="show-info" class="information"></div>
            <span class="information"><?php if (isset($errors['notice'])) { echo $errors['notice']; } ?></span>
            <label>Повідомлення<input id="notice" type="text" name="notice"></label>
            <input id="add-notice" type="submit" name="submit" value="Надіслати">
        </form>
    </div>
</div>