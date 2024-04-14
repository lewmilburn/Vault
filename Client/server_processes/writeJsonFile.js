/**
 * Parses and writes JSON data to file.
 *
 * @param file
 * @param data
 * @returns {boolean}
 */
module.exports = function (file, data) {
    let fs = require('fs');

    try {
        fs.writeFileSync(file, JSON.stringify(data), 'utf-8');

        if (!fs.existsSync(__dirname + '/../' + 'vault.json')) {
            fs.writeFileSync(__dirname + '/../' + 'vault.json', JSON.stringify({"configured":true}), 'utf-8');
            if (!fs.existsSync(__dirname + '/../' + 'vault.json')) {
                const {dialog} = require('electron');
                dialog.showErrorBox(
                    "Vault is unable to initialize.",
                    "Vault attempted to create a configuration file but was unsuccessful.")
            }
        }
    } catch(error) {
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return true;
}