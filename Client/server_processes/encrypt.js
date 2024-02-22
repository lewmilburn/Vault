module.exports = function (data, key, settings) {
    console.log('[VAULT][CRYPTO] Encrypting data...')
    const crypto = require('crypto');
    const iv = crypto.randomBytes(32);

    key = key.substring(0, 32)

    let cipher = crypto.createCipheriv(settings.APP.CACHE_ENCRYPTION_METHOD, Buffer.from(key), iv);
    let encrypted = cipher.update(JSON.stringify(data));

    encrypted = Buffer.concat([encrypted, cipher.final()]);

    let tag = cipher.getAuthTag();
    console.log('[VAULT][CRYPTO] Data encrypted.')
    return tag.toString('hex') + "[$]" + iv.toString('hex') + "[$]" + encrypted.toString('hex');
}