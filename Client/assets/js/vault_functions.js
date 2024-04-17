async function getVault(override = false) {
    await waitForSettings();
    vault = null;
    checksum = null;
    document.getElementById('passwordGrid').innerHTML = '';
    addNewPasswordButton();

    if (localStorage.getItem('using-cache') === 'false' && override === false) {
        await apiGetVault();
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE) || override === true) {
        cacheGetVault();
    } else {
        alert('Vault Error (16) - Unable to access Vault. Please restart Vault and try again. More help: bit.ly/vaulterrors');
        screenRestart();
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

    if (data.pass === undefined || data.pass === null || data.pass.trim() === "") {
        displayError('Please enter a password.')
        return;
    }
    if (data.user === undefined || data.user === null || data.user.trim() === "") {
        displayError('Please enter a username.')
        return;
    }
    if (data.name === undefined || data.name === null || data.name.trim() === "") {
        displayError('Please enter a name.')
        return;
    }
    if (data.url === undefined || data.url === null || data.url.trim() === "") {
        displayError('Please enter a URL.')
        return;
    }

    if (localStorage.getItem('using-cache') === 'false') {
        apiCreatePassword(data);
    } else if (
        localStorage.getItem('using-cache') === 'true' &&
        settings.VAULT.ALLOW_OFFLINE_MODE === "true" &&
        settings.VAULT.FORCE_OFFLINE_MODE !== "true"
    ) {
        alert('Please reconnect to your Vault Server.')
    } else if (settings.VAULT.FORCE_OFFLINE_MODE === "true") {
        cacheCreatePassword(data);
    } else {
        alert('Vault Error (15) - Unable to access Vault. Please restart Vault and try again. More help: bit.ly/vaulterrors');
        screenRestart();
    }
    document.getElementById('closeEditPanel').click();
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

    if (data.pid === undefined || data.pid === null || data.pid.trim() === "") {
        displayError('Unable to access PasswordID, please try again later.')
        return;
    }
    if (data.pass === undefined || data.pass === null || data.pass.trim() === "") {
        displayError('Please enter a password.')
        return;
    }
    if (data.user === undefined || data.user === null || data.user.trim() === "") {
        displayError('Please enter a username.')
        return;
    }
    if (data.name === undefined || data.name === null || data.name.trim() === "") {
        displayError('Please enter a name.')
        return;
    }
    if (data.url === undefined || data.url === null || data.url.trim() === "") {
        displayError('Please enter a URL.')
        return;
    }

    if (localStorage.getItem('using-cache') === 'false') {
        apiUpdatePassword(data);
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE === "true")) {
        cacheUpdatePassword(data);
    } else {
        alert('Vault Error (14) - Unable to access Vault. Please restart Vault and try again. More help: bit.ly/vaulterrors');
        screenRestart();
    }
    document.getElementById('closeEditPanel').click();
}

function deletePassword(id) {

    if (id === undefined || id === null || id.trim() === "") {
        displayError('Unable to access PasswordID, please try again later.')
        return;
    }

    if (localStorage.getItem('using-cache') === 'false') {
        apiDeletePassword(id);
    } else if (
        localStorage.getItem('using-cache') === 'true' &&
        settings.VAULT.ALLOW_OFFLINE_MODE === "true" &&
        settings.VAULT.FORCE_OFFLINE_MODE !== "true"
    ) {
        alert('Please reconnect to your Vault Server.')
    } else if (settings.VAULT.FORCE_OFFLINE_MODE === "true") {
        cacheDeletePassword(id);
    } else {
        alert('Vault Error (17) - Unable to access Vault. Please restart Vault and try again. More help: bit.ly/vaulterrors');
        screenRestart();
    }
    document.getElementById('closeEditPanel').click();
}