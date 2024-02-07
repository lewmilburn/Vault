function createPassword () {
    let password = {
        pass: $('#pass').val(),
        user: $('#user').val(),
        name: $('#name').val(),
        url: $('#url').val(),
        notes: $('#notes').val()
    };
    sendRequest('POST',password,'Password added.', 'Unable to add password');
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
    sendRequest('PUT',password,'Password saved.', 'Unable to update password');
}

function deletePassword (id) {
    let password = {pid: id};
    sendRequest('DELETE',password,'Password deleted.', 'Unable to delete password');
}

function sendRequest(type, data, successMessage, errorMessage, noReload = false) {
    $.ajax({
        url: '/api/vault/',
        type: type,
        dataType: 'json',
        data: JSON.stringify(data),
        success: function () {
            if (noReload === false) {
                reloadVault();
            }

            if (successMessage !== null) {
                displaySuccess(successMessage);
            }
        },
        error: function (xhr) {
            if (errorMessage !== null) {
                displayError(errorMessage+' ('+xhr.responseText+')');
            }
        }
    });
}