/**
 * Reads and parses a JSON file.
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
            fs.writeFileSync(file, '','utf-8');
            if (!fs.existsSync(file)) {
                dialog.showErrorBox(
                    "File '"+file+"' does not exist.",
                    "Vault attempted to create the file but was unable to."
                );
                return undefined;
            } else {
                json = JSON.parse(fs.readFileSync(file, 'utf-8'));
            }
            json = JSON.parse(fs.readFileSync(file, 'utf-8'));
        } else {
            json = JSON.parse(fs.readFileSync(file, 'utf-8'));
        }
    } catch(error) {
        const {dialog} = require('electron');
        dialog.showErrorBox('File not found.',file);
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return json;
}