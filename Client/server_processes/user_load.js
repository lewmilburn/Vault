const fs = require("fs");
const nodePath = require("path");
module.exports = function (user) {
    console.log('[VAULT][USER] Beginning user data read...')

    if (fs.existsSync(user + '.json')) {
        try {
            let cache = JSON.parse(fs.readFileSync(user + '.json').toString());
            console.log('[VAULT][USER] User data read.')
            return cache;
        } catch (e) {
            console.warn('[VAULT][USER] Error whilst reading user data.');
            console.error('[VAULT][USER] ' + e);
            console.warn('[VAULT][USER] Please check the file is readable and try again.');
        }
    } else {
        console.log('[VAULT][USER] No user data, creating...')
        let date = require(nodePath.join(__dirname + '/currentDate'))();
        require(nodePath.join(__dirname + '/user_save'))(user, date, date);
        let userData = JSON.parse(fs.readFileSync(user + '.json', ).toString());
        console.log('[VAULT][USER] User data read.')
        return userData;
    }
}