function reloadVault() {
    $('#passwordGrid').empty();
    getVault();
}

$(document).ready(function() {
    $('#passwordGrid').append('\n' +
        '                    <div class="grid-item-password" x-on:click="\n' +
        '                        open=true;\n' +
        '                        newItem=true;\n' +
        '                        pid=\'\';\n' +
        '                        pass=\'\';\n' +
        '                        user=\'\';\n' +
        '                        name=\'\';\n' +
        '                        url=\'\';\n' +
        '                        notes=\'\';\n' +
        '                    ">\n' +
        '                        Add a new password\n' +
        '                    </div>');
    getVault();

    $(":button").click(function(e) {
        if (e.target.value === 'update') {
            updatePassword(e.target.id);
        } else if (e.target.value === 'delete') {
            deletePassword(e.target.id);
        }
    });
});