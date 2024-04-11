async function getVault(override = false) {
    await waitForSettings();
    vault = null;
    checksum = null;
    document.getElementById('passwordGrid').innerHTML = '';
    addNewPasswordButton();

    if (localStorage.getItem('using-cache') === 'false') {
        await apiGetVault();
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE) || override === true) {
        cacheGetVault();
    } else {
        alert('Unable to access Vault. Please restart Vault and try again.')
    }
}

function createPassword() {
    let data = {
        pass: document.getElementById('pass').value,
        user: document.getElementById('user').value,
        name: document.getElementById('name').value,
        url: document.getElementById('url').value,
        notes: document.getElementById('notes').value
    }

    if (localStorage.getItem('using-cache') === 'false') {
        apiCreatePassword(data);
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE)) {
        cacheCreatePassword(data)
    } else {
        alert('Unable to access Vault. Please restart Vault and try again.')
    }
}

function updatePassword(id) {
    let data = {
        pid: id,
        pass: document.getElementById('pass').value,
        user: document.getElementById('user').value,
        name: document.getElementById('name').value,
        url: document.getElementById('url').value,
        notes: document.getElementById('notes').value,
    }

    if (localStorage.getItem('using-cache') === 'false') {
        apiUpdatePassword(data);
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE)) {
        cacheUpdatePassword(data);
    } else {
        alert('Unable to access Vault. Please restart Vault and try again.')
    }
}

function deletePassword(id) {
    if (localStorage.getItem('using-cache') === 'false') {
        apiDeletePassword(id);
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE)) {
        cacheDeletePassword(id);
    } else {
        alert('Unable to access Vault. Please restart Vault and try again.')
    }
}