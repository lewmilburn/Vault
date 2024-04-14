/**
 * Saves user data to file.
 *
 * @param user
 * @param lastchange
 * @param electronApp
 */
module.exports = function (user, lastchange, electronApp) {
    console.log('[VAULT] Saving User data to file...');
    let dataToSave = {
        "last_change": lastchange
    }

    let fs = require('fs');
    try {
        if (fs.existsSync(require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json'))) {
            fs.writeFileSync(require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json'), JSON.stringify(dataToSave), 'utf-8');
        } else {
            const { dialog } = require('electron');
            dialog.showErrorBox("User file does not exist.",dataToSave.toString());
            fs.writeFileSync(require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json'), JSON.stringify(dataToSave), 'utf-8');
            let data = fs.readFileSync(require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json'));
            dialog.showErrorBox("Saved data",data.toString());
        }
        console.log('[VAULT] User data saved to file.');
    } catch(error) {
        console.log('[VAULT] Failed to save User data!');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check the User data file is writeable and try again.');
    }
}