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
        alert('Vault Error (16) - Unable to access Vault. Please restart Vault and try again.');
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

    if (localStorage.getItem('using-cache') === 'false') {
        apiCreatePassword(data);
    } else if (
        localStorage.getItem('using-cache') === 'true' &&
        settings.VAULT.ALLOW_OFFLINE_MODE === "true" &&
        settings.VAULT.FORCE_OFFLINE_MODE !== "true"
    ) {
        alert('Please reconnect to your Vault Sync Server.')
    } else if (settings.VAULT.FORCE_OFFLINE_MODE === "true") {
        cacheCreatePassword(data);
    } else {
        alert('Vault Error (15) - Unable to access Vault. Please restart Vault and try again.');
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
    console.log(data);

    if (localStorage.getItem('using-cache') === 'false') {
        apiUpdatePassword(data);
    } else if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE === "true")) {
        cacheUpdatePassword(data);
    } else {
        alert('Vault Error (14) - Unable to access Vault. Please restart Vault and try again.');
        screenRestart();
    }
    document.getElementById('closeEditPanel').click();
}

function deletePassword(id) {
    if (localStorage.getItem('using-cache') === 'false') {
        apiDeletePassword(id);
    } else if (
        localStorage.getItem('using-cache') === 'true' &&
        settings.VAULT.ALLOW_OFFLINE_MODE === "true" &&
        settings.VAULT.FORCE_OFFLINE_MODE !== "true"
    ) {
        alert('Please reconnect to your Vault Sync Server.')
    } else if (settings.VAULT.FORCE_OFFLINE_MODE === "true") {
        cacheDeletePassword(id);
    } else {
        alert('Vault Error (17) - Unable to access Vault. Please restart Vault and try again.');
        screenRestart();
    }
    document.getElementById('closeEditPanel').click();
}