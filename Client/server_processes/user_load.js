const fs = require("fs");
const nodePath = require("path");
/**
 * Loads user data from file.
 *
 * @param user
 * @param electronApp
 * @returns {any}
 */
module.exports = function (user, electronApp) {
    console.log('[VAULT][USER] Beginning user data read...')

    if (fs.existsSync(__dirname + '/../' + user + '.json')) {
        try {
            let cache = JSON.parse(fs.readFileSync(require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json')).toString());
            console.log('[VAULT][USER] User data read.')
            return cache;
        } catch (e) {
            console.warn('[VAULT][USER] Error whilst reading user data.');
            console.error('[VAULT][USER] ' + e);
            console.warn('[VAULT][USER] Please check the file is readable and try again.');
        }
    } else {
        console.log('[VAULT][USER] No user data, creating...')
        const {dialog} = require('electron');
        dialog.showErrorBox('File not found.',require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json'));
        let date = require(nodePath.join(__dirname + '/currentDate'))();
        require(nodePath.join(__dirname + '/user_save'))(user, date, electronApp);
        let userData = JSON.parse(fs.readFileSync(require(__dirname + '/server_processes/path')(electronApp, '/../' + user + '.json')).toString());
        console.log('[VAULT][USER] User data read.')
        return userData;
    }
}