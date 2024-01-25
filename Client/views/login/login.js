function doLogin() {
    let data = {
        username: document.getElementById('user').value,
        password: document.getElementById('pass').value
    };

    console.log(data);

    let url = vaultUrl + '/api/auth/login'

    fetch(url, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    }).then(response => response.json())
        .then(jsonResponse => {
            console.log(jsonResponse);
            if (jsonResponse.status === 200) {
                localStorage.setItem('user', jsonResponse.user);

                electronAuthenticated();
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
                errorBox.innerHTML = 'An unexpected error occurred.';
            }
        })
        .catch(xhr => {
            let errorBox = document.getElementById('error');
            errorBox.innerHTML = 'An unexpected error occurred.';
        });
}