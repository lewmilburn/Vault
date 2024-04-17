/**
 * Loads the cache from file.
 * @param user
 * @param electronApp
 * @returns {any|null}
 */
const {dialog} = require("electron");
module.exports = function (user, electronApp) {
    console.log('[VAULT][CACHE] Beginning cache read...')
    let fs = require('fs');

    if (fs.existsSync(require(__dirname + '/path')(electronApp, user+'.cache'))) {
        let cache;
        try {
            cache = fs.readFileSync(require(__dirname + '/path')(electronApp, user+'.cache')).toString();
            console.log('[VAULT][CACHE] Cache read.')
        } catch (e) {
            dialog.showErrorBox('Vault Error (0a)',e.toString()+" - More help: bit.ly/vaulterrors");
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] ' + e.toString());
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
            return null;
        }
        try {
            cache = JSON.parse(cache);
        } catch (e) {
            dialog.showErrorBox('Vault Error (0b)',e.toString()+" - More help: bit.ly/vaulterrors");
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] ' + e.toString());
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
            return null;
        }
        return cache;
    } else {
        try {
            fs.writeFileSync(require(__dirname + '/path')(electronApp, user+'.cache'), '');
        } catch (e) {
            dialog.showErrorBox('Vault Error (1)',e.toString()+" - More help: bit.ly/vaulterrors");
        }
        if (!fs.existsSync(require(__dirname + '/path')(electronApp, user+'.cache'))) {
            dialog.showErrorBox(
                'Vault Error (2)',
                "Unable to create file: "+require(__dirname + '/path')(electronApp, user+'.cache')
            );
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] File not found.');
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
        }
        return null;
    }
}