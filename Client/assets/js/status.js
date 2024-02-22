async function checkStatus() {
    await waitForSettings(settings);
    if (localStorage.getItem('using-cache') === 'false') {
        let url = settings.SYNC_SERVER_URL + '/api/status/';
        fetch(url, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        }).then(response => response.json())
            .then(jsonResponse => {
                if (jsonResponse.status !== 200) {
                    screenOffline();
                }
            })
            .catch(() => {
                screenOffline();
            });
    }
}

async function checkStatusFirst() {
    await waitForSettings(settings);
    if (localStorage.getItem('using-cache') === 'false') {
        let url = settings.SYNC_SERVER_URL + '/api/status/';
        fetch(url, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        }).then(response => response.json())
            .then(jsonResponse => {
                if (jsonResponse.status !== 200) {
                    screenOffline();
                } else {
                    screenLogin();
                }
            })
            .catch(() => {
                screenOffline();
            });
    }
}

function goOnline() {
    localStorage.setItem('using-cache', 'false');
    checkStatus().then(() => {});
    reloadVault();
}