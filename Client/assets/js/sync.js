function syncMismatch(local, remote) {
    document.getElementById('syncmismatch').classList.remove('hidden');
    document.getElementById('lastLocalChange').innerText = local;
    document.getElementById('lastRemoteChange').innerText = remote;
    localStorage.setItem('remote_change', remote);
}

function keepLocal() {
    document.getElementById('syncmismatch').classList.add('hidden');
}

function keepRemote() {
    resync();
    reloadVault();
    document.getElementById('syncmismatch').classList.add('hidden');
}