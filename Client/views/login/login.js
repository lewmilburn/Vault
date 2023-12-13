function doLogin() {
    let data = {
        pass: $('#pass').val(),
        user: $('#user').val()
    };

    console.log(data);

    $.ajax({
        url: vaultUrl + '/api/auth/login',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(data),
        success: function (xhr) {
            let jsonResponse = JSON.parse(xhr.responseText);
            if (jsonResponse.status === '200') {
                alert('Success: '+xhr.responseText)
            }
        },
        error: function (xhr) {
            let jsonResponse = JSON.parse(xhr.responseText);
            let errorBox = $('#error');
            
            if (jsonResponse.status === 401 || xhr.status === 401) {
                errorBox.removeClass('hidden');
                errorBox.text('Username or password is incorrect.');
            } else if (jsonResponse.error === 'Already authenticated.') {
                errorBox.removeClass('hidden');
                errorBox.text('Already authenticated, please clear your cookies and try again.');
            } else if (jsonResponse.error === 'Missing required data.') {
                errorBox.removeClass('hidden');
                errorBox.text('Please enter a username and password.');
            } else if (jsonResponse.status === 500 || xhr.status === 500) {
                errorBox.removeClass('hidden');
                errorBox.text('An error occurred on the server whilst trying to authenticate you, please try again.');
            } else if (jsonResponse.status === 404 || xhr.status === 404) {
                errorBox.removeClass('hidden');
                errorBox.text('Unable to connect to Vault, please check your settings and try again.');
            } else {
                errorBox.text('An unexpected error occurred: '+xhr.responseText);
            }
        }
    });
}