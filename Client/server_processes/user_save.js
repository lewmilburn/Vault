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
        fs.writeFileSync(require(__dirname + '/path')(electronApp, user + '.json'), JSON.stringify(dataToSave), 'utf-8');
        console.log('[VAULT] User data saved to file.');
    } catch(error) {
        const { dialog } = require('electron');
        dialog.showErrorBox("Vault Error (9)", "Unable to save user file: "+error.toString());
        console.log('[VAULT] Failed to save User data!');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check the User data file is writeable and try again.');
    }
}