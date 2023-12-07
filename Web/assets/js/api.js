function getVault (id) {
    $.ajax({
        url: '/api/vault/',
        type: 'GET',
        success: function (data, textStatus, xhr) {
            displayPasswords(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            displayError('Unable to retrieve passwords', xhr.responseText);
        }
    });
}

function createPassword () {
    let password = {
        pass: $('#pass').val(),
        user: $('#user').val(),
        name: $('#name').val(),
        url: $('#url').val(),
        notes: $('#notes').val()
    };

    $.ajax({
        url: '/api/vault/',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(password),
        contentType: "application/json; charset=utf-8",
        success: function (data, textStatus, xhr) {
            reloadVault();
            displaySuccess('Password added.');
        },
        error: function (xhr, textStatus, errorThrown) {
            displayError('Unable to add password', xhr.responseText);
        }
    });
}

function updatePassword (id) {
    let password = {
        pid: id,
        pass: $('#pass').val(),
        user: $('#user').val(),
        name: $('#name').val(),
        url: $('#url').val(),
        notes: $('#notes').val()
    };

    $.ajax({
        url: '/api/vault/',
        type: 'PUT',
        dataType: 'json',
        data: JSON.stringify(password),
        contentType: "application/json; charset=utf-8",
        success: function (data, textStatus, xhr) {
            reloadVault();
            displaySuccess('Password saved.');
        },
        error: function (xhr, textStatus, errorThrown) {
            displayError('Unable to update password', xhr.responseText);
        }
    });
}

function deletePassword (id) {
    $(document).ready(function() {
        let password = {pid: '396da119'};
        $.ajax({
            url: '/api/vault/',
            type: 'DELETE',
            dataType: 'json',
            data: JSON.stringify(password),
            success: function (data, textStatus, xhr) {
                reloadVault();
                displaySuccess('Password deleted.');
            },
            error: function (xhr, textStatus, errorThrown) {
                displayError('Unable to delete password', xhr.responseText);
            }
        });
    });
}