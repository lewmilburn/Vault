async function getVault () {
    await waitForSettings();
    if (localStorage.getItem('using-cache') === 'false') {
        let url = settings.SYNC_SERVER_URL + '/api/vault?user=' + localStorage.getItem("user") + '&key=' + localStorage.getItem("key");
        fetch(url, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        }).then(response => response.json())
            .then(jsonResponse => {
                if (jsonResponse.status === undefined) {
                    vault = jsonResponse.data;
                    checksum = jsonResponse.checksum;
                    cacheUpdate(jsonResponse);
                    displayPasswords();
                } else {
                    displayError('Unable to retrieve passwords', jsonResponse);
                }
            })
            .catch(xhr => {
                displayError('Unexpected error: ', xhr);
            });
    } else {
        loadCache();
    }
}

function createPassword () {
    let password = {
        user: localStorage.getItem('user'),
        key: localStorage.getItem('key'),
        data: {
            pass: document.getElementById('pass').value,
            user: document.getElementById('user').value,
            name: document.getElementById('name').value,
            url: document.getElementById('url').value,
            notes: document.getElementById('notes').value
        }
    };
    sendRequest('POST',password,'Password added.', 'Unable to add password');
}

function updatePassword (id) {
    let password = {
        user: localStorage.getItem('user'),
        key: localStorage.getItem('key'),
        data: {
            pid: id,
            pass: document.getElementById('pass').value,
            user: document.getElementById('user').value,
            name: document.getElementById('name').value,
            url: document.getElementById('url').value,
            notes: document.getElementById('notes').value,
        }
    };
    console.log(password);
    sendRequest('PUT',password,'Password saved.', 'Unable to update password');
}

function deletePassword (id) {
    let password = {
        user: localStorage.getItem('user'),
        key: localStorage.getItem('key'),
        data: {
            pid: id
        }
    };
    sendRequest('DELETE',password,'Password deleted.', 'Unable to delete password');
}

function sendRequest(type, data, successMessage, errorMessage, noReload = false) {
    let url = settings.SYNC_SERVER_URL + '/api/password/';
    fetch(url, {
        method: type,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    }).then(response => response.json())
        .then(jsonResponse => {
            console.log(jsonResponse);
            if (jsonResponse.status === 200) {
                displaySuccess(successMessage);

                if (noReload === false) {
                    reloadVault();
                }
            } else {
                if (errorMessage !== null) {
                    displayError(errorMessage,xhr.responseText);
                }
            }
        })
        .catch(xhr => {
            displayError(errorMessage);
            console.log(xhr);
        });
}