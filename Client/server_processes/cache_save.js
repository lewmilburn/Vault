/**
 * Saves cache to file.
 *
 * @param user
 * @param data
 * @param checksum
 * @param electronApp
 */
module.exports = function (user, data, checksum, electronApp) {
    console.log('[VAULT] Saving cache to file...');
    let dataToSave = {
        "data": data,
        "checksum": checksum
    }

    let fs = require('fs');
    try {
        fs.writeFileSync(require(__dirname + '/path')(electronApp, user+'.cache'), JSON.stringify(dataToSave), 'utf-8');
        console.log('[VAULT] Cache saved to file.');
    } catch(error) {
        const {dialog} = require('electron');
        dialog.showErrorBox('Vault Error (18)',error.toString()+" - More help: bit.ly/vaulterrors");
        console.log('[VAULT] Failed to save cache!');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check the cache file is writeable and try again.');
    }
}