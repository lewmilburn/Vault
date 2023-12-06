function getVault() {
    $.get(
        "/api/vault",
        function (data, status)
        {
            console.log(data);

            Object.values(data).forEach((item) => {
                console.log(item);
                let child = '<div class="grid-item-password" x-on:click="\n' +
                    '                        open=true;\n' +
                    '                        newItem=false;\n' +
                    '                        pid=\''+item.pid+'\';\n' +
                    '                        pass=\''+item.pass+'\';\n' +
                    '                        user=\''+item.user+'\';\n' +
                    '                        name=\''+item.name+'\';\n' +
                    '                        url=\''+item.url+'\';\n' +
                    '                        notes=\''+item.notes+'\';\n' +
                    '                    ">'+item.name+'</div>';

                $('#passwordGrid').append(child);
            })
        }).fail(function(status) {
        alert('An error has occurred: ' + status.statusText);
    });
}

function updatePassword (id) {
    let password = {pid: '396da119', pass: 'a', user: "Test2", name: "HELLO", url: "Test4", notes: "Test5"};
    console.log($.ajax({
        url: '/api/vault',
        type: 'PUT',
        data: password,
        success: function (data, textStatus, xhr) {
            reloadVault();
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error in Operation ' + xhr.responseText);
        }
    }));
}

function deletePassword (id) {
    $(document).ready(function() {
        let password = {pid: '396da119'};
        $.ajax({
            url: '/api/vault',
            type: 'DELETE',
            dataType: 'json',
            data: password,
            success: function (data, textStatus, xhr) {
                reloadVault();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log('Error in Operation ' + errorThrown);
            }
        });
    });
}