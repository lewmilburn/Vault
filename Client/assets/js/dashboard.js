function reloadVault() {
    document.getElementById('passwordGrid').innerHTML = '';
    addNewPasswordButton();
    getVault();
}

function displayPassword(item, strength) {
    let warning;

    if (strength < 8) {
        warning = '<i class="fa-solid fa-triangle-exclamation"></i>';
    } else {
        warning = '';
    }
    let passwordGrid = document.getElementById('passwordGrid');

    let newElem = document.createElement('div');

    newElem.className = 'grid-item-password';
    newElem.setAttribute('x-on:click', `
        open=true;
        newItem=false;
        pid='${item.pid}';
        pass='${item.pass}';
        user='${item.user}';
        name='${item.name}';
        url='${item.url}';
        notes='${item.notes}';
        strength='${strength}';
    `);

    newElem.innerHTML = '<p class="flex-grow">' + item.name + '</p><p>' + warning + '</p>';

    passwordGrid.appendChild(newElem);
}

async function displayPasswords() {
    if (vault !== undefined && vault !== null) {
        Object.values(vault).forEach((item) => {
            displayPassword(item, strength(item.pass));
        })
    }
}

function addNewPasswordButton() {
    let passwordGrid = document.getElementById('passwordGrid');

    let newChild = document.createElement('div');
    newChild.className = 'grid-item-password';
    newChild.setAttribute('x-on:click', `
        open=true;
        newItem=true;
        pid='';
        pass='';
        user='';
        name='';
        url='';
        notes='';
        strength='';
    `);

    newChild.innerHTML = 'Add a new password';

    passwordGrid.appendChild(newChild);
}

function displayError(message, apiError) {
    console.log(message, apiError);
    if (apiError !== undefined) {
        message = message + ' (Error ' + apiError.status + ' - ' + apiError.error + ')'
    }

    let errorBox = document.getElementById('error');
    errorBox.classList.remove('hidden');
    errorBox.innerHTML = message;
}

function displaySuccess(message) {
    let successBox = document.getElementById('success');
    successBox.classList.remove('hidden');
    successBox.innerText = message;
}

document.addEventListener('DOMContentLoaded', function () {
    addNewPasswordButton();
    getVault();

    document.querySelectorAll('button').forEach(function (button) {
        button.addEventListener('click', function (e) {
            if (e.target.value === 'update') {
                updatePassword(e.target.id);
            } else if (e.target.value === 'delete') {
                deletePassword(e.target.id);
            } else if (e.target.value === 'create') {
                createPassword();
            }
        });
    });
});
