function checkNotice() {
    if ($('#notice').val().length < 10) {
        $('#show-info').text('Кількість символів у сповіщенні занадто мала.');
        return false;
    }
    return true;
}

function clearText() {
    $('#show-info').text('');
}

function addNotice() {
    // Перевірка інформаційного блоку та очистка
    clearText();

    // Перевірка на кількість символів у сповіщенні
    if (checkNotice()) {
        // Працюємо далі
    } else {
        // Не працюємо далі
    }
    return false;
}