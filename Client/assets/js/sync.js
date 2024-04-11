function syncMismatch(local, remote) {
    document.getElementById('syncmismatch').classList.remove('hidden');
    document.getElementById('lastLocalChange').innerText = local;
    document.getElementById('lastRemoteChange').innerText = remote;
    localStorage.setItem('remote_change', remote);
}

function keepLocal() {
    for (let localItem in vault) {
        password = {
            user: localStorage.getItem('user'),
            key: localStorage.getItem('key'),
            data: {
                pid: vault[localItem].pid,
                pass: vault[localItem].pass,
                user: vault[localItem].user,
                name: vault[localItem].name,
                url: vault[localItem].url,
                notes: vault[localItem].notes,
            }
        };

        sendRequest('PUT', password, '.', '');
    }

    document.getElementById('syncmismatch-msg').classList.add('hidden');
    document.getElementById('syncmismatch-spinner').classList.remove('hidden');

    setTimeout(function() {
        resync();
        document.getElementById('syncmismatch-msg').classList.remove('hidden');
        document.getElementById('syncmismatch-spinner').classList.add('hidden');
        document.getElementById('syncmismatch').classList.add('hidden');
        localStorage.removeItem('remote_change');
        localStorage.removeItem('remote_vault_temp');
        screenDashboard();
    }, 2000);
}

function keepRemote() {
    let url = settings.VAULT.SYNC_SERVER_URL + '/api/vault?user='+localStorage.getItem('user')+'&key='+localStorage.getItem('key')+'&sync='+getDateTime();
    fetch(url, {
        method: 'GET',
        headers: {'Content-Type': 'application/json'},
    }).then(function (r) {
        if (r.status !== 200) {
            alert('Unable to resync, please try again.')
        }
    })
    document.getElementById('syncmismatch-msg').classList.add('hidden');
    document.getElementById('syncmismatch-spinner').classList.remove('hidden');

    setTimeout(function() {
        resync();
        document.getElementById('syncmismatch-msg').classList.remove('hidden');
        document.getElementById('syncmismatch-spinner').classList.add('hidden');
        document.getElementById('syncmismatch').classList.add('hidden');
        localStorage.removeItem('remote_change');
        localStorage.removeItem('remote_vault_temp');
        screenDashboard();
    }, 2000);
}