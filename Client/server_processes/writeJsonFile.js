/**
 * Parses and writes JSON data to file.
 *
 * @param file
 * @param data
 * @returns {boolean}
 */
const {app: electronApp} = require("electron");
module.exports = function (file, data) {
    let fs = require('fs');

    try {
        fs.writeFileSync(file, JSON.stringify(data), 'utf-8');

        if (!fs.existsSync(require(__dirname + '/path')(electronApp, '/vault.json'))) {
            fs.writeFileSync(require(__dirname + '/path')(electronApp, '/vault.json'), JSON.stringify({"configured":true}), 'utf-8');
            if (!fs.existsSync(require(__dirname + '/path')(electronApp, '/vault.json'))) {
                const {dialog} = require('electron');
                dialog.showErrorBox(
                    "Vault Error (10)",
                    "Vault attempted to create a configuration file but was unsuccessful. File: "+
                    require(__dirname + '/path')(electronApp, '/vault.json')+
                    " - More help: bit.ly/vaulterrors")
            }
        }
    } catch(error) {
        const {dialog} = require('electron');
        dialog.showErrorBox('Vault Error (11)',error.toString()+" - More help: bit.ly/vaulterrors");
        console.log('[VAULT] Failed to read JSON file "'+require(__dirname + '/path')(electronApp, '/vault.json')+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+require(__dirname + '/path')(electronApp, '/vault.json')+'" is readable and try again.');
    }

    return true;
}