/**
 * @name decrypt.js
 * @description Decrypts user data from the cache.
 * @see encrypt.js
 * @see cache_load.js
 * @see cache_savae.js
 *
 * @param data
 * @param key
 * @param settings
 * @returns {string}
 */
module.exports = function (data, key, settings) {
    console.log('[VAULT][CRYPTO] Decrypting data...')
    const crypto = require('crypto');

    let splitData = data.split("[$]");
    let tag = Buffer.from(splitData[0], 'hex');
    let iv = Buffer.from(splitData[1], 'hex');
    let encryptedData = splitData[2];

    key = key.substring(0, 32);

    let decryptIv = Buffer.from(iv);
    let encryptedText = Buffer.from(encryptedData, 'hex');
    let decipher = crypto.createDecipheriv(settings.APP.CACHE_ENCRYPTION_METHOD, Buffer.from(key), decryptIv);
    decipher.setAuthTag(tag);
    let decrypted = decipher.update(encryptedText);

    decrypted = Buffer.concat([decrypted, decipher.final()]);

    console.log('[VAULT][CRYPTO] Data decrypted.')
    return decrypted.toString();
}