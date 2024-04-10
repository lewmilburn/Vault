/**
 * @name fileExists.js
 * @description Checks if a file exists.
 *
 * @param file
 * @param data
 * @returns {boolean}
 */
module.exports = function (file) {
    let fs = require('fs');

    try {
        return fs.existsSync(file);
    } catch(error) {
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return true;
}