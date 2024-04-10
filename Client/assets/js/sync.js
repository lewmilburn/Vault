function syncMismatch(local, remote) {
    document.getElementById('syncmismatch').classList.remove('hidden');
    document.getElementById('lastLocalChange').innerText = local;
    document.getElementById('lastRemoteChange').innerText = remote;
    localStorage.setItem('remote_change', remote);
}

function keepLocal() {
    for (let item in vault) {
        let password = {
            user: localStorage.getItem('user'),
            key: localStorage.getItem('key'),
            data: {
                pid: vault[item].pid,
                pass: vault[item].pass,
                user: vault[item].user,
                name: vault[item].name,
                url: vault[item].url,
                notes: vault[item].notes,
            }
        };
        sendRequest('PUT',password,'Password saved.', 'Unable to update password');
    }
    document.getElementById('syncmismatch').classList.add('hidden');
    resync();
}

function keepRemote() {
    resync();
    reloadVault();
    document.getElementById('syncmismatch').classList.add('hidden');
}