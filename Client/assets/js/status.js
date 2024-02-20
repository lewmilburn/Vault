function checkStatus() {
    if (localStorage.getItem('using-cache') === 'false') {
        let url = vaultUrl + '/api/status/';
        fetch(url, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        }).then(response => response.json())
            .then(jsonResponse => {
                console.log(jsonResponse);
                if (jsonResponse.status !== 200) {
                    isOffline();
                }
            })
            .catch(xhr => {
                isOffline();
            });
    }
}

function checkStatusFirst() {
    if (localStorage.getItem('using-cache') === 'false') {
        console.log('Checking...');
        let url = vaultUrl + '/api/status/';
        fetch(url, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        }).then(response => response.json())
            .then(jsonResponse => {
                console.log(jsonResponse);
                if (jsonResponse.status !== 200) {
                    isOffline();
                } else {
                    loginScreen();
                }
            })
            .catch(xhr => {
                isOffline();
            });
    }
}

function goOnline() {
    localStorage.setItem('using-cache', 'false');
    checkStatus();
    reloadVault();
}