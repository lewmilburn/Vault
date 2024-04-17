function doLogin() {
    let data = {
        username: document.getElementById('user').value,
        password: document.getElementById('pass').value,
        code: document.getElementById('code').value,
        sendall: true
    };

    let url = settings.VAULT.SYNC_SERVER_URL + '/api/auth/login'

    fetch(url, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    }).then(response => response.json())
        .then(jsonResponse => {
            if (jsonResponse.status === 200) {
                if (jsonResponse.apikey !== undefined) {
                    localStorage.setItem('name', jsonResponse.name);
                    localStorage.setItem('user', jsonResponse.user);
                    localStorage.setItem('token', jsonResponse.token);
                    localStorage.setItem('key', jsonResponse.apikey);

                    screenDashboard();
                } else {
                    displayError('Unable to fetch key, please check your server is online, restart Vault, and try again.');
                }
            } else if (jsonResponse.status === 401) {
                displayError('Username or password is incorrect.');
            } else if (jsonResponse.error === 'Already authenticated.') {
                displayError('Already authenticated, please clear your cookies and try again.');
            } else if (jsonResponse.error === 'Missing required data.') {
                displayError('Please enter a username and password.');
            } else if (jsonResponse.error === 'Two-factor authentication code does not match.') {
                displayError('Incorrect username, password, or two-factor authentication code.');
            } else if (jsonResponse.status === 500) {
                displayError('An error occurred on the server whilst trying to authenticate you, please try again.');
            } else if (jsonResponse.status === 404) {
                displayError('Unable to connect to Vault, please check your settings and try again.');
            } else if (jsonResponse.status === 400) {
                displayError('Required data was not received by the server, please try again.');
            } else if (jsonResponse.status === 403) {
                displayError('Incorrect username, password, or two-factor authentication code.');
            } else if (jsonResponse.status === 302) {
                displayError('The server responded with error 302, this indicates that the Vault Server has been moved. ' +
                    'Please check your installation and try again.');
            } else {
                displayError('An unexpected error occurred.');
            }
        })
        .catch(xhr => {
            let errorBox = document.getElementById('error');
            errorBox.innerHTML = 'An unexpected error occurred. '+xhr;
        });
}