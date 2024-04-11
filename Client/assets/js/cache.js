function cacheGetVault() {
    requestCache();

    window.bridge.recieveCache((event, cache) => {
        vault = JSON.parse(JSON.parse(cache)).data;
        displayPasswords();
    });
}

function cacheUpdatePassword(data) {
    for (let element of vault) {
        if (element.pid === data.pid) {
            element.name = data.name;
            element.notes = data.notes;
            element.pass = data.pass;
            element.url = data.url;
            element.user = data.user;
        }
    }

    let cacheToSend = {
        data: vault,
        checksum: checksum,
        last_change: getDateTime()
    }

    cacheUpdate(cacheToSend);
    reloadVault();

    displaySuccess("Password saved.");
}

function cacheCreatePassword(data) {
    data.pid = generateOfflineID();
    console.log(data);
    vault.push(data);

    let cacheToSend = {
        data: vault,
        checksum: checksum,
        last_change: getDateTime()
    }

    cacheUpdate(cacheToSend);
    reloadVault();

    displaySuccess("Password added.");
}

function cacheDeletePassword(id) {
    for (let i = 0; i < vault.length; i++) {
        if (vault[i].pid === id) {
            vault.splice(i, 1);
            break;
        }
    }

    let cacheToSend = {
        data: vault,
        checksum: checksum,
        last_change: getDateTime()
    }

    cacheUpdate(cacheToSend);
    reloadVault();

    displaySuccess("Password deleted.");
}

function generateOfflineID() {
    let id = Math.floor(Math.random() * 9000) + 1000;
    return 'Cx'+id;
}