/**
 * @name deleteJsonFile.js
 * @description Deletes a file.
 *
 * @param file
 * @returns {*}
 */
module.exports = function (file) {
    let fs = require('fs');

    let json;

    try {
        fs.rmSync(file);
    } catch(error) {
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return json;
}