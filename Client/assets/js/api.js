async function apiGetVault (override = false) {
    let url = settings.VAULT.SYNC_SERVER_URL + '/api/vault?user=' + localStorage.getItem("user") + '&key=' + localStorage.getItem("key");
    fetch(url, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    }).then(response => response.json())
        .then(jsonResponse => {
            if (jsonResponse.status === undefined) {
                requestUser();
                window.bridge.recieveUserData((event, user) => {
                    if (user.last_change !== jsonResponse.last_change && override === false && settings.VAULT.ALLOW_OFFLINE_MODE === "true") {
                        cacheGetVault(true);
                        localStorage.setItem('remote_vault_temp', JSON.stringify(jsonResponse.data));
                        syncMismatch(user.last_change, jsonResponse.last_change);
                    } else {
                        if (!document.getElementById('syncmismatch').classList.contains('hidden')) {
                            document.getElementById('syncmismatch').classList.add('hidden');
                        }
                        vault = jsonResponse.data;
                        checksum = jsonResponse.checksum;
                        cacheUpdate(jsonResponse);
                        displayPasswords();
                    }
                });
            } else {
                displayError('Unable to retrieve passwords', jsonResponse);
            }
        })
        .catch(xhr => {
            displayError('Unexpected error: ', xhr);
        });
}

function apiCreatePassword (data) {
    let password = {
        user: localStorage.getItem('user'),
        key: localStorage.getItem('key'),
        data,
        time: getDateTime()
    };

    sendRequest('POST',password,'Password added.', 'Unable to add password');
}

function apiUpdatePassword (data) {
    let password = {
        user: localStorage.getItem('user'),
        key: localStorage.getItem('key'),
        data,
        time: getDateTime()
    };
    console.log(password);

    sendRequest('PUT',password,'Password saved.', 'Unable to update password');
}

function apiDeletePassword (id) {
    let password = {
        user: localStorage.getItem('user'),
        key: localStorage.getItem('key'),
        data: {
            pid: id
        },
        time: getDateTime()
    };

    sendRequest('DELETE',password,'Password deleted.', 'Unable to delete password');
}

function sendRequest(type, data, successMessage, errorMessage, noReload = false) {
    let url = settings.VAULT.SYNC_SERVER_URL + '/api/password/';
    fetch(url, {
        method: type,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    }).then(response => response.json())
        .then(jsonResponse => {
            if (jsonResponse.status === 200) {
                displaySuccess(successMessage);

                if (noReload === false) {
                    reloadVault();
                }
            } else {
                if (errorMessage !== null) {
                    displayError(errorMessage,xhr.responseText);
                }
                return false;
            }
        })
        .catch(xhr => {
            displayError(xhr);
        });
}