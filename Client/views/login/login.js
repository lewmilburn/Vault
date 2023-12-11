function doLogin() {
    let data = {
        pass: $('#pass').val(),
        user: $('#user').val()
    };

    $.ajax({
        url: vaultUrl + '/api/vault/',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(data),
        success: function (xhr) {
            alert(xhr.responseText)
        },
        error: function (xhr) {
            alert(xhr.responseText)
        }
    });
}