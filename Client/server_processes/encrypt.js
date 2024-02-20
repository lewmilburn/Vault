module.exports = function (data, key) {
    const crypto = require('crypto');
    const iv = crypto.randomBytes(16);

    key = key.substring(0, 32)

    let cipher = crypto.createCipheriv('aes-256-cbc', Buffer.from(key), iv);
    let encrypted = cipher.update(JSON.stringify(data));

    encrypted = Buffer.concat([encrypted, cipher.final()]);
    return { iv: iv.toString('hex'), encryptedData: encrypted.toString('hex') };
}