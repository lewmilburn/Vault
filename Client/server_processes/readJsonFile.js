/**
 * @name readJsonFile.js
 * @description Reads and parses a JSON file.
 *
 * @param file
 * @returns {*}
 */
module.exports = function (file) {
    let fs = require('fs');
    const {dialog} = require('electron');

    let json;

    try {
        if (!fs.existsSync(file)) {
            dialog.showErrorBox('Vault Error - File "'+file+'" does not exist.');
            JSON.parse(fs.writeFileSync(file, '','utf-8'));
            json = JSON.parse(fs.readFileSync(file, 'utf-8'));
        } else {
            json = JSON.parse(fs.readFileSync(file, 'utf-8'));
        }
    } catch(error) {
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return json;
}