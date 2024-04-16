/**
 * Deletes a file.
 *
 * @param file
 * @returns {*}
 */
module.exports = function (file) {
    let fs = require('fs');

    try {
        if (fs.existsSync(file)) {
            fs.rmSync(file);
        }
    } catch(error) {
        const {dialog} = require('electron');
        dialog.showErrorBox('Vault Error (3)',error.toString()+" - More help: bit.ly/vaulterrors");
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }
}