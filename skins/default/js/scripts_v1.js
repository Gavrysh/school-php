function hideShowElement(id)
{
    var x = window.document.getElementById(id);
    x.style.display = ((x.style.display == 'none' || x.style.display == undefined) ? 'block' : 'none');
}

function submitAuth()
{
    var out = true;
    var x = document;
    if (x.getElementById('modal-submit-input').onclick) {
        if (x.getElementById('modal-login').value.length < 3 || x.getElementById('modal-login').value.length > 16) {
            x.getElementById('modal-error-login').innerHTML = 'Треба заповнити поле "Логін" (від 3 до 16 символів)';
            out = false;
        }
        if (x.getElementById('modal-pass').value.length < 3 || x.getElementById('modal-pass').value.length > 16) {
            x.getElementById('modal-error-pass').innerHTML = '"Пароль" занадто короткий (від 3 до 16 символів)';
            out = false;
        }
    }
    if (x.getElementById('modal-submit-cancel').onclick) {
        x.getElementById('modal-authorization').style.display = 'none';
        out = false;
    }
    return out;
}

function clearInnerHTML (id)
{
    document.getElementById(id).innerHTML = '';
}

function subInput()
{
    var out = true;
    var x = document;
    if (x.getElementById('modal-login').value.length < 3 || x.getElementById('modal-login').value.length > 16) {
        x.getElementById('modal-error-login').innerHTML = 'Треба заповнити поле "Логін" (від 3 до 16 символів)';
        out = false;
    } else {
        clearInnerHTML('modal-error-login');
    }
    if (x.getElementById('modal-pass').value.length < 3 || x.getElementById('modal-pass').value.length > 16) {
        x.getElementById('modal-error-pass').innerHTML = '"Пароль" занадто короткий (від 3 до 16 символів)';
        out = false;
    } else {
        clearInnerHTML('modal-error-pass');
    }
    return out;
}

function subCancel()
{
    clearInnerHTML('modal-error-login');
    clearInnerHTML('modal-error-pass');
    document.getElementById('modal-authorization').style.display = 'none';
    return false;
}

function checkComment()
{
    var out = true;
    var x = document;
    if (x.getElementById('name').value.length < 3) {
        x.getElementById('error-name').innerHTML = 'Треба вказати ім\'я (від 3 до 16 символів)';
        out = false;
    }
    if (x.getElementById('email').value.length < 6) {
        x.getElementById('error-email').innerHTML = 'Треба вказати e-mail (від 6 до 16 символів)';
        out = false;
    }
    if (x.getElementById('comment').value.length < 6) {
        x.getElementById('error-comment').innerHTML = 'Треба щось написати (від 6 символів)';
        out = false;
    }
    return out;
}

function clearErrors()
{
    var x = document;
    x.getElementById('error-name').innerHTML ='';
    x.getElementById('error-email').innerHTML ='';
    x.getElementById('error-comment').innerHTML = '';
}

function clearInput(id)
{
    document.getElementById(id).value = '';
}

function scrollNote(id)
{
    $('html, body').animate({
        scrollTop: $(id).offset().top
    }, 2000);
}

function addComment()
{
    var x = document;
    clearErrors();
    if (checkComment()) {
        $.ajax({
            url: '/comments/comment?ajax=1',
            type: "POST",
            cache: false,
            timeout: 5000,
            data: {
                name: x.getElementById('name').value,
                email: x.getElementById('email').value,
                comment: x.getElementById('comment').value,
            },
            success: function(msg) {
                var response = JSON.parse(msg);
                if (response.status) {
                    for (var key in response) {
                        if (key != 'status') {
                            x.getElementById('comm-show').innerHTML = x.getElementById('comm-show').innerHTML + '<div class="inner-wrap"><div id="comm-out-name" class="comments-out-name">' + response[key].name + '</div><div class="comments-out-date">' + response[key].date + '</div><div class="comments-out-text">' + response[key].comment + '</div>';
                        }
                    }
                    clearInput('name');
                    clearInput('email');
                    clearInput('comment');
                    x.getElementById('show-info').innerHTML = 'Запис був успішно доданий!';
                    scrollNote('#show-info');
                } else {
                    if (response.name) {
                        x.getElementById('error-name').innerHTML = response.name;
                    }
                    if (response.email) {
                        x.getElementById('error-email').innerHTML = response.email;
                    }
                    if (response.comment) {
                        x.getElementById('error-comment').innerHTML = response.comment;
                    }
                    if (response.user) { 
                        x.getElementById('show-info').innerHTML = response.user;
                        scrollNote('#show-info');
                    }
                }
            },
            error: function(t) {
                if (t === "timeout") {
                    setTimeout(addComment, 10000);
                    x.getElementById('inform').innerHTML = 'Перевищений інтервал очикування відповіді від серверу.';
                } else {
                    x.getElementById('inform').innerHTML = 'Якісь проблеми...';
                }
            }
        })
    }
    return false;
}