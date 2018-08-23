<script>
    window.onload = function () {
        getNotice();
        document.getElementById('add-notice').onclick = addNotice;
    }
</script>
<div class="wrapper-applications">
    <h1>Чат<span>спілкування у реальному часі з іншими відвідувачами сайту</span></h1>
    <div class="inner-wrap">
        <div class="chat-list-users">

        </div>
        <div class="chat">

        </div>
        <div class="clear"></div>

        <div class="smiles">
            <?php
                for ($i = 1; $i <=7; ++$i) : ?>
                    <img id="ch0<?= $i ?>" src="/skins/default/img/ch0<?= $i ?>.png" alt="smile" width="30px" height="30px" onclick="addSmile(this.id)">
                <?php endfor;
            ?>
        </div>

        <form action="" method="post">
            <div id="show-info" class="information"></div>
            <span class="information"><?php if (isset($errors['notice'])) { echo $errors['notice']; } ?></span>
            <label>Повідомлення<input id="notice" type="text" name="notice"></label>
            <input id="add-notice" type="submit" name="submit" value="Надіслати">
        </form>
    </div>
</div>