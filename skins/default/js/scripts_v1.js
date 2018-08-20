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