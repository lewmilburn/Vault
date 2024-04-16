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
        try {
            let cache = JSON.parse(fs.readFileSync(require(__dirname + '/path')(electronApp, user+'.cache')).toString());
            console.log('[VAULT][CACHE] Cache read.')
            return cache;
        } catch (e) {
            dialog.showErrorBox('Error whilst reading cache.',e.toString());
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] ' + e.toString());
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
        }
    } else {
        try {
            fs.writeFileSync(require(__dirname + '/path')(electronApp, user+'.cache'), '');
        } catch (e) {
            dialog.showErrorBox('Vault Error (1)',e.toString());
        }
        if (!fs.existsSync(require(__dirname + '/path')(electronApp, user+'.cache'))) {
            dialog.showErrorBox(
                'Vault Error.',
                "Unable to create file: "+require(__dirname + '/path')(electronApp, user+'.cache')
            );
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] File not found.');
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
        }
        return null;
    }
}