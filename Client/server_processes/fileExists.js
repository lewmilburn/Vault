/**
 * Checks if a file exists.
 *
 * @param file
 * @returns {boolean}
 */
module.exports = function (file) {
    let fs = require('fs');

    try {
        return fs.existsSync(file);
    } catch(error) {
        const {dialog} = require('electron');
        dialog.showErrorBox('Vault Error (4)',error.toString());
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return true;
}