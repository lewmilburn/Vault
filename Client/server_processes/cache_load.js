/**
 * Loads the cache from file.
 * @param user
 * @returns {any|null}
 */
const {dialog} = require("electron");
module.exports = function (user) {
    console.log('[VAULT][CACHE] Beginning cache read...')
    let fs = require('fs');

    if (fs.existsSync(__dirname + '/../' + user + '.cache')) {
        try {
            let cache = JSON.parse(fs.readFileSync(__dirname + '/../' + user + '.cache').toString());
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
            fs.writeFileSync(__dirname + '/../' + user + '.cache', '');
        } catch (e) {
            dialog.showErrorBox('Error whilst creating cache.',e.toString());
        }
        if (!fs.existsSync(__dirname + '/../' + user + '.json')) {
            dialog.showErrorBox('File not found.',__dirname + '/../' + user + '.cache');
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] File not found.');
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
        }
        return null;
    }
}