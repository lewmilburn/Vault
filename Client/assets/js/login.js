function doLogin() {
    let data = {
        username: document.getElementById('user').value,
        password: document.getElementById('pass').value,
        sendall: true
    };

    console.log(data);

    let url = vaultUrl + '/api/auth/login'

    fetch(url, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    }).then(response => response.json())
        .then(jsonResponse => {
            let errorBox = document.getElementById('error');
            if (jsonResponse.status === 200) {
                if (jsonResponse.apikey !== undefined) {
                    localStorage.setItem('name', jsonResponse.name);
                    localStorage.setItem('user', jsonResponse.user);
                    localStorage.setItem('token', jsonResponse.token);
                    localStorage.setItem('key', jsonResponse.apikey);

                    electronAuthenticated();
                } else {
                    errorBox.classList.remove('hidden');
                    errorBox.innerHTML = 'Unable to fetch key, please check the "SEND_ALL_INFO" setting is enabled on the server.';
                }
            } else if (jsonResponse.status === 401) {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'Username or password is incorrect.';
            } else if (jsonResponse.error === 'Already authenticated.') {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'Already authenticated, please clear your cookies and try again.';
            } else if (jsonResponse.error === 'Missing required data.') {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'Please enter a username and password.';
            } else if (jsonResponse.status === 500) {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'An error occurred on the server whilst trying to authenticate you, please try again.';
            } else if (jsonResponse.status === 404) {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'Unable to connect to Vault, please check your settings and try again.';
            } else if (jsonResponse.status === 400) {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'Required data was not recieved by the server, please try again.';
            } else {
                errorBox.classList.remove('hidden');
                errorBox.innerHTML = 'An unexpected error occurred.';
            }
        })
        .catch(xhr => {
            let errorBox = document.getElementById('error');
            errorBox.innerHTML = 'An unexpected error occurred. '+xhr;
        });
}