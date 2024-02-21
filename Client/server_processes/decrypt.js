module.exports = function (text, key) {
    console.log('[VAULT][CRYPTO] Decrypting data...')
    const crypto = require('crypto');

    key = key.substring(0, 32);

    let iv = Buffer.from(text.iv, 'hex');
    let encryptedText = Buffer.from(text.encryptedData, 'hex');
    let decipher = crypto.createDecipheriv('aes-256-cbc', Buffer.from(key), iv);
    let decrypted = decipher.update(encryptedText);

    decrypted = Buffer.concat([decrypted, decipher.final()]);

    console.log('[VAULT][CRYPTO] Data decrypted.')
    return decrypted.toString();
}