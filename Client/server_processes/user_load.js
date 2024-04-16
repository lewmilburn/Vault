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

    if (fs.existsSync(require(__dirname + '/path')(electronApp, user + '.json'))) {
        try {
            let cache = JSON.parse(fs.readFileSync(require(__dirname + '/path')(electronApp, user + '.json')).toString());
            console.log('[VAULT][USER] User data read.')
            return cache;
        } catch (e) {
            const {dialog} = require('electron');
            dialog.showErrorBox('Vault Error (7)',e.toString());
            console.warn('[VAULT][USER] Error whilst reading user data.');
            console.error('[VAULT][USER] ' + e);
            console.warn('[VAULT][USER] Please check the file is readable and try again.');
        }
    } else {
        console.log('[VAULT][USER] No user data, creating...')
        let date = require(nodePath.join(__dirname + '/currentDate'))();
        require(nodePath.join(__dirname + '/user_save'))(user, date, electronApp);
        let userData = JSON.parse(fs.readFileSync(require(__dirname + '/path')(electronApp, user + '.json')).toString());
        if (!fs.existsSync(require(__dirname + '/path')(electronApp, user + '.json'))) {
            const {dialog} = require('electron');
            dialog.showErrorBox('Vault Error (8)','Unable to create file '+require(__dirname + '/path')(electronApp, user + '.json'));
        }
        console.log('[VAULT][USER] User data read.')
        return userData;
    }
}