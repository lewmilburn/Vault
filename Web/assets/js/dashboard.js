function reloadVault() {
    $('#passwordGrid').empty();
    addNewPasswordButton();
    getVault();
}

function displayPassword(item, strength) {
    let warning;

    if (strength < 8) {
        warning = '<i class="fa-solid fa-triangle-exclamation"></i>';
    } else {
        warning = '';
    }
    let child = '<div class="grid-item-password" x-on:click="\n' +
        '                        open=true;\n' +
        '                        newItem=false;\n' +
        '                        pid=\'' + item.pid + '\';\n' +
        '                        pass=\'' + item.pass + '\';\n' +
        '                        user=\'' + item.user + '\';\n' +
        '                        name=\'' + item.name + '\';\n' +
        '                        url=\'' + item.url + '\';\n' +
        '                        notes=\'' + item.notes + '\';\n' +
        '                        strength=\'' + strength + '\';\n' +
        '                    "><p class="flex-grow">' + item.name + '</p><p>' + warning + '</p></div>';

    $('#passwordGrid').append(child);
}

function displayPasswords(data) {
    if (data !== undefined && data !== null) {
        Object.values(data).forEach((item) => {
            displayPassword(item, strength(item.pass));
        })
    }
}

function addNewPasswordButton() {
    $('#passwordGrid').append('\n' +
        '                    <div class="grid-item-password" x-on:click="\n' +
        '                        open=true;\n' +
        '                        newItem=true;\n' +
        '                        pid=\'\';\n' +
        '                        pass=\'\';\n' +
        '                        user=\'\';\n' +
        '                        name=\'\';\n' +
        '                        url=\'\';\n' +
        '                        notes=\'\';\n' +
        '                        strength=\'\';\n' +
        '                    ">\n' +
        '                        Add a new password\n' +
        '                    </div>');
}

function displayError(message, apiError) {
    if (apiError !== null) {
        let errorObject = JSON.parse(apiError);
        message = message + ' (Error ' + errorObject.status + ' - ' + errorObject.error + ')'
    }

    let errorBox = $('#error');
    errorBox.removeClass('hidden');
    errorBox.text(message);
}

function displaySuccess(message) {
    let successBox = $('#success');
    successBox.removeClass('hidden');
    successBox.text(message);
}

$(document).ready(function() {
    addNewPasswordButton();
    getVault();

    $(":button").click(function(e) {
        if (e.target.value === 'update') {
            updatePassword(e.target.id);
        } else if (e.target.value === 'delete') {
            deletePassword(e.target.id);
        } else if (e.target.value === 'create') {
            createPassword();
        }

    });
});