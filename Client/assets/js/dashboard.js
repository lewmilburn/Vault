function reloadVault() {
    document.getElementById('passwordGrid').innerHTML = '';
    addNewPasswordButton();
    vault = null;
    checksum = null;
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
    document.getElementById('passwordGrid').innerHTML = '';
    addNewPasswordButton();
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

function getDateTime() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    return year+'-'+month+'-'+day+' '+hours+':'+minutes+':'+seconds
}