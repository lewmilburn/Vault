/**
 * Loads the cache from file.
 * @param user
 * @returns {any|null}
 */
module.exports = function (user) {
    console.log('[VAULT][CACHE] Beginning cache read...')
    let fs = require('fs');

    if (fs.existsSync(user + '.cache')) {
        try {
            let cache = JSON.parse(fs.readFileSync(user + '.cache').toString());
            console.log('[VAULT][CACHE] Cache read.')
            return cache;
        } catch (e) {
            console.warn('[VAULT][CACHE] Error whilst reading cache.');
            console.error('[VAULT][CACHE] ' + e);
            console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
        }
    } else {
        console.warn('[VAULT][CACHE] Error whilst reading cache.');
        console.error('[VAULT][CACHE] File not found.');
        console.warn('[VAULT][CACHE] Please check the file is readable and try again.');
        return null;
    }
}